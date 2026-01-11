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
        // 1. Reset Cached Roles/Permissions (Wajib untuk Spatie)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions (Berdasarkan Kebutuhan Fungsional)
        // KF-CONT-01: Menulis konten
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit own posts']);
        Permission::create(['name' => 'delete own posts']);
        
        // KF-INT-01: Komentar
        Permission::create(['name' => 'post comments']);
        
        // KF-USR-07: Validasi anggota baru
        Permission::create(['name' => 'validate members']);
        
        // KF-EVT-01: Mengelola Event
        Permission::create(['name' => 'manage events']);
        
        // Moderasi Konten (Hapus/Edit konten orang lain jika melanggar)
        Permission::create(['name' => 'moderate content']);
        
        // KF-USR-08: Mengelola akun pengurus
        Permission::create(['name' => 'manage admins']);

        $roleAnggota = Role::create(['name' => 'member']);
        $roleAnggota->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
            'post comments'
        ]);

        $rolePengurus = Role::create(['name' => 'admin']);
        $rolePengurus->givePermissionTo([
            'validate members',
            'manage events',
            'moderate content',
            'create posts', 
            'edit own posts',
            'delete own posts',
            'post comments'
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

        // Akun Pengurus Contoh
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