<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiArticleService
{
    /**
     * @return array{title: string, content: string}|null
     */
    public function generateFromSource(string $sourceTitle, string $sourceDescription, string $sourceUrl): ?array
    {
        $userPrompt = <<<PROMPT
Kaynak başlık: {$sourceTitle}
Kaynak açıklama: {$sourceDescription}
Kaynak URL: {$sourceUrl}

Bu haberi ajans blogu için Türkçe özgün makaleye dönüştür.
PROMPT;

        $systemPrompt = <<<'PROMPT'
Sen profesyonel bir yazılım firmasının SEO içerik üreticisisin. Sana verilen yabancı teknoloji/yazılım haberini analiz et ve ajansımızın blogunda yayınlanacak şekilde, Türkçe, kurumsal, akıcı ve SEO uyumlu 3-4 paragraflık özgün bir makaleye dönüştür. İçeriğe uygun bir başlık üret.

Yanıtını YALNIZCA geçerli JSON olarak ver, başka metin ekleme:
{"title": "Makale Başlığı", "content": "<p>Paragraf...</p><p>Paragraf...</p>"}
PROMPT;

        return $this->requestArticleJson($systemPrompt, $userPrompt);
    }

    /**
     * @return array{title: string, content: string, meta_description: string}|null
     */
    public function generateLocalSeoArticle(string $primaryKeyword, ?string $angle = null): ?array
    {
        $brand = config('local_seo.brand', 'Otonoma');
        $city = config('local_seo.city', 'Bursa');
        $district = config('local_seo.district', 'Nilüfer');
        $angleText = $angle ?? "Bursa ve {$district} bölgesindeki işletmeler için {$primaryKeyword} odağında kapsamlı rehber";

        $userPrompt = <<<PROMPT
Birincil anahtar kelime: {$primaryKeyword}
Şehir: {$city}
İlçe: {$district}
Marka adı (doğal şekilde en fazla 2 kez geçsin): {$brand}
Makale odağı: {$angleText}
PROMPT;

        $systemPrompt = <<<'PROMPT'
Sen Türkiye'deki bir B2B yazılım ajansının yerel SEO içerik uzmanısın. Verilen anahtar kelime için Türkçe, özgün, kurumsal ve bilgilendirici bir blog makalesi yaz.

Kurallar:
- En az 1.200 kelime hedefle (6-10 paragraf + alt başlıklar)
- HTML kullan: <h2>, <h3>, <p>, <ul><li>, <strong> — markdown kullanma
- Birincil anahtar kelimeyi başlıkta, ilk paragrafta ve makale boyunca doğal şekilde 4-8 kez kullan
- Bursa ve Nilüfer bağlamını somut örneklerle işle (yerel işletme, KOBİ, sanayi, e-ticaret vb.)
- Satış baskısı yapma; uzman rehber tonu kullan
- Son bölümde kısa bir "Sonuç" veya "Özet" ekle
- Anahtar kelime doldurma (keyword stuffing) yapma

Yanıtını YALNIZCA geçerli JSON olarak ver:
{"title": "SEO uyumlu makale başlığı", "meta_description": "155-160 karakter arası meta açıklama", "content": "<h2>...</h2><p>...</p>..."}
PROMPT;

        $result = $this->requestArticleJson($systemPrompt, $userPrompt, maxTokens: 16384);

        if ($result === null) {
            return null;
        }

        if (empty($result['meta_description'])) {
            $plain = strip_tags($result['content']);
            $result['meta_description'] = Str::limit(preg_replace('/\s+/', ' ', $plain) ?? '', 158, '…');
        }

        return $result;
    }

    /**
     * @return array{title: string, content: string, meta_description?: string}|null
     */
    private function requestArticleJson(string $systemPrompt, string $userPrompt, int $maxTokens = 8192): ?array
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('GEMINI_API_KEY is not configured.');

            return null;
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');

        try {
            $response = Http::timeout(120)
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
                            'temperature' => 0.65,
                            'maxOutputTokens' => $maxTokens,
                            'responseMimeType' => 'application/json',
                        ],
                    ],
                );

            if (! $response->successful()) {
                Log::warning('Gemini article generation failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return null;
            }

            $rawText = $this->extractText($response->json());

            if (empty($rawText)) {
                return null;
            }

            return $this->parseArticleJson($rawText);
        } catch (\Throwable $e) {
            Log::error('Gemini article exception', ['message' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * @param  array<string, mixed>|null  $responseData
     */
    private function extractText(?array $responseData): ?string
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
     * @return array{title: string, content: string, meta_description?: string}|null
     */
    private function parseArticleJson(string $rawText): ?array
    {
        $cleaned = trim($rawText);
        $cleaned = preg_replace('/^```json\s*/i', '', $cleaned) ?? $cleaned;
        $cleaned = preg_replace('/\s*```$/', '', $cleaned) ?? $cleaned;

        $decoded = json_decode($cleaned, true);

        if (! is_array($decoded) || empty($decoded['title']) || empty($decoded['content'])) {
            Log::warning('Invalid Gemini article JSON', ['raw' => Str::limit($rawText, 500)]);

            return null;
        }

        $article = [
            'title' => trim($decoded['title']),
            'content' => trim($decoded['content']),
        ];

        if (! empty($decoded['meta_description'])) {
            $article['meta_description'] = trim($decoded['meta_description']);
        }

        return $article;
    }
}
