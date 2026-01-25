<?php

namespace App\Livewire\Writings;

use App\Models\ContentView;
use App\Models\Writing;
use App\Models\WritingComment;
use App\Services\BookmarkService;
use App\Services\UnsplashService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;

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

    public $commentBody = '';

    public $replyBody = '';

    public $editingBody = '';

    public function mount(Writing $writing, BookmarkService $service)
    {
        if (auth()->check()) {
            $this->isBookmarked = $service->isBookmarked(auth()->user(), $this->writing);
        }

        $this->writing = $writing;

        if ($this->writing->status !== 'published' && $this->writing->status !== 'Published') {
            abort(404);
        }

        if (! empty($this->writing->unsplash_download_location)) {
            (new UnsplashService)->triggerUnsplashDownload($this->writing->unsplash_download_location);
        }

        $this->commentForm->fill();
        $this->replyForm->fill();

        $this->writing = $writing;

        $this->writing->increment('view_count');

        ContentView::create([
            'viewable_type' => Writing::class,
            'viewable_id' => $this->writing->writing_id,
        ]);
    }

    public function toggleBookmark(BookmarkService $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $this->isBookmarked = $service->toggleBookmark(auth()->user(), $this->writing);
    }

    public function articleInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->writing)
            ->components([
                TextEntry::make('content')
                    ->hiddenLabel()
                    ->html()
                    ->columnSpanFull(),

            ]);
    }

    public function generateInstagramStory()
    {
        $html = view('components.social-story', [
            'writing' => $this->writing,
        ])->render();

        $fileName = Str::slug($this->writing->title).'-story.jpg';

        $screenshot = Browsershot::html($html)
            ->windowSize(1080, 1920)
            ->noSandbox()
            ->screenshot();

        return response()->streamDownload(function () use ($screenshot) {
            echo $screenshot;
        }, $fileName);
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

    public function createComment()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->commentForm->getState();

        WritingComment::create([
            'user_id' => Auth::id(),
            'writing_id' => $this->writing->writing_id,
            'body' => $data['comment'],
            'parent_id' => null,
        ]);

        $this->commentForm->fill();
        $this->dispatch('comment-posted');
    }

    public function createReply()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $data = $this->replyForm->getState();

        WritingComment::create([
            'user_id' => Auth::id(),
            'writing_id' => $this->writing->writing_id,
            'body' => $data['reply'],
            'parent_id' => $this->parentCommentId,
        ]);

        $this->replyForm->fill();
        $this->parentCommentId = null;
        $this->dispatch('comment-posted');
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

    public function deleteComment($commentId)
    {
        $comment = WritingComment::find($commentId);
        if (! $comment) {
            return;
        }

        $user = Auth::user();
        if ($comment->user_id === $user->id || $user->hasAnyRole(['superadmin', 'admin'])) {
            $comment->delete();
        }
    }

    public function editComment($commentId)
    {
        $comment = WritingComment::find($commentId);

        if (! $comment || $comment->user_id !== Auth::id()) {
            return;
        }

        $this->editingCommentId = $commentId;
        $this->editingBody = $comment->body;
    }

    public function updateComment()
    {
        $this->validate([
            'editingBody' => 'required|min:1|max:1000',
        ]);

        $comment = WritingComment::find($this->editingCommentId);

        if ($comment && $comment->user_id === Auth::id()) {
            $comment->update([
                'body' => $this->editingBody,
            ]);
        }

        $this->cancelEdit();
        $this->writing->refresh();
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

        $comments = WritingComment::where('writing_id', $this->writing->writing_id)
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
