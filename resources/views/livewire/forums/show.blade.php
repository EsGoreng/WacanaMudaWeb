<div class="min-h-screen font-sans antialiased transition-colors duration-100 ">

    <div class="relative w-full h-[50px] group">
        <flux:button icon="arrow-left" :href="route('forums')"
            class="!bg-black/20 hover:!bg-black/40 !border-white/10 !backdrop-blur-sm !text-white border transition-all">
            Back
        </flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-8 min-w-0">
            <article
                class="flex flex-col rounded-xl bg-white dark:bg-zinc-900/40 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm transition-colors duration-200">
                <div class="flex flex-col sm:flex-row">

                    <div
                        class="hidden sm:flex w-12 flex-col items-center bg-zinc-50 dark:bg-zinc-900/50 py-4 gap-1 border-r border-zinc-100 dark:border-zinc-800/50 shrink-0">
                        @include('components.forum.vote-buttons', [
                            'orientation' => 'vertical',
                            'userVote' => (object) ['type' => $userVoteType],
                            'score' => $score,
                            'forum' => $forum,
                        ])
                    </div>

                    <div class="flex-1 p-4 md:p-6 min-w-0">
                        <div class="flex items-center flex-wrap gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                            <div class="flex items-center gap-2">
                                @foreach ($forum->categories as $category)
                                    <a href="{{ route('forums', ['selectedCategory' => $category->category_id]) }}"
                                        class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                        <span
                                            class="px-2 py-0.5 rounded text-[10px] font-bold {{ $category->badge_class }}">
                                            {{ substr($category->name, 0, 1) }}
                                        </span>
                                        <span
                                            class="font-bold text-zinc-900 dark:text-zinc-200 hover:underline cursor-pointer">
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <span class="opacity-50">•</span>
                            <span class="truncate max-w-[150px] sm:max-w-none">Posted by
                                @if ($forum->is_anonymous)
                                    <span class="cursor-default text-zinc-600 dark:text-zinc-300 font-medium italic">
                                        Anonymous
                                    </span>
                                @else
                                    <a href="{{ route('profile.show', $forum->user) }}"
                                        class="hover:underline cursor-pointer text-zinc-600 dark:text-zinc-300 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        {{ $forum->user->name }}
                                    </a>
                                @endif
                            </span>
                            <span class="opacity-50">•</span>
                            <span class="whitespace-nowrap">{{ $forum->created_at->diffForHumans() }}</span>
                        </div>

                        <h1
                            class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white mb-4 leading-tight break-words">
                            {{ $forum->title }}
                        </h1>

                        <div class="prose dark:prose-invert max-w-none w-full break-words">
                            {!! $forum->body !!}
                        </div>

                        <div
                            class="flex sm:hidden items-center mt-6 border-t border-zinc-100 dark:border-zinc-700 pt-4">
                            <div class="flex items-center bg-zinc-100 dark:bg-white/5 rounded-lg px-1">
                                @include('components.forum.vote-buttons', [
                                    'orientation' => 'horizontal',
                                    'userVote' => (object) ['type' => $userVoteType],
                                    'score' => $score,
                                    'forum' => $forum,
                                ])
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-1 md:gap-4 mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400 text-sm font-medium overflow-x-auto">

                            <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-zinc-500 dark:text-zinc-400 font-medium text-sm group shrink-0 cursor-default"
                                title="Total Views">
                                <x-bi-eye
                                    class="w-5 h-5 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors" />
                                <span
                                    class="hidden sm:inline group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">{{ $forum->view_count }}
                                    Views</span>
                                <span class="sm:hidden">{{ $forum->view_count }}</span>
                            </div>

                            <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1 shrink-0"></div>

                            <button wire:click="generateInstagramStory" wire:loading.attr="disabled"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-500 dark:text-zinc-400 font-medium text-sm group shrink-0">
                                <svg wire:loading wire:target="generateInstagramStory"
                                    class="animate-spin w-4 h-4 text-zinc-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <svg wire:loading.remove wire:target="generateInstagramStory"
                                    xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                    </rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                                <span wire:loading.remove wire:target="generateInstagramStory"
                                    class="hidden sm:inline group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Story</span>
                            </button>

                            <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1 shrink-0"></div>

                            <button x-data="{ copied: false }"
                                @click.prevent="navigator.clipboard.writeText('{{ route('forums', $forum->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-500 dark:text-zinc-400 font-medium text-sm group shrink-0"
                                :class="copied ? 'bg-green-50 dark:bg-green-500/10' : ''">
                                <template x-if="!copied">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                    </svg>
                                </template>
                                <template x-if="copied">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </template>
                                <span x-text="copied ? 'Copied!' : 'Copy Link'" class="hidden sm:inline"
                                    :class="copied ? 'text-green-500' :
                                        'group-hover:text-zinc-900 dark:group-hover:text-white transition-colors'">
                                </span>
                            </button>

                            <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1 shrink-0"></div>

                            <button wire:click="toggleBookmark({{ $forum->id }})" wire:loading.attr="disabled"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors font-medium text-sm group shrink-0
                                {{ $isBookmarked
                                    ? 'text-yellow-600 bg-yellow-50 dark:text-yellow-400 dark:bg-yellow-500/10'
                                    : 'hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 dark:text-zinc-400' }}">
                                <span wire:loading.remove wire:target="toggleBookmark({{ $forum->id }})"
                                    class="flex items-center gap-2">
                                    @if ($isBookmarked)
                                        <x-bi-bookmark-fill class="w-4 h-4" />
                                        <span class="hidden sm:inline">Saved</span>
                                    @else
                                        <x-bi-bookmark
                                            class="w-4 h-4 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors" />
                                        <span
                                            class="hidden sm:inline group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Save</span>
                                    @endif
                                </span>
                                <svg wire:loading wire:target="toggleBookmark({{ $forum->id }})"
                                    class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>
            </article>

            <div
                class="mt-4 bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 backdrop-blur-xs text-zinc-700 dark:text-slate-300 p-4 md:p-6 rounded-xl">
                <x-comments.area :comments="$replies" :parentCommentId="$parentReplyId" />
            </div>

        </div>
        <aside class="lg:col-span-4 space-y-8 lg:pt-0 sticky top-6 self-start">
            <div>
                <h3
                    class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-white mb-5 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                    Latest Discussions
                </h3>
                <div class="space-y-4">
                    @forelse($latestForums as $latest)
                        <div class="flex gap-4 group cursor-pointer backdrop-blur-xs bg-blue-50/80 dark:bg-zinc-900/20 p-4 rounded-xl border border-blue-100 dark:border-zinc-800 transition-all hover:bg-blue-100/80 dark:hover:bg-zinc-900/40"
                            onclick="window.location='{{ route('forum.show', $latest) }}'">


                            <div class="flex flex-col justify-center min-w-0 flex-1">
                                <h4
                                    class="font-bold text-base text-zinc-900 dark:text-white mb-1 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                    <a href="{{ route('forum.show', $latest) }}">
                                        {{ $latest->title }}
                                    </a>
                                </h4>

                                <div class="flex items-center gap-3 text-xs text-blue-700 dark:text-blue-300 mt-1">
                                    <span class="flex items-center gap-1 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" class="w-4 h-4 opacity-70">
                                            <path fill-rule="evenodd"
                                                d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902.848.137 1.705.248 2.57.331v3.443a.75.75 0 001.28.53l3.58-3.579a42.31 42.31 0 011.14-.092c2.236 0 4.43-.18 6.57-.524 1.437-.232 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A42.35 42.35 0 0010 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $latest->comments_count }} Comments
                                    </span>
                                    <span class="text-blue-400 dark:text-blue-600">•</span>
                                    <span
                                        class="opacity-75">{{ $latest->created_at->diffForHumans(null, true, true) }}</span>
                                </div>

                                <a href="{{ route('forum.show', $latest) }}"
                                    class="text-sm font-medium text-blue-600 dark:text-blue-500 mt-2 hover:underline justify-self-end">
                                    View discussion
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-center">
                            <p class="text-zinc-500 dark:text-zinc-400 text-sm italic">No other discussions yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </aside>
    </div>
</div>
