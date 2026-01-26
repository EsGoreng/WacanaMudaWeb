<div class="min-h-screen font-sans antialiased transition-colors duration-100 overflow-x-hidden">

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
                            'userVote' => (object) ['type' => $userVoteType], // Adapter agar cocok dengan component
                            'score' => $score,
                            'forum' => $forum,
                        ])
                    </div>

                    <div class="flex-1 p-4 md:p-6 min-w-0">
                        <div class="flex items-center flex-wrap gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $forum->category->badge_class }}">
                                    {{ substr($forum->category->name, 0, 1) }}
                                </span>
                                <span class="font-bold text-zinc-900 dark:text-zinc-200 hover:underline cursor-pointer">
                                    {{ $forum->category->name }}
                                </span>
                            </div>
                            <span class="opacity-50">•</span>
                            <span class="truncate max-w-[150px] sm:max-w-none">Posted by
                                <a href="{{ route('profile.show', $forum->user) }}"
                                    class="hover:underline cursor-pointer text-zinc-600 dark:text-zinc-300 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $forum->user->name }}
                                </a>
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
            <div
                class="rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 shadow-sm transition-colors duration-200">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold {{ $forum->category->badge_class }}">
                            {{ substr($forum->category->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-zinc-900 dark:text-white font-bold text-base">{{ $forum->category->name }}
                            </h2>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Public Community</p>
                        </div>
                    </div>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-normal">
                        {{ $forum->category->description ?? 'A place to discuss everything about ' . $forum->category->name }}
                    </p>
                    <div class="flex gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-3 mb-1">
                        <div class="flex flex-col">
                            <span
                                class="font-bold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Number::abbreviate($forum->category->forums()->count()) }}</span>
                            <span class="text-xs text-zinc-500">Posts</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-zinc-900 dark:text-white flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                Online
                            </span>
                            <span class="text-xs text-zinc-500">Status</span>
                        </div>
                    </div>
                    @auth
                        <button onclick="window.location='{{ route('forums') }}'"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition-colors text-sm">
                            Create Post
                        </button>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 dark:hover:bg-zinc-700 text-zinc-900 dark:text-zinc-300 font-medium py-2 rounded-lg transition-colors text-sm">
                            Login to Post
                        </a>
                    @endguest
                </div>
            </div>

            <div
                class="rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 shadow-sm transition-colors duration-200">
                <h3 class="text-xs font-bold text-zinc-500 uppercase tracking-wider mb-4">Latest Discussions</h3>
                <div class="flex flex-col gap-4">
                    @foreach ($latestForums as $latest)
                        <a class="group" href="{{ route('forums', $latest->slug) }}">
                            <p
                                class="text-sm font-medium text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 leading-snug mb-1 line-clamp-2">
                                {{ $latest->title }}
                            </p>
                            <p class="text-xs text-zinc-500">{{ $latest->comments_count ?? 0 }} comments •
                                {{ $latest->created_at->diffForHumans(null, true, true) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <div
                class="rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-4 shadow-sm transition-colors duration-200">
                <h3 class="text-xs font-bold text-zinc-500 uppercase tracking-wider mb-3">Topic Rules</h3>
                <ul class="list-decimal list-inside text-sm text-zinc-700 dark:text-zinc-300 space-y-2">
                    <li>Be respectful to others.</li>
                    <li>No self-promotion without context.</li>
                    <li>Use code blocks for code.</li>
                </ul>
            </div>
        </aside>
    </div>
</div>
