<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    private const ZENQUOTES_URL = 'https://zenquotes.io/api/random';
    private const FALLBACK_TEXT = 'Snaga dolazi iz upornosti. Nastavi dalje.';
    private const FALLBACK_AUTHOR = 'Astra Fit';

    /**
     * Return a random quote as JSON. Proxies ZenQuotes server-side to avoid CORS.
     * Format: { "text": "...", "author": "..." }
     */
    public function __invoke(): JsonResponse
    {
        try {
            $response = Http::timeout(10)->get(self::ZENQUOTES_URL);

            if (!$response->successful()) {
                return $this->fallbackResponse();
            }

            $data = $response->json();
            if (!is_array($data) || empty($data[0])) {
                return $this->fallbackResponse();
            }

            $first = $data[0];
            $text = $first['q'] ?? null;
            $author = $first['a'] ?? null;

            if (empty($text)) {
                return $this->fallbackResponse();
            }

            return response()->json([
                'text' => $text,
                'author' => $author ?? self::FALLBACK_AUTHOR,
            ]);
        } catch (\Throwable $e) {
            return $this->fallbackResponse();
        }
    }

    private function fallbackResponse(): JsonResponse
    {
        return response()->json([
            'text' => self::FALLBACK_TEXT,
            'author' => self::FALLBACK_AUTHOR,
        ]);
    }
}
