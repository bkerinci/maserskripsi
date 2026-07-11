<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@masterskripsi.my.id';
        
        // Check if admin already exists
        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => Hash::make('PekekrX7ke6Z@'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
