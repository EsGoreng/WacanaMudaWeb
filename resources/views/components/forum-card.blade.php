@props(['forum'])

@php
    $upvotes = $forum->votes->where('type', 'up')->count();
    $downvotes = $forum->votes->where('type', 'down')->count();
    $score = $upvotes - $downvotes;

    $userVote = auth()->check() ? $forum->votes->where('user_id', auth()->id())->first() : null;
@endphp

<article
    class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer group overflow-hidden">
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
                    <span class="px-2 py-0.5 rounded shadow-sm text-[10px] {{ $forum->category->badge_class }}">
                        {{ $forum->category->name }}
                    </span>
                </div>
                <span class="opacity-50">•</span>
                <span>Posted by
                    <a href="{{ route('profile.show', $forum->user) }}"
                        class="hover:underline text-zinc-700 dark:text-zinc-300 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        {{ $forum->user->name }}
                    </a>
                </span></span>
                <span class="opacity-50">•</span>
                <span>{{ $forum->created_at->diffForHumans() }}</span>
            </div>

            <a href="{{ route('forum.show', $forum->slug) }}" class="block">
                <h2
                    class="text-xl font-bold text-black dark:text-zinc-100 leading-tight group-hover:text-gray-500 line-clamp-2 mb-2 transition-colors">
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
                <button class="ml-auto hover:bg-zinc-100 dark:hover:bg-white/5 p-1.5 rounded-lg transition-colors">
                    <x-bi-three-dots />
                </button>
            </div>
        </div>
    </div>
</article>
