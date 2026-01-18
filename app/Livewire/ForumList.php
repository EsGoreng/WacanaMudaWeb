<?php

namespace App\Livewire;

use App\Models\Forum;
use Livewire\Component;
use Livewire\WithPagination;

class ForumList extends Component
{
    use WithPagination;

    public $category = null;

    public $search = '';

    public function render()
    {
        $forums = Forum::query()
            ->with(['user', 'category'])
            ->withCount(['replies', 'votes'])
            ->when($this->category, fn ($q) => $q->where('category_id', $this->category))
            ->when($this->search, fn ($q) => $q->where('title', 'like', '%'.$this->search.'%'))
            ->latest()
            ->paginate(10);

        return view('livewire.forum-list', [
            'forums' => $forums,
        ]);
    }
}
