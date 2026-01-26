@props(['forum'])

@php
    $upvotes = $forum->votes->where('type', 'up')->count();
    $downvotes = $forum->votes->where('type', 'down')->count();
    $score = $upvotes - $downvotes;

    $userVote = auth()->check() ? $forum->votes->where('user_id', auth()->id())->first() : null;
    $isBookmarked = auth()->check() && $forum->isBookmarkedBy(auth()->user());
@endphp

<article
    class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer group overflow-hidden">

    <div class="flex flex-col sm:flex-row">

        <div
            class="hidden sm:flex w-12 bg-zinc-50/50 dark:bg-black/20 flex-col items-center py-3 gap-1 border-r border-zinc-100 dark:border-zinc-800/50 shrink-0">
            @include('components.forum.vote-buttons', ['orientation' => 'vertical'])
        </div>

        <div class="flex-1 p-4 md:p-5 min-w-0">

            <div class="flex items-center flex-wrap gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                <div class="flex items-center gap-1.5 font-bold text-zinc-900 dark:text-zinc-200">
                    <span class="px-2 py-0.5 rounded shadow-sm text-[10px] {{ $forum->category->badge_class }}">
                        {{ $forum->category->name }}
                    </span>
                </div>
                <span class="opacity-50">•</span>
                <span class="truncate max-w-[120px] sm:max-w-none">Posted by
                    <a href="{{ route('profile.show', $forum->user) }}"
                        class="hover:underline text-zinc-700 dark:text-zinc-300 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        {{ $forum->user->name }}
                    </a>
                </span>
                <span class="opacity-50">•</span>
                <span class="whitespace-nowrap">{{ $forum->created_at->diffForHumans() }}</span>
            </div>

            <a href="{{ route('forum.show', $forum->slug) }}" class="block group-hover:opacity-90 transition-opacity">
                <h2 class="text-lg sm:text-xl font-bold text-black dark:text-zinc-100 leading-snug mb-2 line-clamp-2">
                    {{ $forum->title }}
                </h2>
                <p class="text-zinc-600 dark:text-zinc-400 text-sm leading-relaxed mb-4 line-clamp-3 break-words">
                    {{ Str::limit(strip_tags($forum->body), 200) }}
                </p>
            </a>

            <div
                class="flex items-center justify-between sm:justify-start gap-2 sm:gap-4 pt-2 border-t sm:border-t-0 border-zinc-100 dark:border-zinc-800/50 sm:pt-0 mt-2 sm:mt-0">

                <div class="flex sm:hidden items-center bg-zinc-100 dark:bg-white/5 rounded-lg px-1">
                    @include('components.forum.vote-buttons', ['orientation' => 'horizontal'])
                </div>

                <div
                    class="flex items-center gap-1 sm:gap-2 text-zinc-500 dark:text-zinc-400 text-sm font-medium ml-auto sm:ml-0">

                    <button
                        class="flex items-center gap-1.5 hover:bg-zinc-100 dark:hover:bg-white/5 px-2 py-1.5 sm:px-2.5 sm:py-2.5 rounded-lg transition-colors">
                        <x-bi-chat-left-text class="w-4 h-4" />
                        <span class="text-xs sm:text-sm">{{ $forum->comments_count }}</span>
                    </button>

                    <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1 shrink-0"></div>

                    <button x-data="{ copied: false }"
                        @click.prevent="navigator.clipboard.writeText('{{ route('forum.show', $forum->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="flex items-center gap-1.5 px-2 py-1.5 sm:px-2.5 sm:py-2.5 rounded-lg transition-colors"
                        :class="copied ? 'bg-green-500/10 text-green-500' :
                            'hover:bg-zinc-100 dark:hover:bg-white/5 text-zinc-500 dark:text-zinc-400'"
                        title="Copy Link">

                        <template x-if="!copied">
                            <x-bi-link class="w-4 h-4" />
                        </template>

                        <template x-if="copied">
                            <x-bi-check2 class="w-4 h-4" />
                        </template>
                    </button>

                    <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1 shrink-0"></div>

                    <button wire:click.prevent="toggleBookmark({{ $forum->id }})"
                        class="flex items-center gap-1.5 px-2 py-1.5 sm:px-2.5 sm:py-2.5 rounded-lg transition-colors {{ $isBookmarked ? 'text-yellow-600 bg-yellow-50 dark:text-yellow-400 dark:bg-yellow-500/10' : 'hover:bg-zinc-100 dark:hover:bg-white/5' }}">
                        @if ($isBookmarked)
                            <x-bi-bookmark-fill class="w-4 h-4" />
                        @else
                            <x-bi-bookmark class="w-4 h-4" />
                        @endif
                    </button>
                </div>
            </div>

        </div>
    </div>
</article>
