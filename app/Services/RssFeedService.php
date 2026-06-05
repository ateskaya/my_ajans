<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RssFeedService
{
    /**
     * @return array{title: string, description: string, link: string, image_url: ?string}|null
     */
    public function fetchLatestItem(string $feedUrl): ?array
    {
        $xmlContent = $this->loadFeedXml($feedUrl);

        if ($xmlContent === null) {
            return null;
        }

        $xml = @simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml === false) {
            Log::warning('RSS XML parse failed', ['url' => $feedUrl]);

            return null;
        }

        $item = $xml->channel->item[0] ?? $xml->entry[0] ?? null;

        if ($item === null) {
            Log::warning('RSS feed has no items', ['url' => $feedUrl]);

            return null;
        }

        $namespaces = $item->getNamespaces(true);
        $media = isset($namespaces['media'])
            ? $item->children($namespaces['media'])
            : null;

        $imageUrl = null;

        if ($media && isset($media->content)) {
            $attributes = $media->content->attributes();
            $imageUrl = (string) ($attributes['url'] ?? '');
        }

        $link = (string) ($item->link['href'] ?? $item->link ?? $item->guid ?? '');

        if ($link === '' && isset($item->guid)) {
            $link = (string) $item->guid;
        }

        return [
            'title' => trim((string) ($item->title ?? 'Başlıksız')),
            'description' => trim((string) ($item->description ?? $item->summary ?? '')),
            'link' => trim($link),
            'image_url' => $imageUrl !== '' ? $imageUrl : null,
        ];
    }

    private function loadFeedXml(string $feedUrl): ?string
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'user_agent' => 'AjansWebBot/1.0',
            ],
        ]);

        $xml = @file_get_contents($feedUrl, false, $context);

        if ($xml !== false) {
            return $xml;
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'AjansWebBot/1.0'])
                ->get($feedUrl);

            return $response->successful() ? $response->body() : null;
        } catch (\Throwable $e) {
            Log::error('RSS fetch failed', ['url' => $feedUrl, 'message' => $e->getMessage()]);

            return null;
        }
    }
}
