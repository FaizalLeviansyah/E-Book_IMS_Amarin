<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Permissions berdasarkan Armada Kapal
        $permissions = [
            'manage-users',
            'manage-books',
            'access-mt-soviana',
            'access-mt-queen-majesty',
            'access-mt-queen-century',
            'access-mt-geraldine',
            'access-mt-eternal-oil-2',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 2. Buat Role Super Admin (Akses Semua)
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 3. Buat Role Kru Kapal
        $kruRole = Role::create(['name' => 'kru-kapal']);
        // Kru kapal nantinya akan diberikan permission akses spesifik saat akunnya dibuat
    }
}
