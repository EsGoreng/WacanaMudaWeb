<?php

namespace App\Traits;

use App\Models\Event;
use App\Services\BookmarkService;
use Illuminate\Support\Facades\Auth;

trait InteractsWithEventModal
{
    public ?Event $selectedEvent = null;

    public bool $isModalOpen = false;

    public bool $isBookmarked = false;

    public function updatedIsModalOpen($value)
    {
        if (! $value) {
            $this->reset('selectedEvent');
        }
    }

    public function openModal($eventId, BookmarkService $service)
    {
        $this->selectedEvent = Event::find($eventId);

        if ($this->selectedEvent && Auth::check()) {
            $this->isBookmarked = $service->isBookmarked(Auth::user(), $this->selectedEvent);
        } else {
            $this->isBookmarked = false;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('selectedEvent');
    }

    public function toggleBookmark(BookmarkService $service)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->selectedEvent) {
            $this->isBookmarked = $service->toggleBookmark(Auth::user(), $this->selectedEvent);
        }
    }
}
