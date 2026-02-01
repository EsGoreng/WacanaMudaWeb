<?php

namespace App\Livewire\Forums;

use App\Models\Comment;
use App\Models\ContentView;
use App\Models\Forum;
use App\Services\BookmarkService;
use App\Services\CommentService;
use App\Services\StoryGeneratorService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

    public $editingReplyId = null;

    public $editingBody = '';

    public $userVoteType = null;

    public bool $isBookmarked = false;

    public $score = 0;

    public function mount(Forum $forum, BookmarkService $bookmarkService): void
    {
        $this->forum = $forum;
        $this->forum->load(['user', 'categories', 'votes']);
        $sessionKey = 'viewed_forum_'.$this->forum->id;

        if (! Session::has($sessionKey)) {
            ContentView::create([
                'viewable_type' => Forum::class,
                'viewable_id' => $this->forum->id,
            ]);

            $this->forum->increment('view_count');

            Session::put($sessionKey, true);
        }

        if (auth()->check()) {
            $this->isBookmarked = $bookmarkService->isBookmarked(auth()->user(), $this->forum);
        }

        $this->calculateScore();

        $this->commentForm->fill();
        $this->replyForm->fill();
    }

    public function toggleBookmark(BookmarkService $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $this->isBookmarked = $service->toggleBookmark(auth()->user(), $this->forum);
    }

    public function generateInstagramStory(StoryGeneratorService $service)
    {
        return $service->generate($this->forum, 'components.forum.story', 'forum');
    }

    protected function getForms(): array
    {
        return ['commentForm', 'replyForm'];
    }

    public function commentForm(Schema $form): Schema
    {
        return $form->schema([
            Textarea::make('comment')
                ->label('Comment')
                ->placeholder('Write your comment...')
                ->autosize()
                ->required(),
        ])->statePath('commentData');
    }

    public function replyForm(Schema $form): Schema
    {
        return $form->schema([
            Textarea::make('reply')
                ->label('Reply')
                ->placeholder('Write reply...')
                ->autosize()
                ->required(),
        ])->statePath('replyData');
    }

    public function createComment(CommentService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->commentForm->getState();

        $service->createComment($this->forum, $data['comment']);

        $this->commentForm->fill();
        $this->dispatch('reply-posted');
    }

    public function createReply(CommentService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->replyForm->getState();

        $service->createComment(
            $this->forum,
            $data['reply'],
            $this->parentReplyId
        );

        $this->replyForm->fill();
        $this->parentReplyId = null;
        $this->dispatch('reply-posted');
    }

    public function updateReply(CommentService $service)
    {
        $comment = Comment::find($this->editingReplyId);

        if ($comment) {
            $service->updateComment($comment, $this->editingBody, Auth::id());
        }

        $this->cancelEdit();
    }

    public function deleteComment($commentId, CommentService $service)
    {
        $comment = Comment::find($commentId);

        if ($comment) {
            $service->deleteComment($comment, Auth::user());
        }
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

    public function editReply($replyId)
    {
        $comment = Comment::find($replyId);

        if (! $comment || $comment->user_id !== Auth::id()) {
            return;
        }

        $this->editingReplyId = $replyId;
        $this->editingBody = $comment->body;
    }

    public function cancelEdit()
    {
        $this->editingReplyId = null;
        $this->editingBody = '';
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

    public function vote($forumId, $type)
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

    public function render()
    {
        $latestForums = Forum::where('id', '!=', $this->forum->id)
            ->with('categories', 'user')
            ->withCount('comments')
            ->latest()
            ->take(3)
            ->get();

        $replies = $this->forum->comments()
            ->whereNull('parent_id')
            ->with(['user', 'children.user'])
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
