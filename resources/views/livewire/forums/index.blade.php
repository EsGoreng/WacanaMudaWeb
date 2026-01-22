<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="space-y-4">
            @livewire('forum-create')
            @forelse ($forums as $forum)
                <x-forum-card :forum="$forum" />
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

            <div class="group rounded-xl bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 p-6">
                <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Trending Topik</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-black text-zinc-200 dark:text-zinc-700">01</span>
                        <div>
                            <p class="text-xs font-bold text-zinc-500">Technology</p>
                            <p class="font-bold text-sm text-zinc-800 dark:text-zinc-200 line-clamp-1">Laravel 11
                                Released</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-2xl font-black text-zinc-200 dark:text-zinc-700">02</span>
                        <div>
                            <p class="text-xs font-bold text-zinc-500">Startups</p>
                            <p class="font-bold text-sm text-zinc-800 dark:text-zinc-200 line-clamp-1">SaaS
                                Bootstrapping</p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="group rounded-xl bg-gradient-to-br h-[300px] backdrop-blur-sm from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300 text-center flex items-center justify-center text-zinc-400">
                Footer / Copyright
            </div>
        </div>
    </div>
</div>
