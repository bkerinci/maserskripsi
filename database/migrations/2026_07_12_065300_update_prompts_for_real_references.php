<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $instruction = "\n\nPENTING:
1. Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
2. Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
3. Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{{ references_context }}";

        $prompts = DB::table('prompts')
            ->whereIn('type', ['chapter_generator', 'proposal_section'])
            ->get();

        foreach ($prompts as $prompt) {
            $newContent = "";
            if ($prompt->type === 'chapter_generator') {
                $newContent = "Buatkan konten untuk subbab berikut:
- Judul Skripsi: {{ title }}
- Bab: {{ chapterTitle }}
- Subbab: {{ sectionTitle }}
- Jenis Penelitian: {{ researchType }}

Tulis dalam bahasa Indonesia yang formal, akademis, dan sesuai kaidah penulisan ilmiah.
Gunakan paragraf yang runtut dan mendalam. Minimal 4 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya." . $instruction;
            } else if ($prompt->type === 'proposal_section') {
                $newContent = "Buatkan bagian '{{ section }}' untuk proposal skripsi dengan detail berikut:
- Judul: {{ title }}
- Jenis Penelitian: {{ researchType }}
- Universitas: {{ university }}
- Program Studi: {{ studyProgram }}

Tuliskan dalam bahasa Indonesia yang formal dan akademis.
Gunakan paragraf yang runtut, logis, dan sesuai standar penulisan ilmiah.
Panjang tulisan minimal 3 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya saja." . $instruction;
            }

            DB::table('prompts')
                ->where('id', $prompt->id)
                ->update([
                    'content' => $newContent
                ]);
        }
    }

    public function down(): void
    {
        // No rollback
    }
};
