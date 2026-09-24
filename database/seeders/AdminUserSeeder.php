<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Administrator
        User::updateOrCreate(
            ['email' => 'admin@gentriiqsafaris.co.ke'],
            [
                'name' => 'Gentriiq Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Safari Sales & Inquiries Specialist
        User::updateOrCreate(
            ['email' => 'sales@gentriiqsafaris.co.ke'],
            [
                'name' => 'Safari Sales Specialist',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SALES,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Content & Tours Editor
        User::updateOrCreate(
            ['email' => 'editor@gentriiqsafaris.co.ke'],
            [
                'name' => 'Safari Content Editor',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EDITOR,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
