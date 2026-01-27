<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Services\BookmarkService;
use App\Services\StoryGeneratorService;
use App\Traits\InteractsWithEventModal;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use InteractsWithEventModal;
    use WithPagination;

    #[Url(as: 'id')]
    public $urlEventId = '';

    public function mount(BookmarkService $bookmarkService)
    {
        if ($this->urlEventId) {
            $this->openModal($this->urlEventId, $bookmarkService);
        }
    }

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

    public function generateInstagramStory($eventId, StoryGeneratorService $service)
    {
        $event = Event::with('categories')->find($eventId);

        return $service->generate($event, 'components.event.story', 'event');
    }

    public function render()
    {
        $events = Event::query()
            ->with('categories', 'bookmarks')
            ->whereIn('status', ['published', 'ongoing', 'ended', 'canceled'])
            ->orderByRaw("FIELD(status, 'published', 'ongoing', 'ended', 'canceled') ASC")
            ->latest()
            ->paginate(perPage: 6);

        return view('livewire.events.index', [
            'events' => $events,
        ]);
    }
}
