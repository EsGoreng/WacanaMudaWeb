<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="mb-6 md:mb-10">
            @if (
                $search ||
                    count($selectedCategories) > 0 ||
                    $sortBy !== 'latest' ||
                    $dateFrom ||
                    $dateTo ||
                    $readingTimeMin ||
                    $readingTimeMax)

                <x-filter.header :results="$this->posts" :categories="$this->categories" :selectedCategories="$selectedCategories" :search="$search"
                    :sortBy="$sortBy" :dateFrom="$dateFrom" :dateTo="$dateTo"
                    custom-active="{{ $readingTimeMin || $readingTimeMax }}">
                    @if ($readingTimeMin || $readingTimeMax)
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600/90 border border-zinc-500/20 rounded-lg text-xs font-medium text-white">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @if ($readingTimeMin && $readingTimeMax)
                                {{ $readingTimeMin }}-{{ $readingTimeMax }} MIN
                            @elseif($readingTimeMin)
                                {{ $readingTimeMin }}+ MIN
                            @else
                                UP TO {{ $readingTimeMax }} MIN
                            @endif
                        </span>
                    @endif
                </x-filter.header>
            @else
                <div class="space-y-6 md:space-y-8">
                    <div class="group cursor-default">
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-bold text-black dark:text-white mb-4 tracking-tight">
                            {!! $literacyContent['heading'] !!}
                        </h1>
                        <div class="max-w-2xl">
                            <p
                                class="text-sm md:text-base text-zinc-800 dark:text-zinc-400 leading-relaxed italic border-l-2 border-zinc-700 pl-4 mb-2">
                                “{{ $literacyContent['quote'] }}”
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                        <div
                            class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border-zinc-200/50 dark:border-zinc-800/50 backdrop-blur-xs border rounded-lg md:rounded-xl p-4 md:p-6 hover:border-page-gray-500/30 transition-all group">
                            <div class="flex items-start justify-between mb-3">
                                <div
                                    class="text-xs text-zinc-950 dark:text-zinc-500 uppercase tracking-wider font-medium">
                                    TOTAL WRITINGS</div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 dark:text-zinc-400 text-zinc-800 group-hover:text-page-gray-500 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="text-3xl md:text-4xl font-bold dark:text-whitetext-black">
                                {{ $this->posts->total() }}</div>
                        </div>
                        <div
                            class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border-zinc-200/50 dark:border-zinc-800/50 backdrop-blur-xs border rounded-lg md:rounded-xl p-4 md:p-6 hover:border-page-gray-500/30 transition-all group">
                            <div class="flex items-start justify-between mb-3">
                                <div
                                    class="text-xs text-zinc-950 dark:text-zinc-500 uppercase tracking-wider font-medium">
                                    TOTAL AUTHORS</div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 dark:text-zinc-400 text-zinc-800 group-hover:text-page-gray-500 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl md:text-4xl font-bold dark:text-white text-black">{{ $totalAuthors }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if ($this->posts->isEmpty())
            <div class="text-center py-12 md:py-16 px-4">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-zinc-50 dark:bg-zinc-800/50 rounded-full mb-4 md:mb-6 border border-zinc-200/50 dark:border-zinc-700/50">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-zinc-950 dark:text-zinc-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold dark:text-white text-black mb-2">No writings found</h3>
                <p class="text-sm md:text-base dark:text-zinc-400 text-zinc-700 mb-6 max-w-md mx-auto">
                    We couldn't find any writings matching your criteria. Try adjusting your filters.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <button wire:click="clearFilters"
                        class="w-full sm:w-auto px-6 py-3 bg-zinc-800 hover:bg-zinc-700 text-white rounded-xl font-medium transition-colors text-sm">
                        Clear All Filters
                    </button>
                </div>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach ($this->posts as $post)
                    <div wire:key="post-{{ $post->writing_id }}">
                        <x-writing.card :writing="$post" />
                        @if (!$loop->last)
                            <div class="mt-6 mb-2">
                                <hr class="border-zinc-200 dark:border-zinc-800" />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8 md:mt-12">
                {{ $this->posts->links() }}
            </div>
        @endif
    </div>

    <div class="lg:col-span-1">
        <x-filter.sidebar title="Search Writings" :categories="$this->categories" :selectedCategories="$selectedCategories" count-key="writings_count">
            <div>
                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-2">Sort By</label>
                <select wire:model.live="sortBy"
                    class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 pl-3 pr-10 text-sm text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm">
                    <option value="latest">Latest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="popular">Most Viewed</option>
                    <option value="most_liked">Most Liked</option>
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Published Date</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="date" wire:model.live="dateFrom"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                    <input type="date" wire:model.live="dateTo"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">Reading Time (minutes)</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" wire:model.live.debounce.300ms="readingTimeMin" placeholder="Min"
                        min="0"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                    <input type="number" wire:model.live.debounce.300ms="readingTimeMax" placeholder="Max"
                        min="0"
                        class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                </div>
            </div>
        </x-filter.sidebar>
    </div>
</div>
