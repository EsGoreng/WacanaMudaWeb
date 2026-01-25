<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContentView;
use App\Models\Forum;
use App\Models\Reply;
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
            $forum->category_id = $categories->random()->category_id;
            $forum->created_at = Carbon::now()->subDays(rand(1, 60));
            $forum->updated_at = Carbon::now();
            $forum->save();

            $replyCount = rand(0, 15);
            if ($replyCount > 0) {
                Reply::factory($replyCount)->make()->each(function ($reply) use ($forum, $users) {
                    $reply->forum_id = $forum->id;
                    $reply->user_id = $users->random()->id;
                    $reply->created_at = $this->randomDateAfter($forum->created_at);
                    $reply->save();

                    $this->generateVotes($reply, $users);
                });
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
            ContentView::insert($viewData);
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
