<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use App\Services\LanguageToolService;
use Illuminate\Http\Request;

class AIEditorController extends Controller
{
    protected $geminiService;
    protected $languageToolService;

    public function __construct(GeminiService $geminiService, LanguageToolService $languageToolService)
    {
        $this->geminiService = $geminiService;
        $this->languageToolService = $languageToolService;
    }

    public function process(Request $request)
    {
        $request->validate([
            'action' => 'required|in:rewrite,expand,shorten,formal,grammar',
            'text' => 'required|string',
        ]);

        $action = $request->input('action');
        $text = $request->input('text');
        $resultText = '';

        // Only check AI limit if not a grammar check (grammar check uses LanguageTool, not Gemini)
        if ($action !== 'grammar' && !auth()->user()->canUseAi()) {
            return response()->json([
                'success' => false,
                'message' => 'Batas AI Prompt Anda bulan ini sudah habis atau Anda belum memiliki paket aktif. Silakan upgrade paket Anda untuk terus menggunakan AI.'
            ], 403);
        }

        try {
            if ($action === 'grammar') {
                $grammarCheck = $this->languageToolService->checkGrammar($text);
                if (isset($grammarCheck['matches']) && count($grammarCheck['matches']) > 0) {
                    $resultText = "Ditemukan " . count($grammarCheck['matches']) . " masalah tata bahasa. Saran perbaikan: \n";
                    foreach ($grammarCheck['matches'] as $match) {
                        $resultText .= "- " . $match['message'] . " (Ganti dengan: " . ($match['replacements'][0]['value'] ?? 'tidak ada saran') . ")\n";
                    }
                    $resultText .= "\nTeks asli: " . $text;
                } else {
                    $resultText = "Tidak ditemukan kesalahan tata bahasa.\n\n" . $text;
                }
            } else {
                $resultText = $this->geminiService->paraphrase($text, $action);
                
                // Catat penggunaan AI
                auth()->user()->recordAiUsage('editor_paraphrase');
            }

            return response()->json([
                'success' => true,
                'result' => $resultText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses AI: ' . $e->getMessage()
            ], 500);
        }
    }
}
