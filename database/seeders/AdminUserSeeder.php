<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Create (or update) the admin user for the content panel.
     *
     * Credentials come from ADMIN_EMAIL / ADMIN_PASSWORD. Outside production they
     * default to admin@iicc.org.mx / password.
     */
    public function run(): void
    {
        $password = config('site.admin.password');

        if (blank($password) && app()->isProduction()) {
            throw new RuntimeException('Set ADMIN_PASSWORD in .env before seeding the admin user in production.');
        }

        $user = User::query()->firstOrNew(['email' => config('site.admin.email')]);

        $user->forceFill([
            'name' => config('site.admin.name'),
            'password' => $password ?: 'password',
            'email_verified_at' => $user->email_verified_at ?? now(),
            'is_admin' => true,
        ])->save();

        $this->command?->info("Admin user: {$user->email}");
    }
}
