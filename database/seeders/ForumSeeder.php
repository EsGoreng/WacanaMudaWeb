<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContentView;
use App\Models\Forum;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() < 5) {
            User::factory(10)->create();
        }

        $users = User::all();
        $categories = Category::all();

        Forum::factory(20)->make()->each(function ($forum) use ($users, $categories) {
            $forum->user_id = $users->random()->id;

            $forum->created_at = Carbon::now()->subDays(rand(1, 60));
            $forum->updated_at = Carbon::now();
            $forum->save();

            $forum->categories()->attach(
                $categories->random(rand(1, 3))->pluck('category_id')
            );

            $replyCount = rand(0, 15);
            if ($replyCount > 0) {

                for ($i = 0; $i < $replyCount; $i++) {
                    $forum->comments()->create([
                        'user_id' => $users->random()->id,
                        'body' => \Faker\Factory::create('id_ID')->sentence(10),
                        'parent_id' => null,
                        'created_at' => $this->randomDateAfter($forum->created_at),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            $this->generateVotes($forum, $users);

            $viewCount = rand(5, 150);
            $viewData = [];
            for ($v = 0; $v < $viewCount; $v++) {
                $viewData[] = [
                    'viewable_id' => $forum->id,
                    'viewable_type' => Forum::class,
                    'created_at' => $this->randomDateAfter($forum->created_at),
                    'updated_at' => Carbon::now(),
                ];
            }
            if (! empty($viewData)) {
                ContentView::insert($viewData);
            }
        });
    }

    private function generateVotes($model, $users)
    {
        $voters = $users->random(rand(0, min(10, $users->count())));

        foreach ($voters as $voter) {
            $exists = Vote::where('user_id', $voter->id)
                ->where('votable_id', $model->id)
                ->where('votable_type', get_class($model))
                ->exists();

            if (! $exists) {
                $model->votes()->create([
                    'user_id' => $voter->id,
                    'type' => rand(0, 10) > 2 ? 'up' : 'down',
                ]);
            }
        }
    }

    private function randomDateAfter($date)
    {
        return Carbon::instance($date)->addMinutes(rand(5, 10000));
    }
}
