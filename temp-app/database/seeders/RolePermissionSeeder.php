<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Role Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 2. Buat Akun IT Operation
        $adminUser = User::firstOrCreate(
            ['email' => 'itoperation@amarinshipmgmt.com'], // Patokan email agar tidak duplikat
            [
                'name' => 'IT Operations',
                'password' => Hash::make('AmarinCaraka1234'),
            ]
        );

        // 3. Hubungkan akun dengan role admin
        $adminUser->assignRole($adminRole);
    }
}
