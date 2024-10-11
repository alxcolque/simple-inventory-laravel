<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin pro',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'avatar' => 'https://cdn.iconscout.com/icon/free/png-256/free-avatar-380-456332.png%22',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
