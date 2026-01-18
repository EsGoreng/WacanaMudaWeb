<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'forum_id' => Forum::factory(),
            'body' => $this->faker->paragraphs(rand(1, 3), true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
