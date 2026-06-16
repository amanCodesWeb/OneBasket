<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('12345'),
                'role'     => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}
