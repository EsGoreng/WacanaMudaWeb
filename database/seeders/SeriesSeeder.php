<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Carbon\Carbon;

class SeriesSeeder extends Seeder
{
    public function run(): void
    {
        
        $user = User::first(); 
        
        if (!$user) {
            $user_id = DB::table('users')->insertGetId([
                'name' => 'ITSNA AKHDAN FADHIL', 
                'username' => 'itsna_akhdan',
                'email' => 'admin@wmb.com',
                'password' => bcrypt('password'),
                'role' => 'superadmin', 
                'created_at' => Carbon::now(),
            ]);
        } else {
            $user_id = $user->id;
        }

        $series = [
            [
                'name' => 'Guidebook Website Wacana Muda',
                'description' => 'Panduan bertahap untuk anggota baru WMB.',
            ]
        ];

        foreach ($series as $s) {
            DB::table('series')->insert([
                'user_id' => $user_id,
                'name' => $s['name'],
                'description' => $s['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}