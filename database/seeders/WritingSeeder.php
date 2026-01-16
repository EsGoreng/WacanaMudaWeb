<?php

namespace Database\Seeders;

use App\Models\User;
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

        $users = User::with('series')->get();

        $categorySlugs = [
            'technology',
            'programming',
            'web-development',
            'mobile-development',
            'design',
            'business',
            'finance',
            'politics',
            'education',
            'lifestyle',
            'productivity',
            'opinion',
            'social',
            'career',
            'creative-writing',
            'tutorial',
            'review',
            'news-update',

            'romance',
            'poetry',
            'short-story',
            'fiction',
            'slice-of-life',
            'diary',
            'personal-thoughts',
            'healing',
            'letters',
            'quotes',
            'fantasy',
            'drama',
            'coming-of-age',
            'random-thoughts',
        ];

        $categoryIds = DB::table('categories')
            ->whereIn('slug', $categorySlugs)
            ->pluck('category_id', 'slug');

        $categoryIds = DB::table('categories')
            ->whereIn('slug', $categorySlugs)
            ->pluck('category_id');

        $writings = [];

        for ($i = 0; $i < 25; $i++) {

            $randomUser = $users->random();

            $userSeriesIds = DB::table('series')
                ->where('user_id', $randomUser->id)
                ->pluck('series_id')
                ->toArray();

            $selectedSeriesId = null;

            if (! empty($userSeriesIds) && $faker->boolean(30)) {
                $selectedSeriesId = $faker->randomElement($userSeriesIds);
            }

            $status = $faker->randomElement(['published', 'published', 'published', 'draft']);

            $publishedAt = ($status === 'published')
                ? $faker->dateTimeBetween('-1 year', 'now')
                : null;

            $title = $faker->sentence(mt_rand(3, 7));
            $title = rtrim($title, '.');

            $writings[] = [
                'user_id' => $randomUser->id,
                'category_id' => $faker->randomElement($categoryIds),
                'series_id' => $selectedSeriesId, // Series ini DIJAMIN milik user di atas
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
            ];
        }

        foreach (array_chunk($writings, 25) as $chunk) {
            DB::table('writings')->insert($chunk);
        }
    }
}
