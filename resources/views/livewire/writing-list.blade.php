<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="max-w-4xl mx-auto">

            <div class="mb-10 space-y-2">
                @if ($search || count($selectedCategories) > 0)
                    <div class="flex items-center justify-between">
                        <div>
                            @if ($search)
                                <flux:subheading>Search results for</flux:subheading>
                                <flux:heading size="xl">"{{ $search }}"</flux:heading>
                            @elseif (count($selectedCategories) > 0)
                                <flux:subheading>Filtered by</flux:subheading>
                                <flux:heading size="xl">
                                    {{ count($selectedCategories) }}
                                    {{ Str::plural('category', count($selectedCategories)) }}
                                </flux:heading>
                            @endif
                        </div>
                        <flux:button size="sm" variant="outline" wire:click="clearFilters" icon="x-mark">
                            Clear All
                        </flux:button>
                    </div>
                @else
                    <flux:heading size="xl">Latest Writings</flux:heading>
                    <flux:subheading>Exploring ideas, code, and creativity.</flux:subheading>
                @endif
            </div>

            <flux:separator variant="subtle" />

            @if ($this->posts->isEmpty())
                <div class="text-center py-10 text-zinc-500">
                    <p>No articles found matching your criteria.</p>
                </div>
            @else
                <div>
                    @foreach ($this->posts as $post)
                        <div wire:key="post-{{ $post->id }}">
                            <x-writing-card :image="$post->image_url" :avatar="$post->author_avatar_url" :author="$post->author_display_name" :category="$post->category"
                                :date="$post->published_at->format('M d, Y')" :read-time="$post->reading_time" :title="$post->title" :excerpt="$post->excerpt"
                                :description="$post->description" :link="route('writing.show', $post->slug ?? '#')" />
                            <flux:separator variant="subtle" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-center">
                    {{ $this->posts->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">

            <div
                class="group rounded-2xl bg-gradient-to-br from-white to-zinc-50 dark:from-zinc-900 dark:to-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50 p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                            Search Articles
                        </h3>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="size-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                    {{ $isActive
                                        ? 'bg-blue-600 border-blue-600 text-white shadow-sm shadow-blue-500/30'
                                        : 'bg-white dark:bg-zinc-800/50 border-zinc-200 dark:border-zinc-700/50 text-zinc-600 dark:text-zinc-400 hover:border-blue-400 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400' }}">

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
