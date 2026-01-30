<?php

namespace App\Livewire\LandingPage;

use App\Models\Event;
use App\Services\BookmarkService;
use App\Services\StoryGeneratorService;
use App\Traits\InteractsWithEventModal;
use Livewire\Component;

class UpcomingEvents extends Component
{
    use InteractsWithEventModal;

    public $limit = 3;

    public $title = 'AGENDA KEGIATAN';

    public $subtitle = '';

    public $isVisible = true;

    public function mount($data = [])
    {
        $this->title = $data['section_title'] ?? 'AGENDA KEGIATAN';
        $this->subtitle = $data['section_subtitle'] ?? '';
        $this->limit = $data['limit'] ?? 3;
        $this->isVisible = $data['is_visible'] ?? true;
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
            ->whereIn('status', ['published', 'ongoing'])
            ->where('end_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take($this->limit)
            ->with(['categories'])
            ->get();

        return view('livewire.landing-page.upcoming-events', [
            'events' => $events,
        ]);
    }
}
