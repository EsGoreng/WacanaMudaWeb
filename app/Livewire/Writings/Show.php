<?php

namespace App\Livewire\Writings;

use App\Models\Comment;
use App\Models\ContentView;
use App\Models\Writing;
use App\Services\BookmarkService;
use App\Services\CommentService;
use App\Services\StoryGeneratorService;
use App\Services\UnsplashService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component implements HasForms
{
    use InteractsWithForms;
    use WithPagination;

    public Writing $writing;

    public bool $isBookmarked = false;

    public ?array $commentData = [];

    public ?array $replyData = [];

    public $editingCommentId = null;

    public $parentCommentId = null;

    public $editingBody = '';

    public function mount(Writing $writing, BookmarkService $service)
    {
        $this->writing = $writing;

        $isPublished = in_array($this->writing->status, ['published', 'Published']);

        $isAuthor = Auth::check() && Auth::id() === $this->writing->user_id;

        if (! $isPublished && ! $isAuthor) {
            abort(404);
        }

        if (auth()->check()) {
            $this->isBookmarked = $service->isBookmarked(auth()->user(), $this->writing);
        }

        if (! empty($this->writing->unsplash_download_location)) {
            (new UnsplashService)->triggerUnsplashDownload($this->writing->unsplash_download_location);
        }

        $this->commentForm->fill();
        $this->replyForm->fill();

        $sessionKey = 'viewed_writing_'.$this->writing->writing_id;

        if (! Session::has($sessionKey)) {
            ContentView::create([
                'viewable_type' => Writing::class,
                'viewable_id' => $this->writing->writing_id,
            ]);

            $this->writing->increment('view_count');

            Session::put($sessionKey, true);
        }
    }

    public function generateInstagramStory(StoryGeneratorService $service)
    {
        if (! $this->writing) {
            return;
        }

        $htmlContent = $service->generate($this->writing, 'components.writing.story', 'writing');

        if (! $htmlContent) {
            return;
        }

        $this->dispatch('start-story-download',
            html: $htmlContent,
            fileName: Str::slug($this->writing->title).'-story.jpg'
        );

        Notification::make()
            ->title('Memproses Story...')
            ->body('Gambar sedang dibuat di latar belakang.')
            ->success()
            ->send();
    }

    public function toggleBookmark(BookmarkService $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }
        $this->isBookmarked = $service->toggleBookmark(auth()->user(), $this->writing);
    }

    public function toggleLike()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        $this->writing->likes()->toggle(Auth::id());
        $this->writing->refresh();
    }

    protected function getForms(): array
    {
        return ['commentForm', 'replyForm'];
    }

    public function commentForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('comment')
                    ->label('Comment')
                    ->placeholder('What are your thoughts?')
                    ->autosize()
                    ->minLength(3)
                    ->maxLength(1000)
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
                    ->placeholder('Write a reply...')
                    ->autosize()
                    ->minLength(1)
                    ->maxLength(1000)
                    ->required(),
            ])
            ->statePath('replyData');
    }

    public function createComment(CommentService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->commentForm->getState();

        $service->createComment($this->writing, $data['comment']);

        $this->commentForm->fill();
        $this->dispatch('comment-posted');
    }

    public function createReply(CommentService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->replyForm->getState();

        $service->createComment(
            $this->writing,
            $data['reply'],
            $this->parentCommentId
        );

        $this->replyForm->fill();
        $this->parentCommentId = null;
        $this->dispatch('comment-posted');
    }

    public function updateComment(CommentService $service)
    {
        $this->validate([
            'editingBody' => 'required|min:1|max:1000',
        ]);

        $comment = Comment::find($this->editingCommentId);

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
        if ($this->parentCommentId === $id) {
            $this->parentCommentId = null;
            $this->replyData = [];
        } else {
            $this->parentCommentId = $id;
            $this->replyForm->fill();
        }
    }

    public function editComment($commentId)
    {
        $comment = Comment::find($commentId);

        if (! $comment || $comment->user_id !== Auth::id()) {
            return;
        }

        $this->editingCommentId = $commentId;
        $this->editingBody = $comment->body;
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingBody = '';
    }

    public function render()
    {
        $latestPosts = Writing::with('user')
            ->where('status', 'published')
            ->where('writing_id', '!=', $this->writing->writing_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $comments = $this->writing->comments()
            ->whereNull('parent_id')
            ->with(['user', 'children.user'])
            ->latest()
            ->paginate(10);

        return view('livewire.writings.show', [
            'latestPosts' => $latestPosts,
            'comments' => $comments,
            'likesCount' => $this->writing->likes()->count(),
            'isLiked' => Auth::check() ? $this->writing->isLikedBy(Auth::user()) : false,
        ])->layoutData([
            'title' => $this->writing->title.' | WMB',
            'contentClass' => '!p-0 !max-w-none min-h-screen',
        ]);
    }
}
