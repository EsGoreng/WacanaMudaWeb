<?php

namespace App\Livewire\MyBookmarks;

use App\Models\Event;
use App\Services\BookmarkService;
use App\Traits\InteractsWithEventModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use InteractsWithEventModal;
    use WithPagination;

    public function toggleEventBookmark($eventId, BookmarkService $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $event = Event::find($eventId);

        if ($event) {
            $service->toggleBookmark(auth()->user(), $event);

            if ($this->selectedEvent && $this->selectedEvent->id == $eventId) {
                $this->isBookmarked = ! $this->isBookmarked;
            }
        }
    }

    public function render(BookmarkService $bookmarkService)
    {
        $user = Auth::user();

        return view('pages.dashboard.mybookmark', [
            'bookmarkedWritings' => $bookmarkService->getBookmarkedWritings($user),
            'bookmarkedForums' => $bookmarkService->getBookmarkedForums($user),
            'bookmarkedEvents' => $bookmarkService->getBookmarkedEvents($user),
        ])->layout('components.dashboard.layout');

    }
}
