<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Prompt;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asisten Penulisan Skripsi
        $personaPenulis = Persona::firstOrCreate(
            ['name' => 'Asisten Penulisan Skripsi'],
            [
                'description' => 'Ahli dalam penulisan akademis, EYD, dan format ilmiah.',
                'system_prompt' => 'Kamu adalah asisten penulisan skripsi akademik berbahasa Indonesia yang profesional.'
            ]
        );

        // 2. Asisten Metodologi
        $personaMetodologi = Persona::firstOrCreate(
            ['name' => 'Asisten Metodologi Penelitian'],
            [
                'description' => 'Ahli dalam perumusan metode, sampling, dan instrumen penelitian.',
                'system_prompt' => 'Kamu adalah asisten metodologi penelitian skripsi berbahasa Indonesia.'
            ]
        );

        // 3. Konsultan Ide
        $personaKonsultan = Persona::firstOrCreate(
            ['name' => 'Konsultan Akademik'],
            [
                'description' => 'Konsultan yang ahli memikirkan kebaruan ide skripsi.',
                'system_prompt' => 'Kamu adalah konsultan akademik ahli. Buatlah 20 ide judul skripsi/penelitian untuk mahasiswa.'
            ]
        );

        // 4. Asisten Parafrase
        $personaParafrase = Persona::firstOrCreate(
            ['name' => 'Asisten Parafrase Akademik'],
            [
                'description' => 'Ahli bahasa Indonesia untuk memparafrase teks secara ilmiah tanpa mengubah makna.',
                'system_prompt' => 'Kamu adalah asisten parafrase akademik berbahasa Indonesia.'
            ]
        );

        // --- Prompts ---

        Prompt::firstOrCreate(
            ['type' => 'proposal_section'],
            [
                'title' => 'Proposal Section Generator',
                'persona_id' => $personaPenulis->id,
                'content' => "Buatkan bagian '{{ section }}' untuk proposal skripsi dengan detail berikut:
- Judul: {{ title }}
- Jenis Penelitian: {{ researchType }}
- Universitas: {{ university }}
- Program Studi: {{ studyProgram }}

Tuliskan dalam bahasa Indonesia yang formal dan akademis.
Gunakan paragraf yang runtut, logis, dan sesuai standar penulisan ilmiah.
Panjang tulisan minimal 3 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya saja.
Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{{ references_context }}"
            ]
        );

        Prompt::firstOrCreate(
            ['type' => 'chapter_generator'],
            [
                'title' => 'Chapter Content Generator',
                'persona_id' => $personaPenulis->id,
                'content' => "Buatkan konten untuk subbab berikut:
- Judul Skripsi: {{ title }}
- Bab: {{ chapterTitle }}
- Subbab: {{ sectionTitle }}
- Jenis Penelitian: {{ researchType }}

Tulis dalam bahasa Indonesia yang formal, akademis, dan sesuai kaidah penulisan ilmiah.
Gunakan paragraf yang runtut dan mendalam. Minimal 4 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya.
Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{{ references_context }}"
            ]
        );

        Prompt::firstOrCreate(
            ['type' => 'methodology_generator'],
            [
                'title' => 'Methodology Planner',
                'persona_id' => $personaMetodologi->id,
                'content' => "Buatkan rancangan metodologi penelitian berdasarkan:
- Topik: {{ topic }}
- Jenis Penelitian: {{ researchType }}

Jelaskan secara rinci meliputi:
1. **Populasi dan Sampel** - Siapa populasinya, berapa sampel yang ideal, teknik sampling
2. **Variabel Penelitian** - Variabel independen, dependen, dan moderator (jika ada)
3. **Hipotesis** - Hipotesis nol (H0) dan hipotesis alternatif (Ha)
4. **Instrumen Penelitian** - Jenis instrumen, skala pengukuran
5. **Teknik Pengumpulan Data** - Metode yang digunakan
6. **Teknik Analisis Data** - Uji statistik yang sesuai

Tulis dalam bahasa Indonesia yang formal dan akademis."
            ]
        );

        Prompt::firstOrCreate(
            ['type' => 'topic_generator'],
            [
                'title' => 'Topics Generator',
                'persona_id' => $personaKonsultan->id,
                'content' => "Kriteria:
- Bidang/Program Studi: {{ bidang }}
- Minat Spesifik: {{ minat }}
- Lokasi Studi Kasus: {{ lokasi }}

Respons kamu WAJIB HANYA berisi JSON Array tanpa format markdown (tanpa ```json ... ```) dengan struktur tepat seperti ini:
[
  {
    \"judul\": \"Judul Skripsi 1\",
    \"kebaruan\": \"Tinggi/Sedang/Rendah\",
    \"kesulitan\": \"Tinggi/Sedang/Rendah\",
    \"referensi\": \"Mudah/Sedang/Sulit\",
    \"peluang_lulus\": \"Tinggi/Sedang\"
  }
]"
            ]
        );

        Prompt::firstOrCreate(
            ['type' => 'paraphrase'],
            [
                'title' => 'Paraphrase Editor',
                'persona_id' => $personaParafrase->id,
                'content' => "Parafrasekan teks berikut dengan tingkat perubahan '{{ level }}':
{{ levelDesc }}

Teks asli:
\"{{ text }}\"

Tulis dalam bahasa Indonesia yang formal dan akademis. Berikan HANYA hasil parafrasenya saja, tanpa penjelasan tambahan."
            ]
        );
    }
}
