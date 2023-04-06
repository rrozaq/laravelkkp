<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);
        Permission::create(['name' => 'verifikasi-users']);

        Permission::create(['name' => 'create-kapal']);
        Permission::create(['name' => 'edit-kapal']);
        Permission::create(['name' => 'delete-kapal']);
        Permission::create(['name' => 'verifikasi-kapal']);

        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);

        $adminRole->givePermissionTo([
            'edit-users',
            'verifikasi-users',
            'delete-users',
            'edit-kapal',
            'verifikasi-kapal',
            'delete-kapal',
        ]);

        $userRole->givePermissionTo([
            'create-kapal',
            'edit-kapal',
            'edit-users',
        ]);
    }
}
