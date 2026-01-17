<?php

namespace App\Livewire;

use App\Models\Writing;
use App\Models\WritingComment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class WritingDetail extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public Writing $writing;

    public $editingCommentId = null;

    public $editingBody = '';

    public $commentBody = '';

    public function mount(Writing $writing)
    {
        $this->writing = $writing;

        if ($this->writing->status !== 'published' && $this->writing->status !== 'Published') {
            abort(404);
        }

        if (! empty($this->writing->unsplash_download_location)) {
            $this->triggerUnsplashDownload($this->writing->unsplash_download_location);
        }
    }

    private function triggerUnsplashDownload(string $downloadLocation): void
    {
        try {
            Http::withOptions([
                'verify' => false,
                'connect_timeout' => 10,
                'timeout' => 10,
                'curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4],
            ])->get($downloadLocation, [
                'client_id' => env('UNSPLASH_ACCESS_KEY'),
            ]);
        } catch (\Exception $e) {
            \Log::warning('Failed to trigger Unsplash download: '.$e->getMessage());
        }
    }

    public function articleInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->writing)
            ->components([
                TextEntry::make('content')
                    ->hiddenLabel()
                    ->prose()
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

    public function postComment()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'commentBody' => 'required|min:3|max:1000',
        ]);

        WritingComment::create([
            'user_id' => Auth::id(),
            'writing_id' => $this->writing->writing_id,
            'body' => $this->commentBody,
        ]);

        $this->commentBody = '';
        $this->dispatch('comment-posted');
        $this->writing->refresh();
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

        $this->writing->refresh();
    }

    public function render()
    {
        $latestPosts = Writing::with('user')
            ->where('status', 'published')
            ->where('writing_id', '!=', $this->writing->writing_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.writing-detail', [
            'latestPosts' => $latestPosts,
            'comments' => $this->writing->comments()->with('user')->latest()->get(),
            'likesCount' => $this->writing->likes()->count(),
            'isLiked' => Auth::check() ? $this->writing->isLikedBy(Auth::user()) : false,
        ])->layoutData([
            'title' => $this->writing->title.' | WMB',
            'contentClass' => '!p-0 !max-w-none min-h-screen',
        ]);
    }
}
