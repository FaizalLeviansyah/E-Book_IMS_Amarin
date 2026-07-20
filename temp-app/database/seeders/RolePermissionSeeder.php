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
        // 1. Buat Role Super Admin & Admin Biasa
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 2. Buat Akun IT Operation sebagai Super Admin
        $superAdminUser = User::firstOrCreate(
            ['email' => 'itoperation@amarinshipmgmt.com'],
            [
                'name' => 'IT Operations',
                'password' => Hash::make('AmarinCaraka1234'),
            ]
        );
        if (!$superAdminUser->hasRole('super-admin')) {
            $superAdminUser->assignRole($superAdminRole);
        }

        // 3. Buat Akun HSSEQ sebagai Admin Biasa
        $hseqUser = User::firstOrCreate(
            ['email' => 'Hsseq@amarinshipmgmt.com'],
            [
                'name' => 'HSSEQ Admin E-BOOK',
                'password' => Hash::make('hsseq123'),
            ]
        );
        if (!$hseqUser->hasRole('admin')) {
            $hseqUser->assignRole($adminRole);
        }
    }
}
