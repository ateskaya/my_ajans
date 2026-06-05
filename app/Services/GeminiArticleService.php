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
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            Log::warning('GEMINI_API_KEY is not configured.');

            return null;
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');
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
                            'temperature' => 0.7,
                            'maxOutputTokens' => 8192,
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
     * @return array{title: string, content: string}|null
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

        return [
            'title' => trim($decoded['title']),
            'content' => trim($decoded['content']),
        ];
    }
}
