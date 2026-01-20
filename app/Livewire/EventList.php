<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class EventList extends Component
{
    use WithPagination;

    public ?Event $selectedEvent = null;

    public bool $isModalOpen = false;

    public function openModal($eventId)
    {
        $this->selectedEvent = Event::find($eventId);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('selectedEvent');
    }

    public function render()
    {
        $events = Event::query()
            ->with('categories')
            ->latest()
            ->paginate(10);

        return view('livewire.event-list', [
            'events' => $events,
        ]);
    }
}
