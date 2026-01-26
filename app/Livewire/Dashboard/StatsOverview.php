<?php

namespace App\Livewire\Dashboard;

use App\Models\Comment;
use App\Models\ContentView;
use App\Models\Forum;
use App\Models\User;
use App\Models\Writing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    public ?User $user = null;

    protected function getPollingInterval(): ?string
    {
        return null;
    }

    public function mount(?User $user = null)
    {

        $this->user = $user ?? Auth::user();
    }

    private function getViewChartData($modelClass): array
    {
        $targetUser = $this->user;
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $count = ContentView::query()
                ->where('viewable_type', $modelClass)
                ->whereDate('created_at', $date)
                ->whereHasMorph('viewable', [$modelClass], function ($query) use ($targetUser) {

                    $query->where('user_id', $targetUser->id);
                })
                ->count();

            $data[] = $count;
        }

        return $data;
    }

    private function getChartData($model, array $conditions = []): array
    {
        $targetUser = $this->user;
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $query = $model::where('user_id', $targetUser->id)
                ->whereDate('created_at', $date);

            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }

            $data[] = $query->count();
        }

        return $data;
    }

    protected function getStats(): array
    {
        $targetUser = $this->user;

        if (! $targetUser) {
            return [];
        }

        $totalWritings = Writing::where('user_id', $targetUser->id)
            ->where('status', 'published')
            ->when(Auth::id() !== $targetUser->id, function ($query) {
                $query->where('is_anonymous', false);
            })
            ->count();
        $writingChart = $this->getChartData(Writing::class, ['status' => 'published']);

        $totalLikes = Writing::where('user_id', $targetUser->id)
            ->withCount('likes')
            ->get()
            ->sum('likes_count');

        $forumCount = Forum::where('user_id', $targetUser->id)->count();
        $commentCount = Comment::where('user_id', $targetUser->id)->count();
        $totalActivity = $forumCount + $commentCount;

        $forumChartData = $this->getChartData(Forum::class);
        $CommentChartData = $this->getChartData(Comment::class);
        $activityChart = array_map(fn ($f, $r) => $f + $r, $forumChartData, $CommentChartData);

        $forumViews = Forum::where('user_id', $targetUser->id)->sum('view_count');
        $writingViews = Writing::where('user_id', $targetUser->id)->sum('view_count');
        $totalViews = $forumViews + $writingViews;

        $forumViewChart = $this->getViewChartData(Forum::class);
        $writingViewChart = $this->getViewChartData(Writing::class);

        $viewsChart = array_map(fn ($f, $w) => $f + $w, $forumViewChart, $writingViewChart);

        $cardStyle = [
            'class' => 'relative min-h-[200px] pb-20 overflow-hidden',
        ];

        return [
            Stat::make('Published Writings', $totalWritings)
                ->description('7 days trend')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($writingChart)
                ->color('primary')
                ->extraAttributes($cardStyle),

            Stat::make('Total Likes', $totalLikes)
                ->description('All time engagement')
                ->descriptionIcon('heroicon-m-heart')
                ->chart($writingChart)
                ->color('danger')
                ->extraAttributes($cardStyle),

            Stat::make('Forum Contribs', $totalActivity)
                ->description('Threads & Replies')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->chart($activityChart)
                ->color('info')
                ->extraAttributes($cardStyle),

            Stat::make('Total Content Views', number_format($totalViews))
                ->description('7 days view trend')
                ->descriptionIcon('heroicon-m-eye')
                ->chart($viewsChart)
                ->color('warning')
                ->extraAttributes($cardStyle),
        ];
    }
}
