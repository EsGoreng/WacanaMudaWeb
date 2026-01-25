<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Services\BookmarkService;
use App\Traits\InteractsWithEventModal;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;

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

    public function generateInstagramStory($eventId)
    {
        $event = Event::with('categories')->find($eventId);

        if (! $event) {
            return;
        }

        $html = view('components.event-social-story', [
            'event' => $event,
        ])->render();

        $fileName = Str::slug($event->title).'-story.jpg';

        $screenshot = Browsershot::html($html)
            ->windowSize(1080, 1920)
            ->deviceScaleFactor(1)
            ->noSandbox()
            ->waitUntilNetworkIdle()
            ->screenshot();

        return response()->streamDownload(function () use ($screenshot) {
            echo $screenshot;
        }, $fileName);
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
