<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContentView;
use App\Models\Event;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('category_id');
        $faker = Faker::create('id_ID');

        Event::factory(20)
            ->state(function (array $attributes) use ($faker) {
                $isOnline = $faker->boolean(40);

                return [
                    'is_online' => $isOnline,

                    'meeting_link' => $isOnline ? 'https://zoom.us/j/'.$faker->numerify('###########') : null,

                    'location_name' => $isOnline ? $faker->randomElement(['Zoom Meeting', 'Google Meet', 'Microsoft Teams']) : $faker->company,

                    'location_address' => $isOnline ? null : $faker->address,

                    'register_link' => $faker->boolean(60) ? $faker->url : null,
                ];
            })
            ->create()
            ->each(function ($event) use ($categories) {

                $event->categories()->attach($categories->random(rand(1, 2)));

                $viewCount = rand(20, 300);
                $viewData = [];

                $baseDate = $event->created_at ?? Carbon::now()->subMonth();

                for ($v = 0; $v < $viewCount; $v++) {
                    $viewData[] = [
                        'viewable_id' => $event->id,
                        'viewable_type' => Event::class,
                        'created_at' => Carbon::instance($baseDate)->addMinutes(rand(10, 40000)),
                        'updated_at' => Carbon::now(),
                    ];
                }

                if (! empty($viewData)) {
                    ContentView::insert($viewData);
                }
            });
    }
}
