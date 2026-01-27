<?php

namespace App\Livewire\Forums;

use App\Models\Category;
use App\Models\Forum;
use App\Services\BookmarkService;
use App\Traits\InteractsWithContentFilters;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use InteractsWithContentFilters;
    use WithPagination;

    #[Computed]
    public function categories()
    {
        return Category::whereHas('forums')
            ->withCount(['forums' => function ($q) {
                if (! empty($this->search)) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('body', 'like', '%'.$this->search.'%');
                }
            }])
            ->orderBy('name')
            ->get();
    }

    public function toggleBookmark($forumId, BookmarkService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        $forum = Forum::find($forumId);
        if ($forum) {
            $service->toggleBookmark(Auth::user(), $forum);
        }
    }

    public function vote($forumId, $type)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $forum = Forum::find($forumId);
        if (! $forum) {
            return;
        }

        $existingVote = $forum->votes()->where('user_id', Auth::id())->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                $existingVote->delete();
            } else {
                $existingVote->update(['type' => $type]);
            }
        } else {
            $forum->votes()->create([
                'user_id' => Auth::id(),
                'type' => $type,
            ]);
        }
    }

    public function render()
    {
        $query = Forum::query()
            ->with(['user', 'categories', 'votes'])
            ->withCount([
                'comments',
                'votes',
                'votes as up_votes_count' => function ($query) {
                    $query->where('type', 'up');
                },
                'votes as down_votes_count' => function ($query) {
                    $query->where('type', 'down');
                },
            ]);

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('body', 'like', '%'.$this->search.'%');
            });
        }

        if (! empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($q) {
                $q->whereIn('categories.category_id', $this->selectedCategories);
            });
        }

        if (! empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if (! empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'popular':
                $query->orderByDesc('view_count');
                break;
            case 'most_replied':
                $query->orderByDesc('comments_count');
                break;
            case 'most_upvoted':
                $query->orderByDesc('up_votes_count');
                break;
            case 'most_downvoted':
                $query->orderByDesc('down_votes_count');
                break;
            default:
                $query->latest();
                break;
        }

        return view('livewire.forums.index', [
            'forums' => $query->paginate(5),
        ]);
    }
}
