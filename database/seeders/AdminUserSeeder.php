<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@tesaurus.local')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@tesaurus.local',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => null,
            ]);

            $this->command->info('Admin user created: admin@tesaurus.local / password123');
        }
    }
}
