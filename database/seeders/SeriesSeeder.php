<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $userIds[] = DB::table('users')->insertGetId([
                'name' => 'Admin Series',
                'email' => 'series@admin.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $seriesBatch = [];

        $manualSeries = [
            [
                'name' => 'Guidebook Website Wacana Muda',
                'description' => 'Panduan bertahap untuk anggota baru WMB dalam menggunakan platform.',
            ],
            [
                'name' => 'Catatan Perjalanan 2024',
                'description' => 'Kumpulan cerita dan refleksi dari perjalanan keliling Jawa Barat.',
            ],
            [
                'name' => 'Tutorial Laravel & Flux UI',
                'description' => 'Seri belajar membangun website modern dengan stack TALL.',
            ],
        ];

        foreach ($manualSeries as $s) {
            $seriesBatch[] = [
                'user_id' => $userIds[0],
                'name' => $s['name'],
                'description' => $s['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        for ($i = 0; $i < 10; $i++) {
            $seriesBatch[] = [
                'user_id' => $faker->randomElement($userIds),
                'name' => 'Seri '.$faker->words(3, true),
                'description' => $faker->sentence(10),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('series')->insert($seriesBatch);
    }
}
