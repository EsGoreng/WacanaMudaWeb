@props(['event', 'isBookmarked' => false])

<div class="flex flex-col md:flex-row h-full md:h-[600px]">
    <div class="relative w-full md:w-1/2 h-64 md:h-full">
        <img src="{{ str_starts_with($event->banner_image, 'http') ? $event->banner_image : asset('storage/' . $event->banner_image) }}"
            alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
    </div>

    <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col h-full bg-zinc-800 relative overflow-y-auto">

        <div class="absolute top-4 right-4 flex items-center gap-2 z-10">

            <button wire:click="toggleBookmark" wire:loading.attr="disabled"
                class="w-10 h-10 rounded-full flex items-center justify-center transition-colors shadow-lg border border-white/10
                {{ $isBookmarked
                    ? 'bg-yellow-500/90 text-white hover:bg-yellow-600'
                    : 'bg-white/10 text-gray-400 hover:bg-white/20 hover:text-gray-200' }}">

                <div wire:loading.remove wire:target="toggleBookmark" class="flex items-center justify-center">
                    @if ($isBookmarked)
                        <x-bi-bookmark-fill />
                    @else
                        <x-bi-bookmark />
                    @endif
                </div>

                <div wire:loading wire:target="toggleBookmark" class="flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </button>

            <button x-on:click="show = false"
                class="p-2 rounded-full hover:bg-gray-100/10 text-gray-400 hover:text-gray-200 transition-colors">
                <x-bi-x-circle-fill class="w-8 h-8" />
            </button>
        </div>

        <div class="flex flex-wrap gap-2 mb-2">
            @forelse($event->categories as $category)
                <div
                    class="{{ $category->badgeClass }} px-3 py-1.5 rounded-full border border-black/10 text-xs font-medium text-black transition-colors hover:bg-white/20 cursor-default shadow-sm">
                    {{ $category->name }}
                </div>
            @empty
                <div
                    class="bg-black/10 backdrop-blur-sm px-3 py-1.5 rounded-full border border-black/10 text-xs font-medium text-white shadow-sm">
                    Event
                </div>
            @endforelse
        </div>

        <h2 class="text-3xl font-extrabold text-zinc-950 dark:text-zinc-50 mb-2 leading-tight">
            {{ $event->title }}
        </h2>

        <div class="flex items-center text-zinc-950 dark:text-zinc-300 mb-4 text-sm">
            <x-bi-geo class="mr-2 h-5 w-5"></x-bi-geo>
            {{ $event->location_name }}, {{ $event->location_address }}
        </div>

        <hr class="border-zinc-100 dark:border-zinc-700 mb-4">

        <div class="mb-4">
            <h3 class="font-bold text-zinc-900 dark:text-zinc-50 mb-2">About this event</h3>
            <div class="text-zinc-900 dark:text-zinc-300 text-sm leading-relaxed fi-prose">
                {!! $event->description !!}
            </div>
        </div>

        <div class="mt-auto pt-6 border-t border-zinc-100 dark:border-zinc-700 flex items-center justify-between">
            <flux:button variant="primary"
                class="bg-brand-hover hover:bg-accent text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm w-full">
                Register
            </flux:button>
        </div>
    </div>
</div>
