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
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $userIds[] = DB::table('users')->insertGetId([
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $catRuangKata = DB::table('categories')->where('slug', 'ruang-kata')->value('category_id');
        $catJelajahRasa = DB::table('categories')->where('slug', 'jelajah-rasa')->value('category_id');

        $seriesIds = DB::table('series')->pluck('series_id')->toArray();

        $categoryIds = array_filter([$catRuangKata, $catJelajahRasa]);

        if (empty($categoryIds)) {
            $this->command->warn('Kategori Ruang Kata atau Jelajah Rasa tidak ditemukan. Pastikan CategorySeeder dijalankan duluan.');

            return;
        }

        $writings = [];

        for ($i = 0; $i < 50; $i++) {

            $status = $faker->randomElement(['published', 'published', 'published', 'draft']);

            $publishedAt = ($status === 'published')
                ? $faker->dateTimeBetween('-1 year', 'now')
                : null;

            $title = $faker->sentence(mt_rand(3, 7));
            $title = rtrim($title, '.');

            $writings[] = [
                'user_id' => $faker->randomElement($userIds),
                'category_id' => $faker->randomElement($categoryIds),
                'series_id' => (! empty($seriesIds) && $faker->boolean(30)) ? $faker->randomElement($seriesIds) : null,
                'title' => $title,

                'slug' => Str::slug($title).'-'.Str::random(6),

                'content' => '<p>'.implode('</p><p>', $faker->paragraphs(mt_rand(3, 8))).'</p>',
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
