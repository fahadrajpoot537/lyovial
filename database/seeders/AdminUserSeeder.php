<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@lyovial.com'],
            [
                'name' => 'Super Admin',
                'password' => 'Admin@12345',
                'theme' => 'light',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('Super Admin');
    }
}
