<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AnalyzerController extends Controller
{
    /**
     * Analyze a target website and return an AI-generated report.
     */
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:2048'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $url = $this->normalizeUrl($validated['url']);

        if (! $this->isUrlAllowed($url)) {
            return response()->json([
                'message' => 'Geçersiz veya izin verilmeyen URL. Lütfen herkese açık bir http/https adresi girin.',
            ], 422);
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; AjansSiteAnalyzer/1.0)',
                    'Accept' => 'text/html,application/xhtml+xml',
                ])
                ->get($url);

            if (! $response->successful()) {
                return response()->json([
                    'message' => 'Siteye erişilemedi. URL\'yi kontrol edip tekrar deneyin.',
                ], 422);
            }

            $plainText = strip_tags($response->body());
            $plainText = preg_replace('/\s+/', ' ', $plainText) ?? $plainText;
            $plainText = trim($plainText);

            if (strlen($plainText) < 50) {
                return response()->json([
                    'message' => 'Siteden yeterli metin içeriği alınamadı. Farklı bir sayfa deneyin.',
                ], 422);
            }

            $contentSample = Str::limit($plainText, 3000, '');
        } catch (\Throwable $e) {
            Log::warning('Site analyzer fetch failed', [
                'url' => $url,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Site içeriği çekilirken hata oluştu. URL geçerli mi kontrol edin.',
            ], 422);
        }

        $report = $this->analyzeWithGemini($contentSample, $url);

        if ($report === null) {
            return response()->json([
                'message' => 'AI analizi şu an tamamlanamadı. Lütfen biraz sonra tekrar deneyin.',
            ], 502);
        }

        Lead::create([
            'name' => 'Analiz Aracı',
            'email' => $validated['email'],
            'message' => 'URL: '.$url.'. Skor: '.$report['score'],
            'status' => 'new',
        ]);

        return response()->json($report);
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        if (! preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://'.$url;
        }

        return $url;
    }

    private function isUrlAllowed(string $url): bool
    {
        $parts = parse_url($url);

        if (! is_array($parts) || empty($parts['host'])) {
            return false;
        }

        $scheme = strtolower($parts['scheme'] ?? '');

        if (! in_array($scheme, ['http', 'https'], true)) {
            return false;
        }

        $host = strtolower($parts['host']);

        $blockedHosts = ['localhost', '127.0.0.1', '0.0.0.0', '[::1]'];

        if (in_array($host, $blockedHosts, true)) {
            return false;
        }

        if (str_ends_with($host, '.local') || str_ends_with($host, '.internal')) {
            return false;
        }

        $resolved = gethostbyname($host);

        if ($resolved !== $host && filter_var($resolved, FILTER_VALIDATE_IP)) {
            if (! filter_var(
                $resolved,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            )) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array{score: int, seo_feedback: string, tech_feedback: string, ai_potential: string}|null
     */
    private function analyzeWithGemini(string $contentSample, string $url): ?array
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('GEMINI_API_KEY is not configured for site analyzer.');

            return null;
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');

        $systemPrompt = <<<'PROMPT'
Sen kıdemli bir yazılım mimarısın. Sana verilen şu web sitesi içeriğini analiz et. Bana sadece şu yapıda bir JSON dön: {"score": 75, "seo_feedback": "kısa seo analizi", "tech_feedback": "modernleşme ve hız analizi", "ai_potential": "bu siteye eklenebilecek yapay zeka/otomasyon vizyonu"}.
PROMPT;

        $userPrompt = "Analiz edilecek site URL: {$url}\n\nSayfa metin özeti:\n{$contentSample}";

        try {
            $response = Http::timeout(90)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->withQueryParameters(['key' => $apiKey])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'systemInstruction' => [
                            'parts' => [['text' => $systemPrompt]],
                        ],
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [['text' => $userPrompt]],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.5,
                            'maxOutputTokens' => 2048,
                            'responseMimeType' => 'application/json',
                        ],
                    ],
                );

            if (! $response->successful()) {
                Log::warning('Gemini site analyzer failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            $rawText = $this->extractGeminiText($response->json());

            if (empty($rawText)) {
                return null;
            }

            return $this->parseReportJson($rawText);
        } catch (\Throwable $e) {
            Log::error('Gemini site analyzer exception', ['message' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * @param  array<string, mixed>|null  $responseData
     */
    private function extractGeminiText(?array $responseData): ?string
    {
        $parts = data_get($responseData, 'candidates.0.content.parts', []);

        foreach ($parts as $part) {
            if (! empty($part['text']) && empty($part['thought'])) {
                return trim($part['text']);
            }
        }

        foreach ($parts as $part) {
            if (! empty($part['text'])) {
                return trim($part['text']);
            }
        }

        return null;
    }

    /**
     * @return array{score: int, seo_feedback: string, tech_feedback: string, ai_potential: string}|null
     */
    private function parseReportJson(string $rawText): ?array
    {
        $cleaned = trim($rawText);
        $cleaned = preg_replace('/^```json\s*/i', '', $cleaned) ?? $cleaned;
        $cleaned = preg_replace('/\s*```$/', '', $cleaned) ?? $cleaned;

        $decoded = json_decode($cleaned, true);

        if (! is_array($decoded)) {
            Log::warning('Invalid site analyzer JSON', ['raw' => Str::limit($rawText, 500)]);

            return null;
        }

        $score = isset($decoded['score']) ? (int) $decoded['score'] : null;

        if ($score === null) {
            return null;
        }

        $score = max(0, min(100, $score));

        $seo = trim((string) ($decoded['seo_feedback'] ?? ''));
        $tech = trim((string) ($decoded['tech_feedback'] ?? ''));
        $ai = trim((string) ($decoded['ai_potential'] ?? ''));

        if ($seo === '' || $tech === '' || $ai === '') {
            return null;
        }

        return [
            'score' => $score,
            'seo_feedback' => $seo,
            'tech_feedback' => $tech,
            'ai_potential' => $ai,
        ];
    }
}
