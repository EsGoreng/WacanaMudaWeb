<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        Permission::create(['name' => 'delete   comments']);
        
        Permission::create(['name' => 'manage events']);
        Permission::create(['name' => 'moderate content']);
        Permission::create(['name' => 'validate members']);
        
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


        $superadmin = User::firstOrCreate([
            'email' => 'superadmin@wacanamuda.id',
        ], [
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'phone' => '6281234567890'
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::firstOrCreate([
            'email' => 'admin@wacanamuda.id',
        ], [
            'name' => 'Anonymous Admin',
            'username' => 'admin1',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'phone' => '6281200000000'
        ]);
        $admin->assignRole('admin');
    }
}