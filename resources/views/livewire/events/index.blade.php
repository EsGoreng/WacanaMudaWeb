<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-3">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div wire:key="event-card-{{ $event->id }}">
                    <x-event.card :event="$event" />
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>

        <x-event.event-modal wire:model.live="isModalOpen" maxWidth="5xl">
            @if ($selectedEvent)
                <x-event.detail :event="$selectedEvent" :is-bookmarked="$isBookmarked" />
            @endif
        </x-event.event-modal>

    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">
            <div class="p-6 bg-white/5 rounded-xl border border-white/10 text-white">
                <h3 class="font-bold mb-4">Filter & Info</h3>
                <p class="text-sm text-gray-400">Sidebar ini akan tetap terlihat (sticky) saat Anda scroll ke bawah.</p>
            </div>
        </div>
    </div>

</div>
