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
        
        Permission::create(['name' => 'post comments']);
        Permission::create(['name' => 'validate members']);
        
        Permission::create(['name' => 'manage events']);
        Permission::create(['name' => 'moderate content']);
        
        Permission::create(['name' => 'manage admins']);

        $roleAnggota = Role::create(['name' => 'member']);
        $roleAnggota->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
            'create comments',
            'delete own comments',
        ]);

        $rolePengurus = Role::create(['name' => 'admin']);
        $rolePengurus->givePermissionTo([
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


        $admin = User::firstOrCreate([
            'email' => 'admin@wacanamuda.id',
        ], [
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'phone' => '6281234567890'
        ]);
        $admin->assignRole('superadmin');

        $pengurus = User::firstOrCreate([
            'email' => 'pengurus@wacanamuda.id',
        ], [
            'name' => 'Divisi Kegiatan',
            'username' => 'pengurus1',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'phone' => '6281200000000'
        ]);
        $pengurus->assignRole('admin');
    }
}