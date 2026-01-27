<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-3">
        @if ($search || count($selectedCategories) > 0 || $sortBy !== 'latest' || $dateFrom || $dateTo)
            <div class="mb-6">
                <div
                    class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border-zinc-200/50 dark:border-zinc-800/50 border rounded-2xl p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-3 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 rounded-xl border border-zinc-400/50 dark:border-zinc-800/50">
                                <svg class="w-5 h-5 text-zinc-900 dark:text-zinc-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <div>
                                <div
                                    class="text-xs font-medium text-zinc-950 dark:text-zinc-500 uppercase tracking-wider mb-1">
                                    @if ($search)
                                        SEARCH RESULTS
                                        {{-- UBAH DARI: @elseif($selectedCategory) --}}
                                        {{-- MENJADI: --}}
                                    @elseif(count($selectedCategories) > 0)
                                        FILTER BY
                                    @else
                                        REFINED VIEW
                                    @endif
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-black dark:text-white mb-1">
                                    @if ($search)
                                        Search: "{{ $search }}"
                                    @elseif(count($selectedCategories) > 0)
                                        Selected Categories
                                    @else
                                        Filtered Events
                                    @endif
                                </h2>
                            </div>
                        </div>

                        <button wire:click="clearFilters"
                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 rounded-xl border border-zinc-400/50 dark:border-zinc-800/50 text-sm font-medium text-zinc-900 dark:text-zinc-50 hover:text-zinc-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            RESET
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-zinc-500/10 border border-zinc-500/20 rounded-lg text-xs font-medium text-zinc-950 dark:text-zinc-50">
                            {{ $events->total() }} RESULTS
                        </span>

                        @if (count($selectedCategories) > 0)
                            @foreach ($this->categories->whereIn('category_id', $selectedCategories) as $category)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-blue-500/20 {{ $category->badge_class ?? 'bg-blue-600 text-white' }} rounded-lg text-xs font-medium">
                                    {{ strtoupper($category->name) }}
                                </span>
                            @endforeach
                        @endif

                        @if ($sortBy !== 'latest')
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600/90 border border-zinc-500/20 rounded-lg text-xs font-medium text-white">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                {{ strtoupper(str_replace('_', ' ', $sortBy)) }}
                            </span>
                        @endif

                        @if ($dateFrom || $dateTo)
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600/90 border border-zinc-500/20 rounded-lg text-xs font-medium text-white">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @if ($dateFrom && $dateTo)
                                    {{ strtoupper(\Carbon\Carbon::parse($dateFrom)->format('M d')) }} -
                                    {{ strtoupper(\Carbon\Carbon::parse($dateTo)->format('M d')) }}
                                @elseif($dateFrom)
                                    FROM {{ strtoupper(\Carbon\Carbon::parse($dateFrom)->format('M d')) }}
                                @else
                                    UNTIL {{ strtoupper(\Carbon\Carbon::parse($dateTo)->format('M d')) }}
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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
                    <button wire:click="clearFilters" class="text-blue-600 hover:underline">Clear all filters</button>
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
        <div class="sticky top-8 space-y-6">
            <div
                class="group rounded-xl bg-gradient-to-br backdrop-blur-sm from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        Search Events
                    </h3>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Title, location..."
                            class="block w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2.5 pl-10 pr-10 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                    </div>

                    <div x-data="{ open: false }" class="space-y-3">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-all">
                            <div class="flex items-center gap-2">
                                <svg class="size-5 text-zinc-600 dark:text-zinc-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Filters</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Sort By
                                </label>
                                <select wire:model.live="sortBy"
                                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm p-2">
                                    <option value="latest">Default (Recommended)</option>

                                    <optgroup label="Event Schedule">
                                        <option value="event_date_nearest">Date: Nearest First (Jan &rarr; Dec)
                                        </option>
                                        <option value="event_date_furthest">Date: Furthest First (Dec &rarr; Jan)
                                        </option>
                                    </optgroup>

                                    <optgroup label="Posting Date">
                                        <option value="published_newest">Posted: Newest First</option>
                                        <option value="published_oldest">Posted: Oldest First</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                    Event Date
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="date" wire:model.live="dateFrom"
                                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-2 text-xs" />
                                    <input type="date" wire:model.live="dateTo"
                                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-2 text-xs" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        Categories
                    </h3>
                    <div
                        class="flex flex-wrap gap-2 max-h-[400px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 scrollbar-track-transparent">

                        @foreach ($this->categories as $category)
                            @php $isActive = in_array($category->category_id, $selectedCategories); @endphp

                            <label class="cursor-pointer group">
                                <input type="checkbox" wire:model.live="selectedCategories"
                                    value="{{ $category->category_id }}" class="hidden" />

                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full border transition-all duration-200 select-none {{ $isActive ? 'bg-blue-600 border-blue-600 text-white shadow-sm shadow-blue-500/30' : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700/50 text-zinc-600 dark:text-zinc-400 hover:border-blue-400 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400' }}">
                                    {{ $category->name }}

                                    @if (isset($category->events_count) && $category->events_count > 0)
                                        <span
                                            class="ml-0.5 text-[10px] {{ $isActive ? 'text-blue-100' : 'text-zinc-400 dark:text-zinc-500' }}">
                                            {{ $category->events_count }}
                                        </span>
                                    @endif
                                </span>
                            </label>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
