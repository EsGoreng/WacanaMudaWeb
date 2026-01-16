<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="max-w-4xl mx-auto">

            <div class="mb-10 space-y-2">
                @if ($search)
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:subheading>Search results for</flux:subheading>
                            <flux:heading size="xl">"{{ $search }}"</flux:heading>
                        </div>
                        <flux:button size="sm" variant="outline" wire:click="$set('search', '')" icon="x-mark">
                            Clear Search
                        </flux:button>
                    </div>
                @elseif ($selectedCategory)
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:subheading>Category</flux:subheading>
                            <flux:heading size="xl">
                                @switch($selectedCategory)
                                    @case(1)
                                        Ruang Kata
                                    @break

                                    @case(2)
                                        Jelajah Rasa
                                    @break

                                    @case(3)
                                        Jejak Karya
                                    @break
                                @endswitch
                            </flux:heading>
                        </div>
                        <flux:button size="sm" variant="outline" wire:click="$set('selectedCategory', '')"
                            icon="x-mark">
                            View All
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
                class="rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5">
                        <flux:icon.magnifying-glass class="size-5 text-zinc-400 dark:text-zinc-500" />
                        <flux:heading size="lg" class="text-zinc-900 dark:text-zinc-100">Search</flux:heading>
                    </div>

                    <flux:input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Search writings..." />
                </div>
            </div>

            <div
                class="rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">

                <div class="flex items-center gap-2.5 mb-4">
                    <flux:icon.tag class="size-5 text-zinc-400 dark:text-zinc-500" />
                    <flux:heading size="lg" class="text-zinc-900 dark:text-zinc-100">Categories</flux:heading>
                </div>

                <flux:radio.group wire:model.live="selectedCategory" class="flex flex-col gap-3">

                    <flux:radio value="" label="All Categories" />

                    <flux:radio value="1" label="Ruang Kata" />
                    <flux:radio value="2" label="Jelajah Rasa" />
                    <flux:radio value="3" label="Jejak Karya" />

                </flux:radio.group>

            </div>

        </div>
    </div>
</div>
