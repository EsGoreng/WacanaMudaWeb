<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div class="space-y-4">
            @livewire('forum-create')
            @forelse ($forums as $forum)
                @php
                    $upvotes = $forum->votes->where('type', 'up')->count();
                    $downvotes = $forum->votes->where('type', 'down')->count();
                    $score = $upvotes - $downvotes;

                    $userVote = auth()->check() ? $forum->votes->where('user_id', auth()->id())->first() : null;
                @endphp

                <article
                    class="bg-white dark:bg-zinc-900/40 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer group overflow-hidden">
                    <div class="flex">
                        <div
                            class="w-12 bg-zinc-50/50 dark:bg-black/20 flex flex-col items-center py-3 gap-1 border-r border-zinc-100 dark:border-zinc-800/50">
                            <button wire:click.prevent="vote({{ $forum->id }}, 'up')"
                                class="p-1 rounded transition-colors {{ $userVote?->type === 'up' ? 'text-green-500 bg-green-500/10' : 'text-zinc-400 hover:text-green-500 hover:bg-green-500/10' }}">
                                <x-bi-chevron-up class="w-5 h-5" />
                            </button>

                            <span
                                class="text-xs font-bold {{ $score > 0 ? 'text-green-500' : ($score < 0 ? 'text-red-500' : 'text-zinc-700 dark:text-zinc-300') }}">
                                {{ \Illuminate\Support\Number::abbreviate($score) }}
                            </span>

                            <button wire:click.prevent="vote({{ $forum->id }}, 'down')"
                                class="p-1 rounded transition-colors {{ $userVote?->type === 'down' ? 'text-red-500 bg-red-500/10' : 'text-zinc-400 hover:text-red-500 hover:bg-red-500/10' }}">
                                <x-bi-chevron-down class="w-5 h-5" />
                            </button>
                        </div>

                        <div class="flex-1 p-4 md:p-5">
                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                                <div class="flex items-center gap-1.5 font-bold text-zinc-900 dark:text-zinc-200">
                                    <span
                                        class="px-2 py-0.5 rounded shadow-sm text-[10px] {{ $forum->category->badge_class }}">
                                        {{ $forum->category->name }}
                                    </span>
                                </div>
                                <span class="opacity-50">•</span>
                                <span>Posted by <span
                                        class="hover:underline text-zinc-700 dark:text-zinc-300">{{ $forum->user->name }}</span></span>
                                <span class="opacity-50">•</span>
                                <span>{{ $forum->created_at->diffForHumans() }}</span>
                            </div>

                            <a href="{{ route('forums.show', $forum->slug) }}" class="block">
                                <h2
                                    class="text-xl font-extrabold text-zinc-900 dark:text-white mb-2 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $forum->title }}
                                </h2>
                                <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($forum->body), 200) }}
                                </p>
                            </a>

                            <div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                                <button
                                    class="flex items-center gap-1.5 hover:bg-zinc-100 dark:hover:bg-white/5 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <x-bi-chat-left-text />
                                    {{ $forum->replies_count }} <span class="hidden sm:inline">Comments</span>
                                </button>
                                <button
                                    class="flex items-center gap-1.5 hover:bg-zinc-100 dark:hover:bg-white/5 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <x-bi-share />
                                    <span class="hidden sm:inline">Share</span>
                                </button>
                                <button
                                    class="flex items-center gap-1.5 hover:bg-zinc-100 dark:hover:bg-white/5 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <x-bi-bookmark />
                                    <span class="hidden sm:inline">Save</span>
                                </button>
                                <button
                                    class="ml-auto hover:bg-zinc-100 dark:hover:bg-white/5 p-1.5 rounded-lg transition-colors">
                                    <x-bi-three-dots />
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
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
            class="group rounded-xl bg-gradient-to-br h-[200px] mt-6 backdrop-blur-md from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300 flex items-center justify-center text-zinc-400">
            Space Iklan / Banner
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="sticky top-8 space-y-6">

            <div class="group rounded-xl bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 p-6">
                <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Trending Topik</h3>
                <div class="space-y-4">
                    {{-- Placeholder Trending --}}
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
                class="group rounded-xl bg-gradient-to-br h-[300px] backdrop-blur-md from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 p-6 transition-all duration-300 text-center flex items-center justify-center text-zinc-400">
                Footer / Copyright
            </div>
        </div>
    </div>
</div>
