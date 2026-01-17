<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Writing;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WritingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user
        $users = User::with('series')->get();

        // Ambil semua ID Category untuk dipilih secara acak nanti
        $categoryIds = Category::pluck('category_id');

        for ($i = 0; $i < 25; $i++) {
            $randomUser = $users->random();

            // Logika Series (tetap sama)
            $userSeriesIds = DB::table('series')
                ->where('user_id', $randomUser->id)
                ->pluck('series_id')
                ->toArray();

            $selectedSeriesId = null;
            if (! empty($userSeriesIds) && $faker->boolean(30)) {
                $selectedSeriesId = $faker->randomElement($userSeriesIds);
            }

            // Logika Status (tetap sama)
            $status = $faker->randomElement(['published', 'published', 'published', 'draft']);
            $publishedAt = ($status === 'published')
                ? $faker->dateTimeBetween('-1 year', 'now')
                : null;

            $title = $faker->sentence(mt_rand(3, 7));
            $title = rtrim($title, '.');

            $writing = Writing::create([
                'user_id' => $randomUser->id,
                'series_id' => $selectedSeriesId,
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::random(6),
                'content' => '<p>'.implode('</p><p>', $faker->paragraphs(mt_rand(3, 8))).'</p>',
                'description' => $faker->sentence(10),
                'featured_image' => null,
                'reading_time' => mt_rand(2, 15),
                'is_anonymous' => $faker->boolean(20),
                'status' => $status,
                'published_at' => $publishedAt,
                'created_at' => $publishedAt ?? Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $randomCategories = $categoryIds->random(mt_rand(1, 3));

            $writing->categories()->attach($randomCategories);
        }
    }
}
