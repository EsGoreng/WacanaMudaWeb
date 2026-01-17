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
                <div class="bg-zinc-900/50 backdrop-blur-sm border border-zinc-800/50 rounded-2xl p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-zinc-800/50 rounded-xl border border-zinc-700/50">
                                <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-1">
                                    @if ($search)
                                        SEARCH RESULTS
                                    @elseif(count($selectedCategories) > 0)
                                        CATEGORY SELECTION
                                    @else
                                        REFINED VIEW
                                    @endif
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">
                                    @if ($search)
                                        Search: "{{ $search }}"
                                    @elseif(count($selectedCategories) > 0)
                                        Category Selection
                                    @else
                                        Filtered Results
                                    @endif
                                </h2>
                            </div>
                        </div>

                        <button wire:click="clearFilters"
                            class="flex items-center gap-2 px-4 py-2 bg-zinc-800/50 hover:bg-zinc-700/50 border border-zinc-700/50 rounded-lg text-sm font-medium text-zinc-300 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            RESET
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-500/10 border border-yellow-500/20 rounded-lg text-xs font-medium text-yellow-500">
                            {{ $this->posts->total() }} RESULTS
                        </span>

                        @if (count($selectedCategories) > 0)
                            @foreach ($this->categories->whereIn('category_id', $selectedCategories) as $category)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 border border-blue-500/20 rounded-lg text-xs font-medium text-blue-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    {{ strtoupper($category->name) }}
                                </span>
                            @endforeach
                        @endif

                        @if ($sortBy !== 'latest')
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-800/50 border border-zinc-700/50 rounded-lg text-xs font-medium text-zinc-300">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                {{ strtoupper(str_replace('_', ' ', $sortBy)) }}
                            </span>
                        @endif

                        {{-- Date Filter --}}
                        @if ($dateFrom || $dateTo)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-800/50 border border-zinc-700/50 rounded-lg text-xs font-medium text-zinc-300">
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

                        {{-- Reading Time Filter --}}
                        @if ($readingTimeMin || $readingTimeMax)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-800/50 border border-zinc-700/50 rounded-lg text-xs font-medium text-zinc-300">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @if ($readingTimeMin && $readingTimeMax)
                                    {{ $readingTimeMin }}-{{ $readingTimeMax }} MIN
                                @elseif($readingTimeMin)
                                    {{ $readingTimeMin }}+ MIN
                                @else
                                    {{ $readingTimeMax }} MIN
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
            @else
                <div class="space-y-6 md:space-y-8">
                    <div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3">
                            Latest Writings
                        </h1>
                        <p class="text-sm md:text-base text-zinc-400 max-w-2xl">
                            Curated articles exploring the intersection of code, aesthetic design, and digital
                            innovation.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 md:gap-4">
                        <div
                            class="bg-zinc-900/50 backdrop-blur-sm border border-zinc-800/50 rounded-lg md:rounded-xl p-4 md:p-6 hover:border-yellow-500/30 transition-all group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="text-xs text-zinc-500 uppercase tracking-wider font-medium">TOTAL
                                    ARTICLES</div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-zinc-400 group-hover:text-yellow-500 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="text-3xl md:text-4xl font-bold text-white">
                                {{ $this->posts->total() }}
                            </div>
                        </div>

                        <div
                            class="bg-zinc-900/50 backdrop-blur-sm border border-zinc-800/50 rounded-lg md:rounded-xl p-4 md:p-6 hover:border-yellow-500/30 transition-all group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="text-xs text-zinc-500 uppercase tracking-wider font-medium">
                                    CATEGORIES</div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-zinc-400 group-hover:text-yellow-500 transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="text-3xl md:text-4xl font-bold text-white">
                                {{ $this->categories->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <flux:separator variant="subtle" />

        @if ($this->posts->isEmpty())
            <div class="text-center py-12 md:py-16 px-4">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-zinc-800/50 rounded-full mb-4 md:mb-6 border border-zinc-700/50">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-zinc-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">No articles found</h3>
                <p class="text-sm md:text-base text-zinc-400 mb-6 max-w-md mx-auto">
                    We couldn't find any articles matching your criteria. Try adjusting your filters.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    @if (
                        $search ||
                            count($selectedCategories) > 0 ||
                            $sortBy !== 'latest' ||
                            $dateFrom ||
                            $dateTo ||
                            $readingTimeMin ||
                            $readingTimeMax)
                        <button wire:click="clearFilters"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-sm">
                            Clear All Filters
                        </button>
                    @endif
                    <a href="{{ route('writing') }}"
                        class="w-full sm:w-auto px-6 py-3 border border-zinc-700 text-zinc-300 hover:text-white hover:border-zinc-600 rounded-lg font-medium transition-colors text-sm">
                        Browse All Articles
                    </a>
                </div>
            </div>
        @else
            <div>
                @foreach ($this->posts as $post)
                    <div wire:key="post-{{ $post->writing_id }}">
                        <x-writing-card :image="$post->image_url" :avatar="$post->author_avatar_url" :author="$post->author_display_name" :category="$post->category"
                            :date="$post->published_at->format('M d, Y')" :read-time="$post->reading_time" :title="$post->title" :excerpt="$post->excerpt" :description="$post->description"
                            :link="route('writing.show', $post->slug ?? '#')" />
                        <flux:separator variant="subtle" />
                    </div>
                @endforeach
            </div>

            <div class="mt-8 md:mt-12 flex justify-center">
                {{ $this->posts->links() }}
            </div>
        @endif
    </div>


    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">

            <div
                class="group rounded-xl bg-gradient-to-br backdrop-blur-md from-white to-zinc-50 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                            Search Writings
                        </h3>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Type to search..."
                            class="block w-full rounded-xl border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2.5 pl-10 pr-10 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />

                        @if ($search)
                            <button wire:click="$set('search', '')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors cursor-pointer">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    <div x-data="{ showFilters: false }" class="space-y-3">
                        <button @click="showFilters = !showFilters"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-all">
                            <div class="flex items-center gap-2">
                                <svg class="size-5 text-zinc-600 dark:text-zinc-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Filters</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($sortBy !== 'latest' || $dateFrom || $dateTo || $readingTimeMin || $readingTimeMax)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                        Active
                                    </span>
                                @endif
                                <svg class="size-4 text-zinc-400 transition-transform"
                                    :class="{ 'rotate-180': showFilters }" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="showFilters" x-collapse class="space-y-4 px-1">
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Sort By
                                </label>
                                <select wire:model.live="sortBy"
                                    class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 pl-3 pr-10 text-sm text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNiA5TDEyIDE1TDE4IDkiIHN0cm9rZT0iIzUyNTI1MiIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48L3N2Zz4=')] dark:bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNiA5TDEyIDE1TDE4IDkiIHN0cm9rZT0iI2FhYWFhYSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48L3N2Zz4=')] bg-no-repeat bg-[length:20px] bg-[right_0.5rem_center]">
                                    <option value="latest">Latest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="title_asc">Title (A-Z)</option>
                                    <option value="title_desc">Title (Z-A)</option>
                                    <option value="popular">Most Popular</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                    Published Date
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="relative">
                                        <input type="date" wire:model.live="dateFrom" placeholder="From date"
                                            onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'"
                                            class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                                    </div>
                                    <div class="relative">
                                        <input type="date" wire:model.live="dateTo" placeholder="To date"
                                            onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'"
                                            class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                    Reading Time (minutes)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" wire:model.live.debounce.300ms="readingTimeMin"
                                            placeholder="Min" min="0"
                                            class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                                    </div>
                                    <div>
                                        <input type="number" wire:model.live.debounce.300ms="readingTimeMax"
                                            placeholder="Max" min="0"
                                            class="block w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 py-2 px-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm" />
                                    </div>
                                </div>
                            </div>

                            @if ($sortBy !== 'latest' || $dateFrom || $dateTo || $readingTimeMin || $readingTimeMax)
                                <button wire:click="clearFilters"
                                    class="w-full py-2 px-3 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:border-blue-400 dark:hover:border-blue-600 transition-all">
                                    Reset Filters
                                </button>
                            @endif
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        Categories
                    </h3>

                    <div
                        class="flex flex-wrap gap-2 max-h-[400px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 scrollbar-track-transparent">
                        @foreach ($this->categories as $category)
                            @php
                                $isActive = in_array($category->category_id, $selectedCategories);
                            @endphp

                            <label class="cursor-pointer group">
                                <input type="checkbox" wire:model.live="selectedCategories"
                                    value="{{ $category->category_id }}" class="hidden" />

                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full border transition-all duration-200 select-none
                                    {{ $isActive ? 'bg-blue-600 border-blue-600 text-white shadow-sm shadow-blue-500/30' : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700/50 text-zinc-600 dark:text-zinc-400 hover:border-blue-400 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400' }}">

                                    {{ $category->name }}

                                    @if (isset($category->writings_count) && $category->writings_count > 0)
                                        <span
                                            class="ml-0.5 text-[10px] {{ $isActive ? 'text-blue-100' : 'text-zinc-400 dark:text-zinc-500' }}">
                                            {{ $category->writings_count }}
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
