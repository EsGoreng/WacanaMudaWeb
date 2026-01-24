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
                <div class="flex">
                    <div
                        class="hidden sm:flex w-12 flex-col items-center bg-zinc-50 dark:bg-zinc-900/50 py-4 gap-1 border-r border-zinc-100 dark:border-zinc-800/50">
                        <button wire:click="vote('up')"
                            class="p-1 rounded transition-colors relative {{ $userVoteType === 'up' ? 'text-green-500 bg-green-500/10' : 'text-zinc-400 hover:text-green-500 hover:bg-green-500/10' }}">
                            <x-bi-arrow-up class="w-6 h-6 font-bold" wire:loading.remove wire:target="vote('up')" />
                            <svg wire:loading wire:target="vote('up')" class="animate-spin w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>

                        <span
                            class="text-sm font-bold {{ $score > 0 ? 'text-green-500' : ($score < 0 ? 'text-red-500' : 'text-zinc-900 dark:text-white') }}">
                            {{ \Illuminate\Support\Number::abbreviate($score) }}
                        </span>

                        <button wire:click="vote('down')"
                            class="p-1 rounded transition-colors relative {{ $userVoteType === 'down' ? 'text-red-500 bg-blue-500/10' : 'text-zinc-400 hover:text-red-500 hover:bg-blue-500/10' }}">
                            <x-bi-arrow-down class="w-6 h-6 font-bold" wire:loading.remove wire:target="vote('down')" />
                            <svg wire:loading wire:target="vote('down')" class="animate-spin w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 p-4 md:p-6">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $forum->category->badge_class }}">
                                    {{ substr($forum->category->name, 0, 1) }}
                                </span>
                                <span class="font-bold text-zinc-900 dark:text-zinc-200 hover:underline cursor-pointer">
                                    {{ $forum->category->name }}
                                </span>
                            </div>
                            <span>•</span>
                            <span>Posted by
                                <a href="{{ route('profile.show', $forum->user) }}"
                                    class="hover:underline cursor-pointer text-zinc-600 dark:text-zinc-300 font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $forum->user->name }}
                                </a>
                            </span></span>
                            <span>•</span>
                            <span>{{ $forum->created_at->diffForHumans() }}</span>
                        </div>

                        <h1 class="text-2xl md:text-3xl font-bold text-zinc-900 dark:text-white mb-4 leading-tight">
                            {{ $forum->title }}
                        </h1>

                        <div class="flex gap-2 flex-wrap mb-6">
                            <div
                                class="flex h-6 items-center justify-center gap-x-1 rounded-full bg-zinc-100 dark:bg-zinc-800 px-3 border border-zinc-200 dark:border-zinc-700">
                                <span
                                    class="text-zinc-600 dark:text-zinc-300 text-xs font-medium">{{ $forum->category->name }}</span>
                            </div>
                        </div>

                        <div
                            class="fi-prose dark:prose-invert text-base leading-relaxed space-y-4 dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300">
                            {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($forum->body) }}
                        </div>

                        <div
                            class="flex sm:hidden items-center gap-4 mt-6 border-t border-zinc-100 dark:border-zinc-700 pt-4">
                            <div class="flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-full px-2">
                                <button wire:click="vote('up')"
                                    class="p-2 {{ $userVoteType === 'up' ? 'text-green-500' : 'text-zinc-500' }}">
                                    <x-bi-arrow-up class="w-5 h-5" />
                                </button>
                                <span
                                    class="text-sm font-bold px-1 {{ $score > 0 ? 'text-green-500' : ($score < 0 ? 'text-blue-500' : 'text-zinc-700 dark:text-zinc-300') }}">
                                    {{ \Illuminate\Support\Number::abbreviate($score) }}
                                </span>
                                <button wire:click="vote('down')"
                                    class="p-2 {{ $userVoteType === 'down' ? 'text-blue-500' : 'text-zinc-500' }}">
                                    <x-bi-arrow-down class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-1 md:gap-6 mt-6 pt-4 border-t border-zinc-100 dark:border-zinc-800 text-zinc-500 dark:text-zinc-400 text-sm font-medium">
                            <div class="flex items-center gap-1">
                                <button wire:click="generateInstagramStory" wire:loading.attr="disabled"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-500 dark:text-zinc-400 font-medium text-sm group">

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
                                        xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                        </rect>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                    </svg>

                                    <span wire:loading.remove wire:target="generateInstagramStory"
                                        class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Story</span>
                                    <span wire:loading wire:target="generateInstagramStory">Generating...</span>
                                </button>

                                <div class="h-4 w-[1px] bg-zinc-200 dark:bg-zinc-700 mx-1"></div>

                                <div x-data="{
                                    copied: false,
                                    shareTitle: '{{ $forum->title }}',
                                    shareAuthor: '{{ $forum->user->name }}',
                                    shareUrl: '{{ route('forums', $forum->slug) }}',
                                
                                    async share() {
                                        const fullText = `Wacana Muda Forum\n${this.shareTitle}\nBy ${this.shareAuthor}\nLink: ${this.shareUrl}`;
                                
                                        if (navigator.share) {
                                            try {
                                                await navigator.share({
                                                    title: this.shareTitle,
                                                    text: fullText,
                                                    url: this.shareUrl
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
                                                console.error('Gagal menyalin ke clipboard', err);
                                            }
                                        }
                                    }
                                }">
                                    <button @click="share()"
                                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-500 dark:text-zinc-400 font-medium text-sm group">

                                        <svg x-show="copied" x-cloak xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-green-500">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>

                                        <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" width="18"
                                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71">
                                            </path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71">
                                            </path>
                                        </svg>

                                        <span x-text="copied ? 'Copied!' : 'Link'"
                                            :class="copied ? 'text-green-500' :
                                                'group-hover:text-zinc-900 dark:group-hover:text-white transition-colors'">
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <div
                class="mt-4 bg-white dark:bg-zinc-900/40 border border-zinc-200 dark:border-zinc-800 backdrop-blur-xs text-slate-300 p-4 md:p-6 rounded-xl">

                <h3
                    class="text-lg font-medium text-zinc-900 dark:text-slate-100 mb-6 border-b border-zinc-200 dark:border-slate-800 pb-2">
                    Comments <span class="text-slate-500 text-sm ml-1">({{ $replies->total() }})</span>
                </h3>

                @auth
                    <div class="mb-4 flex gap-3">
                        <div class="shrink-0">
                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                class="w-8 h-8 rounded-full border border-zinc-200 dark:border-zinc-700">
                        </div>
                        <div class="w-full max-w-full">
                            <form wire:submit="createComment">
                                {{ $this->commentForm }}

                                <div class="flex justify-end mt-4">
                                    <button type="submit" wire:loading.attr="disabled"
                                        class="bg-brand-hover hover:bg-accent text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                        <span wire:loading.remove wire:target="createComment">Post Comment</span>
                                        <span wire:loading wire:target="createComment">Posting...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endauth

                <div class="space-y-6">
                    @forelse($replies as $reply)

                        <div class="flex flex-col" wire:key="reply-{{ $reply->id }}">

                            <div class="flex gap-3 relative group">
                                <div class="flex flex-col items-center shrink-0 w-8">
                                    <img src="{{ $reply->user->avatar ? Storage::url($reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}"
                                        class="w-8 h-8 rounded-full object-cover ring-2 ring-white dark:ring-[#0B1416] z-10 relative bg-zinc-100 dark:bg-zinc-800">
                                    @if ($reply->children->count() > 0 || $parentReplyId === $reply->id)
                                        <div
                                            class="w-0.5 h-full bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px]">
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0 pb-2">
                                    <div class="flex items-center gap-2 text-xs mb-1">
                                        <a href="{{ route('profile.show', $reply->user) }}"
                                            class="font-bold text-zinc-900 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                            {{ $reply->user->name }}
                                        </a>
                                        <span class="text-zinc-500 dark:text-slate-500">•
                                            {{ $reply->created_at->diffForHumans(null, true) }}</span>
                                    </div>

                                    <div
                                        class="fi-prose prose-sm dark:prose-invert dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300">
                                        {!! str($reply->body)->sanitizeHtml() !!}
                                    </div>

                                    <div class="flex items-center gap-2 mt-1">

                                        <button wire:click="setReplyTo({{ $reply->id }})"
                                            class="flex items-center gap-1 text-xs font-bold text-slate-500 hover:bg-slate-800 px-2 py-2 rounded">
                                            <x-bi-chat-left class="w-4 h-4" /> Reply
                                        </button>

                                        @if (auth()->id() === $reply->user_id || auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('superadmin'))
                                            <button wire:click="deleteReply({{ $reply->id }})"
                                                wire:confirm="Are you sure you want to delete this comment?"
                                                class="flex items-center gap-1 text-xs text-red-500 hover:text-red-400 hover:bg-slate-800 px-2 py-2 rounded">
                                                <x-bi-trash class="w-4 h-4" />Delete
                                            </button>
                                        @endif
                                    </div>

                                    @if ($parentReplyId === $reply->id)
                                        <div class="mt-3 animate-in fade-in slide-in-from-top-1 pl-0">
                                            <form wire:submit="createReply">
                                                {{ $this->replyForm }}

                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="button"
                                                        wire:click="setReplyTo({{ $reply->id }})"
                                                        class="text-xs text-slate-400 hover:text-white px-2">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" wire:loading.attr="disabled"
                                                        class="bg-brand-hover hover:bg-accent text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                                        <span wire:loading.remove
                                                            wire:target="createReply">Reply</span>
                                                        <span wire:loading wire:target="createReply">Posting...</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($reply->children->count() > 0)
                                <div class="flex flex-col w-full">
                                    @foreach ($reply->children as $child)
                                        <div class="flex w-full relative" wire:key="child-{{ $child->id }}">

                                            <div class="w-8 shrink-0 flex justify-center relative">
                                                <div
                                                    class="w-0.5 h-full bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px]">
                                                </div>
                                            </div>

                                            <div class="flex-1 pl-4 pt-2">
                                                <div class="flex gap-3 mb-4">
                                                    <img src="{{ $child->user->avatar ? Storage::url($child->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($child->user->name) }}"
                                                        class="w-6 h-6 rounded-full mt-1 bg-zinc-100 dark:bg-slate-800 object-cover">

                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 text-xs mb-0.5">
                                                            <a href="{{ route('profile.show', $child->user) }}"
                                                                class="font-bold text-zinc-900 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                                                {{ $child->user->name }}
                                                            </a>
                                                            <span
                                                                class="text-zinc-500 dark:text-slate-500">{{ $child->created_at->diffForHumans(null, true) }}</span>
                                                        </div>

                                                        <div
                                                            class="text-sm prose fi-prose prose-sm prose-invert prose-p:leading-relaxed prose-a:text-blue-400 dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300">
                                                            {!! str($child->body)->sanitizeHtml() !!}
                                                        </div>

                                                        <div
                                                            class="flex items-center gap-3 mt-1 opacity-70 hover:opacity-100 transition-opacity">

                                                            @if (auth()->id() === $child->user_id || auth()->user()?->hasRole('admin'))
                                                                <button wire:click="deleteReply({{ $child->id }})"
                                                                    wire:confirm="Are you sure you want to delete this reply?"
                                                                    class="text-[12px] text-red-500 hover:text-red-400">Delete</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                    @empty
                        <div
                            class="text-center text-slate-500 py-10 border rounded-xl border-slate-200 zinc-200 dark:border-zinc-700">
                            No comments yet.</div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $replies->links() }}
                </div>
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
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition-colors text-sm">
                        Create Post
                    </button>
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
                            <p class="text-xs text-zinc-500">{{ $latest->replies_count ?? 0 }} comments •
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
