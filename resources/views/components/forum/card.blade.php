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
    <div class="flex">
        <div
            class="w-12 bg-zinc-50/50 dark:bg-black/20 flex flex-col items-center py-3 gap-1 border-r border-zinc-100 dark:border-zinc-800/50">

            <button wire:click.prevent="vote({{ $forum->id }}, 'up')"
                class="p-1 rounded transition-colors relative {{ $userVote?->type === 'up' ? 'text-green-500 bg-green-500/10' : 'text-zinc-400 hover:text-green-500 hover:bg-green-500/10' }}">
                <x-bi-chevron-up class="w-5 h-5" wire:loading.remove wire:target="vote({{ $forum->id }}, 'up')" />
                <svg wire:loading wire:target="vote({{ $forum->id }}, 'up')" class="animate-spin w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </button>

            <span
                class="text-xs font-bold {{ $score > 0 ? 'text-green-500' : ($score < 0 ? 'text-red-500' : 'text-zinc-700 dark:text-zinc-300') }}">
                {{ \Illuminate\Support\Number::abbreviate($score) }}
            </span>

            <button wire:click.prevent="vote({{ $forum->id }}, 'down')"
                class="p-1 rounded transition-colors relative {{ $userVote?->type === 'down' ? 'text-red-500 bg-red-500/10' : 'text-zinc-400 hover:text-red-500 hover:bg-red-500/10' }}">
                <x-bi-chevron-down class="w-5 h-5" wire:loading.remove
                    wire:target="vote({{ $forum->id }}, 'down')" />
                <svg wire:loading wire:target="vote({{ $forum->id }}, 'down')" class="animate-spin w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
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
                    class="flex items-center gap-1.5 hover:bg-zinc-100 dark:hover:bg-white/5 px-2.5 py-2.5 rounded-lg transition-colors">
                    <x-bi-chat-left-text />
                    {{ $forum->replies_count }}
                </button>
                <div x-data="{
                    copied: false,
                    shareData: {
                        title: '{{ addslashes($forum->title) }}',
                        author: '{{ addslashes($forum->user->name) }}',
                        url: '{{ route('forum.show', $forum->slug) }}'
                    },
                    async share() {
                        const fullText = `Wacana Muda Forum\n${this.shareData.title}\nBy ${this.shareData.author}\nLink: ${this.shareData.url}`;
                
                        if (navigator.share) {
                            try {
                                await navigator.share({
                                    title: this.shareData.title,
                                    text: fullText,
                                    url: this.shareData.url
                                });
                            } catch (err) {
                                console.log('Share cancelled');
                            }
                        } else {
                            try {
                                await navigator.clipboard.writeText(fullText);
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2000);
                            } catch (err) {
                                console.error('Gagal menyalin', err);
                            }
                        }
                    }
                }" class="relative">
                    <button @click.prevent="share()"
                        class="flex items-center gap-1.5  px-2.5 py-2.5  rounded-lg transition-colors"
                        :class="copied ? 'bg-green-500/10 text-green-500' :
                            'hover:bg-zinc-100 dark:hover:bg-white/5 text-zinc-500 dark:text-zinc-400'">

                        <template x-if="!copied">
                            <x-bi-share />
                        </template>
                        <template x-if="copied">
                            <x-bi-check2 />
                        </template>
                    </button>
                </div>

                <button wire:click.prevent="toggleBookmark({{ $forum->id }})" wire:loading.attr="disabled"
                    class="flex items-center gap-1.5  px-2.5 py-2.5 rounded-lg transition-colors
    {{ $isBookmarked
        ? 'text-yellow-600 bg-yellow-50 dark:text-yellow-400 dark:bg-yellow-500/10'
        : 'hover:bg-zinc-100 dark:hover:bg-white/5' }}">

                    <span wire:loading.remove wire:target="toggleBookmark({{ $forum->id }})"
                        class="flex items-center gap-1.5">
                        @if ($isBookmarked)
                            <x-bi-bookmark-fill />
                        @else
                            <x-bi-bookmark />
                        @endif
                    </span>

                    <span wire:loading wire:target="toggleBookmark({{ $forum->id }})"
                        class="flex items-center gap-1.5">
                        <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>

                </button>

            </div>
        </div>
    </div>
</article>
