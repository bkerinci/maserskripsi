<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::truncate();

        SubscriptionPlan::create([
            'name' => 'Basic',
            'price' => 49000,
            'features' => [
                '1 Project',
                '5 AI Prompt / Bulan',
                'Referensi Terbatas'
            ]
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium Bulanan',
            'price' => 99000,
            'features' => [
                '3 Project Aktif',
                '20 AI Prompt / Bulan',
                'AI Literature Review'
            ]
        ]);

        SubscriptionPlan::create([
            'name' => 'Premium Tahunan',
            'price' => 199000,
            'features' => [
                'Unlimited Project',
                'Unlimited AI Prompt',
                'Semua Fitur Premium'
            ]
        ]);

        SubscriptionPlan::create([
            'name' => 'Campus',
            'price' => 0,
            'features' => [
                'Multi-user / Mahasiswa',
                'Dashboard Dosen',
                'Branding Kampus'
            ]
        ]);
    }
}
