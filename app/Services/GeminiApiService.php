<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiApiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY', ''));
    }

    public function generateTopics(string $minat, string $bidang, ?string $lokasi = null): array
    {
        if (empty($this->apiKey)) {
            // Untuk development/MVP jika API key belum ada, return dummy data
            return $this->getDummyTopics($minat, $bidang, $lokasi);
        }

        $prompt = "Kamu adalah konsultan akademik ahli. Buatlah 20 ide judul skripsi/penelitian untuk mahasiswa.
Kriteria:
- Bidang/Program Studi: {$bidang}
- Minat Spesifik: {$minat}";

        if ($lokasi) {
            $prompt .= "\n- Lokasi Studi Kasus: {$lokasi}";
        }

        $prompt .= "\n\nRespons kamu WAJIB HANYA berisi JSON Array tanpa format markdown (tanpa ```json ... ```) dengan struktur tepat seperti ini:
[
  {
    \"judul\": \"Judul Skripsi 1\",
    \"kebaruan\": \"Tinggi/Sedang/Rendah\",
    \"kesulitan\": \"Tinggi/Sedang/Rendah\",
    \"referensi\": \"Mudah/Sedang/Sulit\",
    \"peluang_lulus\": \"Tinggi/Sedang\"
  }
]";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $content = $response->json('candidates.0.content.parts.0.text');
                
                // Terkadang AI masih membalas dengan tag ```json, jadi kita bersihkan
                $content = str_replace(['```json', '```'], '', $content);
                $content = trim($content);

                $data = json_decode($content, true);

                if (is_array($data)) {
                    return $data;
                }
            }

            // Fallback to dummy if failed parsing or API error
            return $this->getDummyTopics($minat, $bidang, $lokasi);

        } catch (Exception $e) {
            return $this->getDummyTopics($minat, $bidang, $lokasi);
        }
    }

    private function getDummyTopics(string $minat, string $bidang, ?string $lokasi): array
    {
        // Mock data
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

    public function generateChapterSection(\App\Models\Project $project, string $chapterTitle, string $sectionTitle): string
    {
        if (empty($this->apiKey)) {
            // Dummy content for MVP if no API key
            return "Ini adalah teks hasil *generate* AI (dummy) untuk subbab **{$sectionTitle}** pada **{$chapterTitle}**.\n\nDalam penelitian yang berjudul \"{$project->title}\" (jenis penelitian: {$project->research_type}), bagian ini memaparkan detail yang relevan dengan topik {$project->topic}. Silakan gunakan form editor untuk mengedit teks ini lebih lanjut.";
        }

        $prompt = "Kamu adalah penulis akademik yang cerdas dan terstruktur. Bantu mahasiswa menulis bagian subbab skripsi.
Informasi Penelitian:
- Judul: {$project->title}
- Topik: {$project->topic}
- Program Studi: {$project->study_program}
- Jenis Penelitian: {$project->research_type}

Tugas: Tulis isi lengkap untuk bagian '{$chapterTitle}', subbab: '{$sectionTitle}'. 
Aturan:
- Gunakan bahasa Indonesia akademik yang formal (PUEBI).
- Panjang teks sekitar 300-500 kata.
- Hanya berikan isi teksnya saja, TANPA mencantumkan ulang judul bab/subbab di awal tulisan.
- Jangan berikan salam pembuka/penutup. Langsung masuk ke konten akademik.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.6, // sedikit lebih rendah agar bahasanya lebih formal dan kaku (akademik)
                ]
            ]);

            if ($response->successful()) {
                return trim($response->json('candidates.0.content.parts.0.text', ''));
            }

            return "Maaf, terjadi kesalahan saat menghubungi AI (Response gagal).";
        } catch (Exception $e) {
            return "Maaf, terjadi kesalahan teknis saat memanggil AI: " . $e->getMessage();
        }
    }
}
