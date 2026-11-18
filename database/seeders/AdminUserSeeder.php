<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun admin pertama.
     *
     * Kredensial diambil dari environment agar tidak ada password
     * yang hardcoded di repository:
     *
     *   ADMIN_EMAIL=... ADMIN_PASSWORD=... php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn(
                'AdminUserSeeder dilewati: set ADMIN_EMAIL dan ADMIN_PASSWORD pada environment terlebih dahulu.'
            );

            return;
        }

        if (strlen($password) < 8) {
            $this->command?->error('ADMIN_PASSWORD harus minimal 8 karakter.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Cakra Aji',
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->command?->info("Akun admin dibuat/diperbarui untuk {$email}.");
    }
}
