<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [

            'user_id' => User::factory(),

            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::random(4),
            'body' => $this->faker->paragraphs(rand(3, 7), true),
            'is_pinned' => $this->faker->boolean(5),
            'is_locked' => $this->faker->boolean(5),
            'view_count' => $this->faker->numberBetween(10, 5000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
