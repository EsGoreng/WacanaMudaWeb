<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('now', '+3 months');
        $endTime = (clone $startTime)->modify('+'.rand(1, 8).' hours');

        $randomSeed = rand(1, 9999);

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'banner_image' => "https://picsum.photos/seed/{$randomSeed}/800/450",

            'image_credit' => 'Picsum Photos',
            'image_credit_url' => 'https://picsum.photos',
            'unsplash_photo_id' => null,
            'unsplash_download_location' => null,
            'location_name' => $this->faker->company().' Hall',
            'location_address' => $this->faker->address(),
            'status' => $this->faker->randomElement(['draft', 'published', 'ongoing', 'canceled', 'ended']),
        ];
    }
}
