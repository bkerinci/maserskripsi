<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LanguageToolService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.languagetool.url', 'https://api.languagetool.org/v2');
    }

    /**
     * Check text for grammar and spelling errors.
     * Returns an array of matches.
     */
    public function checkText(string $text, string $language = 'id-ID'): array
    {
        try {
            $response = Http::asForm()->post("{$this->baseUrl}/check", [
                'text' => $text,
                'language' => $language,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['matches'] ?? [];
            }

            Log::error('LanguageTool API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('LanguageTool API Exception: ' . $e->getMessage());
            return [];
        }
    }
}
