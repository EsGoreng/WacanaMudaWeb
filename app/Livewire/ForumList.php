<?php

namespace App\Livewire;

use App\Models\Forum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ForumList extends Component
{
    use WithPagination;

    public $category = null;

    public $search = '';

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
        $forums = Forum::query()
            ->with(['user', 'category', 'votes'])
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
