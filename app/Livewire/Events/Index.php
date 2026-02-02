<?php

namespace App\Livewire\Events;

use App\Models\Category;
use App\Models\Event;
use App\Services\BookmarkService;
use App\Services\StoryGeneratorService;
use App\Traits\InteractsWithContentFilters;
use App\Traits\InteractsWithEventModal;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use InteractsWithContentFilters;
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

    #[Computed]
    public function categories()
    {
        // ... Logika kategori tetap sama ...
        $validStatuses = ['published', 'ongoing', 'ended', 'canceled'];

        return Category::whereHas('events', function ($query) use ($validStatuses) {
            $query->whereIn('status', $validStatuses);
        })->withCount(['events' => function ($query) use ($validStatuses) {
            // ... logic count ...
            $query->whereIn('status', $validStatuses);
            if (! empty($this->search)) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('location_name', 'like', '%'.$this->search.'%');
                });
            }
        }])->orderBy('name')->get();
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
        $query = Event::query()
            ->with('categories', 'bookmarks');

        $query->whereIn('status', ['published', 'ongoing', 'ended', 'canceled']);

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->orWhere('location_name', 'like', '%'.$this->search.'%');
            });
        }

        if (! empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($q) {
                $q->whereIn('categories.category_id', $this->selectedCategories);
            });
        }

        if (! empty($this->dateFrom)) {
            $query->whereDate('start_time', '>=', $this->dateFrom);
        }
        if (! empty($this->dateTo)) {
            $query->whereDate('start_time', '<=', $this->dateTo);
        }

        switch ($this->sortBy) {

            case 'event_date_nearest':
                $query->orderBy('start_time', 'asc');
                break;
            case 'event_date_furthest':
                $query->orderBy('start_time', 'desc');
                break;

            case 'published_newest':
                $query->latest();
                break;
            case 'published_oldest':
                $query->oldest();
                break;

            default:
                $query->orderByRaw("FIELD(status, 'published', 'ongoing', 'ended', 'canceled') ASC")
                    ->orderBy('start_time', 'asc');
                break;
        }

        return view('livewire.events.index', [
            'events' => $query->paginate(6),
        ]);
    }
}
