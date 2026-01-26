<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="space-y-4">
            @auth
                <livewire:forums.create />
            @endauth
            @forelse ($forums as $forum)
                <x-forum.card :forum="$forum" />
            @empty
                <div class="text-center py-12 md:py-16 px-4">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-zinc-50 dark:bg-zinc-800/50 rounded-full mb-4 md:mb-6 border border-zinc-200/50 dark:border-zinc-700/50">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-zinc-950 dark:text-zinc-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="text-xl md:text-2xl font-bold dark:text-white text-black mb-2">No forums found</h3>
                    <p class="text-sm md:text-base dark:text-zinc-400 text-zinc-7   00 mb-6 max-w-md mx-auto">
                        We couldn't find any forum.
                    </p>

                </div>
            @endforelse

            <div class="mt-6">
                {{ $forums->links() }}
            </div>

        </div>

        <div
            class="group rounded-xl bg-gradient-to-br h-[200px] mt-6 backdrop-blur-sm from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300 flex items-center justify-center text-zinc-400">
            Space Iklan / Banner
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">
            <div
                class="group rounded-xl bg-gradient-to-br backdrop-blur-sm from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                        Search Forums
                    </h3>

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
                                    <option value="latest">Latest</option>
                                    <option value="oldest">oldest</option>
                                    <option value="popular">Popular</option>
                                    <option value="most_replied">Most Comment</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                    Published Date
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
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="$set('selectedCategory', null)"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-full border transition-all
                            {{ is_null($selectedCategory) ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700 text-zinc-600 hover:border-blue-400' }}">
                            All
                        </button>

                        @foreach ($this->categories as $cat)
                            <button wire:click="$set('selectedCategory', {{ $cat->category_id }})"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full border transition-all
                                {{ $selectedCategory == $cat->category_id ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700/50 text-zinc-600 dark:text-zinc-400 hover:border-blue-400 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400' }}">
                                {{ $cat->name }}
                                <span class="text-[10px] opacity-70">({{ $cat->forums_count }})</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
