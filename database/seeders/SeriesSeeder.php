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

        $seriesBatch = [];

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
