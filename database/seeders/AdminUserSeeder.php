<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Each account is only created if it doesn't already exist.
        // A random password is set so staff must use "Forgot password" to gain access.
        $this->provision(
            email: env('SEED_ADMIN_EMAIL', 'admin@gentriiqsafaris.co.ke'),
            name: 'Gentriiq Admin',
            role: User::ROLE_SUPER_ADMIN,
        );

        $this->provision(
            email: env('SEED_SALES_EMAIL', 'sales@gentriiqsafaris.co.ke'),
            name: 'Safari Sales Specialist',
            role: User::ROLE_SALES,
        );

        $this->provision(
            email: env('SEED_EDITOR_EMAIL', 'editor@gentriiqsafaris.co.ke'),
            name: 'Safari Content Editor',
            role: User::ROLE_EDITOR,
        );
    }

    private function provision(string $email, string $name, string $role): void
    {
        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::password(24)),
                'role' => $role,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
