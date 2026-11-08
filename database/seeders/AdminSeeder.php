<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the admin guard for roles and permissions
        $role = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);

        $admin = Admin::updateOrCreate(
            ['email' => 'admin@praxisfit.com'],
            [
                'name' => 'Super Admin PraxisFit',
                'password' => Hash::make('admin1234'), // Default password
            ]
        );

        $admin->assignRole($role);
    }
}
