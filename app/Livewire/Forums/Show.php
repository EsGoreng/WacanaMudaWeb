<?php

namespace App\Livewire\Forums;

use App\Models\ContentView;
use App\Models\Forum;
use App\Models\Reply;
use App\Services\StoryGeneratorService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component implements HasForms
{
    use InteractsWithForms;
    use WithPagination;

    public Forum $forum;

    public ?array $commentData = [];

    public ?array $replyData = [];

    public $parentReplyId = null;

    public $userVoteType = null;

    public $score = 0;

    public $editingReplyId = null;

    public $editingBody = '';

    public function mount(Forum $forum): void
    {
        $this->forum = $forum;
        $this->forum->load(['user', 'category', 'votes']);
        $this->forum->increment('view_count');

        ContentView::create([
            'viewable_type' => Forum::class,
            'viewable_id' => $this->forum->id,
        ]);
        $this->calculateScore();

        $this->commentForm->fill();
        $this->replyForm->fill();
    }

    public function generateInstagramStory(StoryGeneratorService $service)
    {
        return $service->generate($this->forum, 'components.forum.story', 'forum');
    }

    protected function getForms(): array
    {
        return [
            'commentForm',
            'replyForm',
        ];
    }

    public function commentForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('comment')
                    ->label('Comment')
                    ->placeholder('Write your comment...')
                    ->autosize()
                    ->minLength(1)
                    ->maxLength(1024)
                    ->required(),
            ])
            ->statePath('commentData');
    }

    public function replyForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('reply')
                    ->label('Reply')
                    ->placeholder('Write reply...')
                    ->autosize()
                    ->minLength(1)
                    ->maxLength(1024)
                    ->required(),
            ])
            ->statePath('replyData');
    }

    public function createComment()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->commentForm->getState();

        Reply::create([
            'forum_id' => $this->forum->id,
            'user_id' => Auth::id(),
            'body' => $data['comment'],
            'parent_id' => null,
        ]);

        $this->commentForm->fill();
        $this->dispatch('reply-posted');
    }

    public function createReply()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->replyForm->getState();

        Reply::create([
            'forum_id' => $this->forum->id,
            'user_id' => Auth::id(),
            'body' => $data['reply'],
            'parent_id' => $this->parentReplyId,
        ]);

        $this->replyForm->fill();
        $this->parentReplyId = null;
        $this->dispatch('reply-posted');
    }

    public function setReplyTo($id)
    {
        if ($this->parentReplyId === $id) {
            $this->parentReplyId = null;
            $this->replyData = [];
        } else {
            $this->parentReplyId = $id;
            $this->replyForm->fill();
        }
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
            ->with(['user', 'votes', 'children.user', 'children.votes'])
            ->latest()
            ->paginate(10);

        return view('livewire.forums.show', [
            'replies' => $replies,
            'latestForums' => $latestForums,
        ])->layoutData([
            'title' => $this->forum->title.' | WMB',
        ]);
    }
}
