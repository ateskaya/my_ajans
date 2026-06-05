<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiChatController extends Controller
{
    /**
     * Send a message to the Gemini-powered agency assistant.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'reply' => 'AI asistan henüz yapılandırılmadı. Lütfen yönetici ile iletişime geçin.',
            ], 503);
        }

        $systemPrompt = $this->buildSystemPrompt();
        $model = config('services.gemini.model', 'gemini-2.5-flash');

        try {
            $response = Http::timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->withQueryParameters(['key' => $apiKey])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'systemInstruction' => [
                            'parts' => [
                                ['text' => $systemPrompt],
                            ],
                        ],
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [
                                    ['text' => $validated['message']],
                                ],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 8192,
                        ],
                    ],
                );

            if (! $response->successful()) {
                Log::warning('Gemini API error', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return response()->json([
                    'reply' => 'Şu an yanıt üretilemiyor. Lütfen biraz sonra tekrar deneyin veya iletişim formunu kullanın.',
                ], 502);
            }

            $body = $response->json();
            $aiText = $this->extractGeminiText($body);
            $finishReason = data_get($body, 'candidates.0.finishReason');

            if (empty($aiText)) {
                return response()->json([
                    'reply' => 'Yanıt alınamadı. Lütfen sorunuzu farklı şekilde ifade edin.',
                ], 502);
            }

            $aiText = trim($aiText);
            $aiText = preg_replace('/#iletisim\b/i', '/iletisim', $aiText) ?? $aiText;
            $aiText = preg_replace('/#hizmetler\b/i', '/hizmetler', $aiText) ?? $aiText;
            $aiText = preg_replace(
                '/#vaka-calismalari\b/i',
                '/vaka-calismalari',
                $aiText
            ) ?? $aiText;

            if ($finishReason === 'MAX_TOKENS') {
                Log::info('Gemini response truncated', ['length' => strlen($aiText)]);
                $aiText .= "\n\nDetaylı bilgi ve teklif için lütfen sayfanın altındaki iletişim formunu doldurun.";
            }

            return response()->json([
                'reply' => $aiText,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gemini chat exception', ['message' => $e->getMessage()]);

            return response()->json([
                'reply' => 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.',
            ], 500);
        }
    }

    /**
     * @param  array<string, mixed>|null  $responseData
     */
    private function extractGeminiText(?array $responseData): ?string
    {
        $parts = data_get($responseData, 'candidates.0.content.parts', []);

        if (! is_array($parts) || $parts === []) {
            return null;
        }

        $chunks = [];

        foreach ($parts as $part) {
            if (empty($part['text'])) {
                continue;
            }

            if (! empty($part['thought'])) {
                continue;
            }

            $chunks[] = $part['text'];
        }

        if ($chunks === []) {
            foreach ($parts as $part) {
                if (! empty($part['text'])) {
                    $chunks[] = $part['text'];
                }
            }
        }

        return $chunks !== [] ? implode("\n", $chunks) : null;
    }

    private function buildSystemPrompt(): string
    {
        $services = Service::query()
            ->where('is_active', true)
            ->get(['title', 'excerpt']);

        $caseStudies = CaseStudy::query()
            ->get(['title', 'problem', 'solution', 'impact_metrics']);

        $servicesText = $services->map(function (Service $service) {
            return "- {$service->title}: {$service->excerpt}";
        })->implode("\n");

        $caseStudiesText = $caseStudies->map(function (CaseStudy $study) {
            $metrics = $study->impact_metrics
                ? json_encode($study->impact_metrics, JSON_UNESCAPED_UNICODE)
                : '—';

            return "- {$study->title}: ".Str::limit($study->problem, 120)
                .' → Çözüm: '.Str::limit($study->solution, 120)
                ." (Etki: {$metrics})";
        })->implode("\n");

        return <<<PROMPT
Sen profesyonel bir yazılım ajansının AI asistanısın. Görevin, müşterileri bilgilendirmek ve iletişim formunu doldurmaya yönlendirmek.

Hizmetlerimiz:
{$servicesText}

Başarı hikayelerimiz:
{$caseStudiesText}

Kurallar:
- Sadece yukarıdaki verilere dayanarak cevap ver; bilmediğin konularda uydurma.
- Nazik, kurumsal ve ikna edici Türkçe kullan.
- Yanıtını en fazla 4-5 tam cümle ile ver; mutlaka bitmiş cümlelerle sonlandır.
- Mobil uygulama talepleri için "Özel Yazılım Geliştirme" hizmetimizden bahset.
- İletişim için mutlaka "/iletisim" ifadesini kullan (ör: "iletişim formumuz: /iletisim"). Hash (#) kullanma.
- Hizmetler için "/hizmetler", vaka çalışmaları için "/vaka-calismalari" yollarını önerebilirsin.
PROMPT;
    }
}
