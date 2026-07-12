<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Persona;
use App\Models\Prompt;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Seed the Custom Sub-chapter Persona
        $personaCustom = Persona::firstOrCreate(
            ['name' => 'Spesialis Subbab Kustom'],
            [
                'description' => 'Ahli dalam menganalisis dan menulis konten akademis untuk subbab kustom/khusus yang ditentukan mandiri oleh pengguna.',
                'system_prompt' => 'Kamu adalah asisten akademik spesialis penulisan subbab kustom skripsi. Tugasmu adalah menganalisis judul subbab khusus yang diinput pengguna dan menuliskan isi pembahasannya secara formal, mendalam, dan relevan dengan topik penelitian utama.'
            ]
        );

        // 2. Seed the Custom Chapter Prompt
        Prompt::firstOrCreate(
            ['type' => 'custom_chapter_generator'],
            [
                'title' => 'Custom Chapter Content Generator',
                'persona_id' => $personaCustom->id,
                'content' => "Buatkan konten untuk subbab kustom berikut:
- Judul Skripsi: {{ title }}
- Bab: {{ chapterTitle }}
- Subbab Khusus: {{ sectionTitle }}
- Jenis Penelitian: {{ researchType }}

Karena ini adalah subbab khusus/kustom, Anda harus menganalisis relevansinya terhadap judul skripsi utama.
Tulis dalam bahasa Indonesia yang formal, akademis, dan sesuai kaidah penulisan ilmiah.
Gunakan paragraf yang runtut dan mendalam. Minimal 4 paragraf.
Jangan gunakan format markdown heading (#). Langsung tulis paragrafnya.
Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.
Jangan menuliskan kembali nomor bab, judul bab, maupun judul subbab (contoh: jangan tulis 'Bab 2 Tinjauan Pustaka' atau '2.1 Kajian Teori' di awal atau di bagian mana pun). LANGSUNG MULAI dengan kalimat pertama paragraf isi konten.
Jangan menggunakan referensi dummy/fiktif! Anda harus menyertakan referensi jurnal riil dari 3 tahun kebelakang (tahun 2023 - 2026).
Untuk setiap sitasi yang Anda sebutkan di dalam paragraf, wajib dibuat hyperlink berupa tag HTML <a> dengan target='_blank' (contoh: <a href='https://doi.org/10.1109/xxx' target='_blank'>NamaPenulis, 2024</a>) yang mengarah ke link URL asli dari jurnal tersebut (baik dari referensi yang disediakan maupun jurnal riil lainnya).
{{ references_context }}"
            ]
        );
    }

    public function down(): void
    {
        Prompt::where('type', 'custom_chapter_generator')->delete();
        Persona::where('name', 'Spesialis Subbab Kustom')->delete();
    }
};
