<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContentView;
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

        $users = User::with('series')->get();

        $categoryIds = Category::pluck('category_id');

        for ($i = 0; $i < 50; $i++) {
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

            /** @var Writing $writing */
            $writing = Writing::create([
                'user_id' => $randomUser->id,
                'series_id' => $selectedSeriesId,
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::random(6),
                'content' => '<p>'.implode('</p><p>', $faker->paragraphs(mt_rand(3, 8))).'</p>',
                'description' => $faker->sentence(10),
                'featured_image' => null,
                'reading_time' => mt_rand(2, 15),
                'is_anonymous' => $faker->boolean(10),
                'status' => $status,
                'published_at' => $publishedAt,
                'created_at' => $publishedAt ?? Carbon::now(),
                'updated_at' => Carbon::now(),
                // Default view_count 0 saat create
                'view_count' => 0,
            ]);

            $randomCategories = $categoryIds->random(mt_rand(1, 3));
            $writing->categories()->attach($randomCategories);

            if ($status === 'published') {

                $likerCount = rand(0, 15);
                if ($likerCount > 0) {
                    $likers = $users->random(min($likerCount, $users->count()));
                    $writing->likes()->attach($likers->pluck('id'));
                }

                $commentCount = rand(0, 8);
                for ($k = 0; $k < $commentCount; $k++) {
                    $writing->comments()->create([
                        'user_id' => $users->random()->id,
                        'body' => $faker->sentence(mt_rand(5, 20)),
                        'parent_id' => null,
                        'created_at' => $this->randomDateAfter($writing->created_at),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                // --- PERBAIKAN DI SINI ---
                $viewCount = rand(10, 200);
                $viewData = [];
                for ($v = 0; $v < $viewCount; $v++) {
                    $viewData[] = [
                        'viewable_id' => $writing->writing_id,
                        'viewable_type' => Writing::class,
                        'created_at' => $this->randomDateAfter($writing->created_at),
                        'updated_at' => Carbon::now(),
                    ];
                }

                if (! empty($viewData)) {
                    ContentView::insert($viewData);

                    $writing->update(['view_count' => $viewCount]);
                }
            }
        }
    }

    private function randomDateAfter($date)
    {
        return Carbon::instance($date)->addMinutes(rand(5, 43200));
    }
}
