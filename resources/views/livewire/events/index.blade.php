<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-3">
        <x-filter.header :results="$events" :categories="$this->categories" :selectedCategories="$selectedCategories" :search="$search" :sortBy="$sortBy"
            :dateFrom="$dateFrom" :dateTo="$dateTo" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($events as $event)
                <div wire:key="event-card-{{ $event->id }}">
                    <x-event.card :event="$event" />
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 md:py-16 px-4">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-zinc-50 dark:bg-zinc-800/50 rounded-full mb-4 md:mb-6 border border-zinc-200/50 dark:border-zinc-700/50">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-zinc-950 dark:text-zinc-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold dark:text-white text-black mb-2">No events found</h3>
                    <p class="text-sm md:text-base dark:text-zinc-400 text-zinc-700 mb-6 max-w-md mx-auto">
                        We couldn't find any events matching your criteria.
                    </p>
                </div>
            @endforelse
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
        <x-filter.sidebar title="Search Events" :categories="$this->categories" :selectedCategories="$selectedCategories" count-key="events_count">
            <div>
                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-2">Sort By</label>
                <select wire:model.live="sortBy"
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm p-2">
                    <option value="latest">Default</option>
                    <optgroup label="Event Schedule">
                        <option value="event_date_nearest">Date: Nearest First</option>
                        <option value="event_date_furthest">Date: Furthest First</option>
                    </optgroup>
                    <optgroup label="Posting Date">
                        <option value="published_newest">Posted: Newest</option>
                        <option value="published_oldest">Posted: Oldest</option>
                    </optgroup>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Event Date</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" wire:model.live="dateFrom"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-2 text-xs" />
                    <input type="date" wire:model.live="dateTo"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-2 text-xs" />
                </div>
            </div>
        </x-filter.sidebar>
    </div>
</div>
