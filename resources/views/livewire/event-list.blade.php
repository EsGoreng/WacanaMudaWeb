<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        @forelse ($events as $event)
            <x-event-card :event="$event" />
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

                <h3 class="text-xl md:text-2xl font-bold dark:text-white text-black mb-2">No events found</h3>
                <p class="text-sm md:text-base dark:text-zinc-400 text-zinc-7   00 mb-6 max-w-md mx-auto">
                    We couldn't find any event.
                </p>

            </div>
        @endforelse
    </div>
    <div class="lg:col-span-1">
        <div class="w-full h-full border boder-zinc-200">
            Test
        </div>
    </div>
</div>
