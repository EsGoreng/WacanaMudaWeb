<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit own posts']);
        Permission::create(['name' => 'delete own posts']);

        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'delete own comments']);
        Permission::create(['name' => 'delete comments']);

        Permission::create(['name' => 'manage events']);
        Permission::create(['name' => 'moderate content']);
        Permission::create(['name' => 'validate members']);
        Permission::create(['name' => 'setting landingpage']);

        Permission::create(['name' => 'manage admins']);

        $roleMember = Role::create(['name' => 'member']);
        $roleMember->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
            'create comments',
            'delete own comments',
        ]);

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            'validate members',
            'manage events',
            'moderate content',
            'create posts',
            'edit own posts',
            'delete own posts',
            'create comments',
            'delete comments',
        ]);

        $roleSuperadmin = Role::create(['name' => 'superadmin']);
        $roleSuperadmin->givePermissionTo(Permission::all());

        $superadmin1 = User::firstOrCreate([
            'email' => 'superadmin@wacanamuda.space',
        ], [
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('@Peopleberkarya123'),
            'phone' => '6281234567890',
        ]);
        $superadmin1->assignRole('superadmin');

        $superadmin2 = User::firstOrCreate([
            'email' => 'itsnaakhdan25@gmail.com',
        ], [
            'name' => 'Akhdan Fadhil',
            'username' => 'akhdanfadhil',
            'password' => Hash::make('@Peopleberkarya123'),
            'phone' => '6281234567890',
        ]);
        $superadmin2->assignRole('superadmin');
    }
}
