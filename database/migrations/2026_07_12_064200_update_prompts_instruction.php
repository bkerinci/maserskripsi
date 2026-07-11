<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $instruction = "\n\nPENTING: Jangan berikan kalimat pembuka/pengantar seperti 'Berikut adalah konten...', 'Berikut ini adalah...', 'Tentu, ini adalah...', atau pengantar sejenis lainnya. LANGSUNG MULAI dengan paragraf isi konten secara penuh tanpa awalan apapun.";

        $prompts = DB::table('prompts')
            ->whereIn('type', ['chapter_generator', 'proposal_section', 'methodology_generator'])
            ->get();

        foreach ($prompts as $prompt) {
            if (!str_contains($prompt->content, 'Jangan berikan kalimat pembuka')) {
                DB::table('prompts')
                    ->where('id', $prompt->id)
                    ->update([
                        'content' => $prompt->content . $instruction
                    ]);
            }
        }
    }

    public function down(): void
    {
        // No rollback needed for data tuning
    }
};
