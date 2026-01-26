<?php

namespace App\Livewire\Forums;

use App\Models\Category;
use App\Models\Forum;
use App\Services\BookmarkService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $category = null;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: null)]
    public $selectedCategory = null;

    #[Url(except: 'latest')]
    public $sortBy = 'latest';

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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategory', 'sortBy', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    #[Computed]
    public function categories()
    {
        return Category::whereHas('forums')
            ->withCount(['forums' => function ($q) {
                if (! empty($this->search)) {
                    $q->where('title', 'like', '%'.$this->search.'%');
                }
            }])
            ->orderBy('name')
            ->get();
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
            ->with(['user', 'category', 'votes'])
            ->withCount(['comments', 'votes']);

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('body', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
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
            default:
                $query->latest();
                break;
        }

        return view('livewire.forums.index', [
            'forums' => $query->paginate(10),
        ]);
    }
}
