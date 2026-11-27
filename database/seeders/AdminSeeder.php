<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);

        $admin = Admin::updateOrCreate(
            ['email' => 'admin@praxisfit.com'],
            [
                'name' => 'admin-praxisfit-1',
                'password' => Hash::make('tinju-kangguru-123'),
            ]
        );

        $admin->assignRole($role);

        // Pastikan seluruh akun user yang sudah pernah didaftarkan sebelumnya langsung aktif tanpa tertahan OTP
        User::whereNull('email_verified_at')->orWhereNotNull('otp_code')->update([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);
    }
}
