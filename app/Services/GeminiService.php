<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $provider;
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        $this->provider = env('AI_PROVIDER', 'gemini');
        
        if ($this->provider === 'openrouter') {
            $this->apiKey = env('OPENROUTER_API_KEY', '');
            $this->model = env('OPENROUTER_MODEL', 'google/gemini-2.5-flash');
            $this->baseUrl = 'https://openrouter.ai/api/v1';
        } else {
            $this->apiKey = config('services.gemini.api_key');
            $this->model = config('services.gemini.model', 'gemini-2.0-flash');
            $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta';
        }
    }

    /**
     * Generate text content using configured AI API.
     */
    public function generate(string $prompt, float $temperature = 0.7, int $maxTokens = 4096): ?string
    {
        try {
            if ($this->provider === 'openrouter') {
                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => "Bearer {$this->apiKey}",
                        'Content-Type' => 'application/json',
                        'HTTP-Referer' => config('app.url', 'http://jokiskripsi.test'),
                        'X-Title' => config('app.name', 'Master Skripsi'),
                    ])
                    ->timeout(60)
                    ->post("{$this->baseUrl}/chat/completions", [
                        'model' => $this->model,
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'temperature' => $temperature,
                        'max_tokens' => $maxTokens,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['choices'][0]['message']['content'] ?? null;
                }

                Log::error('OpenRouter API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            } else {
                $response = Http::withoutVerifying()->timeout(60)->post(
                    "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => $temperature,
                            'maxOutputTokens' => $maxTokens,
                        ],
                    ]
                );

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                }

                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }
        } catch (\Exception $e) {
            Log::error('AI Service Exception: ' . $e->getMessage());
            return null;
        }
    }

    private function buildPrompt(string $type, array $placeholders, string $defaultPrompt, string $defaultSystem = ''): string
    {
        $promptText = $defaultPrompt;
        $systemPrompt = $defaultSystem;

        try {
            $dbPrompt = \App\Models\Prompt::where('type', $type)->with('persona')->first();
            if ($dbPrompt) {
                $promptText = $dbPrompt->content;
                if ($dbPrompt->persona) {
                    $systemPrompt = $dbPrompt->persona->system_prompt;
                }
            }
        } catch (\Exception $e) {
            // Ignore DB errors and fallback to default
        }

        foreach ($placeholders as $key => $value) {
            $promptText = str_replace('{{ ' . $key . ' }}', $value ?? '', $promptText);
            $promptText = str_replace('{{' . $key . '}}', $value ?? '', $promptText);
            // also replace {$key} format for backwards compatibility with the default hardcoded string
            $promptText = str_replace('{$' . $key . '}', $value ?? '', $promptText);
        }

        if ($systemPrompt) {
            return $systemPrompt . "\n\n" . $promptText;
        }

        return $promptText;
    }

    public function generateProposalSection(string $title, string $section, string $researchType, string $university, string $studyProgram, array $references = []): ?string
    {
        $defaultSystem = "Kamu adalah asisten penulisan skripsi akademik berbahasa Indonesia yang profesional.";
        $defaultPrompt = "Buatkan bagian '{\$section}' untuk proposal skripsi dengan detail berikut:
- Judul: {\$title}
- Jenis Penelitian: {\$researchType}
- Universitas: {\$university}
- Program Studi: {\$studyProgram}

Tuliskan dalam bahasa Indonesia yang formal dan akademis.
Gunakan paragraf yang runtut, logis, dan sesuai standar penulisan ilmiah.
Panjang tulisan minimal 3 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya saja.
Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{\$references_context}";

        $refText = "";
        if (!empty($references)) {
            $refText = "\n\nBerikut adalah daftar referensi jurnal riil yang disimpan untuk proyek ini. Anda WAJIB memprioritaskan penggunaan referensi ini jika relevan:\n";
            foreach ($references as $r) {
                $refUrl = $r['url'] ?: ($r['doi'] ? 'https://doi.org/'.$r['doi'] : '');
                if ($refUrl) {
                    $refText .= "- \"{$r['title']}\" oleh {$r['authors']} ({$r['year']}). Jurnal: {$r['journal']}. URL: {$refUrl}\n";
                } else {
                    $refText .= "- \"{$r['title']}\" oleh {$r['authors']} ({$r['year']}). Jurnal: {$r['journal']}\n";
                }
            }
        }

        $prompt = $this->buildPrompt('proposal_section', [
            'section' => $section,
            'title' => $title,
            'researchType' => $researchType,
            'university' => $university,
            'studyProgram' => $studyProgram,
            'references_context' => $refText
        ], $defaultPrompt, $defaultSystem);

        return $this->generate($prompt, 0.7, 4096);
    }

    /**
     * Generate chapter/section content.
     */
    public function generateChapterContent(string $title, string $chapterTitle, string $sectionTitle, string $researchType, array $references = []): ?string
    {
        $defaultSystem = "Kamu adalah asisten penulisan skripsi akademik berbahasa Indonesia yang profesional.";
        $defaultPrompt = "Buatkan konten untuk subbab berikut:
- Judul Skripsi: {\$title}
- Bab: {\$chapterTitle}
- Subbab: {\$sectionTitle}
- Jenis Penelitian: {\$researchType}

Tulis dalam bahasa Indonesia yang formal, akademis, dan sesuai kaidah penulisan ilmiah.
Gunakan paragraf yang runtut dan mendalam. Minimal 4 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya.
Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{\$references_context}";

        $refText = "";
        if (!empty($references)) {
            $refText = "\n\nBerikut adalah daftar referensi jurnal riil yang disimpan untuk proyek ini. Anda WAJIB memprioritaskan penggunaan referensi ini jika relevan:\n";
            foreach ($references as $r) {
                $refUrl = $r['url'] ?: ($r['doi'] ? 'https://doi.org/'.$r['doi'] : '');
                if ($refUrl) {
                    $refText .= "- \"{$r['title']}\" oleh {$r['authors']} ({$r['year']}). Jurnal: {$r['journal']}. URL: {$refUrl}\n";
                } else {
                    $refText .= "- \"{$r['title']}\" oleh {$r['authors']} ({$r['year']}). Jurnal: {$r['journal']}\n";
                }
            }
        }

        $prompt = $this->buildPrompt('chapter_generator', [
            'title' => $title,
            'chapterTitle' => $chapterTitle,
            'sectionTitle' => $sectionTitle,
            'researchType' => $researchType,
            'references_context' => $refText
        ], $defaultPrompt, $defaultSystem);

        return $this->generate($prompt, 0.7, 4096);
    }

    /**
     * Generate research methodology.
     */
    public function generateMethodology(string $topic, string $researchType): ?string
    {
        $defaultSystem = "Kamu adalah asisten metodologi penelitian skripsi berbahasa Indonesia.";
        $defaultPrompt = "Buatkan rancangan metodologi penelitian berdasarkan:
- Topik: {\$topic}
- Jenis Penelitian: {\$researchType}

Jelaskan secara rinci meliputi:
1. **Populasi dan Sampel** - Siapa populasinya, berapa sampel yang ideal, teknik sampling
2. **Variabel Penelitian** - Variabel independen, dependen, dan moderator (jika ada)
3. **Hipotesis** - Hipotesis nol (H0) dan hipotesis alternatif (Ha)
4. **Instrumen Penelitian** - Jenis instrumen, skala pengukuran
5. **Teknik Pengumpulan Data** - Metode yang digunakan
6. **Teknik Analisis Data** - Uji statistik yang sesuai

Tulis dalam bahasa Indonesia yang formal dan akademis.";

        $prompt = $this->buildPrompt('methodology_generator', [
            'topic' => $topic,
            'researchType' => $researchType
        ], $defaultPrompt, $defaultSystem);

        return $this->generate($prompt, 0.7, 4096);
    }

    /**
     * Paraphrase text.
     */
    public function paraphrase(string $text, string $level = 'sedang'): ?string
    {
        $levelDesc = match($level) {
            'ringan' => 'Ubah sedikit kata-kata saja, pertahankan struktur kalimat yang sama.',
            'tinggi' => 'Ubah secara signifikan dengan kata-kata dan struktur kalimat yang benar-benar berbeda, namun maknanya tetap sama.',
            default => 'Ubah kata-kata dan sedikit struktur kalimat, namun pertahankan makna yang sama.',
        };

        $defaultSystem = "Kamu adalah asisten parafrase akademik berbahasa Indonesia.";
        $defaultPrompt = "Parafrasekan teks berikut dengan tingkat perubahan '{\$level}':
{\$levelDesc}

Teks asli:
\"{\$text}\"

Tulis dalam bahasa Indonesia yang formal dan akademis. Berikan HANYA hasil parafrasenya saja, tanpa penjelasan tambahan.";

        $prompt = $this->buildPrompt('paraphrase', [
            'level' => $level,
            'levelDesc' => $levelDesc,
            'text' => $text
        ], $defaultPrompt, $defaultSystem);

        return $this->generate($prompt, 0.8, 2048);
    }

    /**
     * Generate topic ideas.
     */
    public function generateTopics(string $minat, string $bidang, ?string $lokasi = null): array
    {
        $defaultSystem = "Kamu adalah konsultan akademik ahli. Buatlah 20 ide judul skripsi/penelitian untuk mahasiswa.";
        $defaultPrompt = "Kriteria:
- Bidang/Program Studi: {\$bidang}
- Minat Spesifik: {\$minat}";

        if ($lokasi) {
            $defaultPrompt .= "\n- Lokasi Studi Kasus: {\$lokasi}";
        }

        $defaultPrompt .= "\n\nRespons kamu WAJIB HANYA berisi JSON Array tanpa format markdown (tanpa ```json ... ```) dengan struktur tepat seperti ini:
[
  {
    \"judul\": \"Judul Skripsi 1\",
    \"kebaruan\": \"Tinggi/Sedang/Rendah\",
    \"kesulitan\": \"Tinggi/Sedang/Rendah\",
    \"referensi\": \"Mudah/Sedang/Sulit\",
    \"peluang_lulus\": \"Tinggi/Sedang\"
  }
]";

        $jsonInstruction = "\n\nRespons kamu WAJIB HANYA berisi JSON Array dengan struktur tepat seperti ini:
[
  {
    \"judul\": \"Judul Skripsi 1\",
    \"kebaruan\": \"Tinggi/Sedang/Rendah\",
    \"kesulitan\": \"Tinggi/Sedang/Rendah\",
    \"referensi\": \"Mudah/Sedang/Sulit\",
    \"peluang_lulus\": \"Tinggi/Sedang\"
  }
]";

        $prompt = $this->buildPrompt('topic_generator', [
            'bidang' => $bidang,
            'minat' => $minat,
            'lokasi' => $lokasi
        ], $defaultPrompt, $defaultSystem);

        // ALWAYS append the json instruction, even if the user changed the prompt in DB
        if (!str_contains($prompt, 'JSON Array')) {
            $prompt .= $jsonInstruction;
        }

        $result = $this->generate($prompt, 0.7, 4096);
        
        if ($result) {
            // Try to extract JSON array if there's extra text
            if (preg_match('/\[.*\]/s', $result, $matches)) {
                $content = $matches[0];
                $data = json_decode($content, true);

                if (is_array($data) && count($data) > 0) {
                    return $data;
                }
            }
            
            // Fallback parsing just in case
            $content = str_replace(['```json', '```'], '', $result);
            $content = trim($content);
            $data = json_decode($content, true);

            if (is_array($data) && count($data) > 0) {
                return $data;
            }
            
            // Log what went wrong
            $debugInfo = "Parse failed. First 50 chars: " . substr($result, 0, 50) . " JSON Error: " . json_last_error_msg();
            \Illuminate\Support\Facades\Log::warning('Gemini AI JSON Parsing Failed', [
                'result' => $result,
                'json_error' => json_last_error_msg()
            ]);
            session()->flash('api_error', 'Gagal memproses respons AI. Menampilkan rekomendasi cadangan.');
        } else {
            $debugInfo = "API Error: No result. Check API Key or Network.";
            session()->flash('api_error', 'Koneksi AI terganggu atau kuota habis. Menampilkan rekomendasi cadangan.');
        }

        // Fallback
        return $this->getDummyTopics($minat, $bidang, $lokasi);
    }

    private function getDummyTopics(string $minat, string $bidang, ?string $lokasi): array
    {
        $topics = [];
        $lokasiText = $lokasi ? " di $lokasi" : "";

        for ($i = 1; $i <= 20; $i++) {
            $topics[] = [
                'judul' => "Implementasi AI dalam $minat pada $bidang$lokasiText (Opsi $i)",
                'kebaruan' => $i % 2 == 0 ? 'Tinggi' : 'Sedang',
                'kesulitan' => $i % 3 == 0 ? 'Tinggi' : 'Sedang',
                'referensi' => 'Mudah',
                'peluang_lulus' => 'Tinggi',
            ];
        }
        return $topics;
    }
}
