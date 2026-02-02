<?php

namespace App\Livewire\LandingPage;

use App\Models\Event;
use App\Services\BookmarkService;
use App\Services\StoryGeneratorService;
use App\Traits\InteractsWithEventModal;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class HomeEvents extends Component
{
    use InteractsWithEventModal;

    public $data = [];

    public function mount($data)
    {
        $this->data = $data;
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
        $event = Event::find($eventId);

        if (! $event) {
            return;
        }

        $htmlContent = $service->generate($event, 'components.event.story', 'event');

        if (! $htmlContent) {
            return;
        }

        $this->dispatch('start-story-download',
            html: $htmlContent,
            fileName: Str::slug($event->title).'-story.jpg'
        );

        Notification::make()
            ->title('Processing Image...')
            ->body('Download will start....')
            ->success()
            ->send();
    }

    public function render()
    {
        $events = Event::query()
            ->with(['categories', 'bookmarks'])
            ->whereIn('status', ['published', 'ongoing'])
            ->whereDate('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take($this->data['limit'] ?? 3)
            ->get();

        return view('livewire.landing-page.home-events', [
            'events' => $events,
        ]);
    }
}
