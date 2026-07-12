<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        // Run PromptSeeder automatically on deployment
        try {
            Artisan::call('db:seed', [
                '--class' => 'PromptSeeder',
                '--force' => true
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Auto-seeding personas and prompts failed: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};
