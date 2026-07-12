<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SubscriptionPlanSeeder::class,
            LegalPageSeeder::class,
            PromptSeeder::class,
        ]);

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@thesisai.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Demo User
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'user@thesisai.test',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
