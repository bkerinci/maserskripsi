<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        // Automatically run SubscriptionPlanSeeder on deployment to update the plan features
        try {
            Artisan::call('db:seed', [
                '--class' => 'SubscriptionPlanSeeder',
                '--force' => true
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Auto-seeding subscription plans failed: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        // No rollback needed
    }
};
