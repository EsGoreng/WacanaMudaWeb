<?php

namespace App\Livewire;

use App\Models\Forum;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ForumDetail extends Component
{
    use WithPagination;

    public Forum $forum;

    public $replyBody = '';

    public $parentReplyId = null;

    public $editingReplyId = null;

    public $editingBody = '';

    public $userVoteType = null;

    public $score = 0;

    public function mount(Forum $forum)
    {
        $this->forum = $forum;

        $this->forum->load(['user', 'category', 'votes']);

        $this->forum->increment('view_count');
        $this->calculateScore();
    }

    public function calculateScore()
    {
        $this->score = $this->forum->votes()->where('type', 'up')->count() -
                       $this->forum->votes()->where('type', 'down')->count();

        if (Auth::check()) {
            $vote = $this->forum->votes()->where('user_id', Auth::id())->first();
            $this->userVoteType = $vote ? $vote->type : null;
        }
    }

    public function vote($type)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $existingVote = $this->forum->votes()->where('user_id', Auth::id())->first();

        if ($existingVote) {
            if ($existingVote->type === $type) {
                $existingVote->delete();
                $this->userVoteType = null;
            } else {
                $existingVote->update(['type' => $type]);
                $this->userVoteType = $type;
            }
        } else {
            $this->forum->votes()->create([
                'user_id' => Auth::id(),
                'type' => $type,
            ]);
            $this->userVoteType = $type;
        }

        $this->calculateScore();
    }

    public function postReply()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'replyBody' => 'required|min:3|max:2000',
        ]);

        Reply::create([
            'forum_id' => $this->forum->id,
            'user_id' => Auth::id(),
            'body' => $this->replyBody,
            'parent_id' => $this->parentReplyId,
        ]);

        $this->replyBody = '';
        $this->parentReplyId = null;
        $this->dispatch('reply-posted');
    }

    public function setReplyTo($id)
    {
        $this->parentReplyId = ($this->parentReplyId === $id) ? null : $id;
    }

    public function editReply($replyId)
    {
        $reply = Reply::find($replyId);

        if (! $reply || $reply->user_id !== Auth::id()) {
            return;
        }

        $this->editingReplyId = $replyId;
        $this->editingBody = $reply->body;
    }

    public function updateReply()
    {
        $this->validate([
            'editingBody' => 'required|min:1|max:2000',
        ]);

        $reply = Reply::find($this->editingReplyId);

        if ($reply && $reply->user_id === Auth::id()) {
            $reply->update([
                'body' => $this->editingBody,
            ]);
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingReplyId = null;
        $this->editingBody = '';
    }

    public function deleteReply($replyId)
    {
        $reply = Reply::find($replyId);

        if (! $reply) {
            return;
        }

        $user = Auth::user();

        if ($reply->user_id === $user->id || ($user->hasAnyRole(['superadmin', 'admin']) ?? false)) {
            $reply->delete();
        }
    }

    public function render()
    {
        $latestForums = Forum::where('id', '!=', $this->forum->id)
            ->with('category', 'user')
            ->latest()
            ->take(3)
            ->get();

        $replies = $this->forum->replies()
            ->whereNull('parent_id')
            ->with(['user', 'votes', 'children' => function ($query) {
                $query->with(['user', 'votes']);
            }])
            ->latest()
            ->paginate(10);

        return view('livewire.forum-detail', [
            'replies' => $replies,
            'latestForums' => $latestForums,
        ])->layoutData([
            'title' => $this->forum->title,
        ]);
    }
}
