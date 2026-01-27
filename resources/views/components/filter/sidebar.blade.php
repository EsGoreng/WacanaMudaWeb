@props(['title' => 'Search', 'categories', 'selectedCategories', 'countKey' => 'events_count'])

<div class="sticky top-8 space-y-6">
    <div
        class="group rounded-xl bg-gradient-to-br backdrop-blur-sm from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300">
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $title }}</h3>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Type to search..."
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="space-y-4 pt-2">
                    {{ $slot }}
                </div>
            </div>

            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Categories</h3>
            <div
                class="flex flex-wrap gap-2 max-h-[400px] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 scrollbar-track-transparent">
                @foreach ($categories as $category)
                    @php $isActive = in_array($category->category_id, $selectedCategories); @endphp
                    <label class="cursor-pointer group">
                        <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->category_id }}"
                            class="hidden" />
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full border transition-all duration-200 select-none {{ $isActive ? 'bg-blue-600 border-blue-600 text-white shadow-sm shadow-blue-500/30' : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700/50 text-zinc-600 dark:text-zinc-400 hover:border-blue-400 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400' }}">
                            {{ $category->name }}
                            @if (isset($category->$countKey) && $category->$countKey > 0)
                                <span
                                    class="ml-0.5 text-[10px] {{ $isActive ? 'text-blue-100' : 'text-zinc-400 dark:text-zinc-500' }}">
                                    {{ $category->$countKey }}
                                </span>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>
