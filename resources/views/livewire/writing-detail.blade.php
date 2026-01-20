<div
    class="min-h-screen font-sans antialiased transition-colors duration-100
            bg-zinc-50
            dark:bg-page-gray-900">

    <div class="relative w-full h-[500px] md:h-[500px] lg:h-[600px] group">

        <div class="absolute inset-0 w-full h-full">
            <img alt="{{ $writing->title }}" class="w-full h-full object-cover" src="{{ $writing->image_url }}" />
            <div class="absolute inset-0 bg-zinc-900/40"></div>
        </div>

        <div class="absolute top-6 left-4 lg:left-8 z-10">
            <flux:button icon="arrow-left" :href="route('writing')"
                class="!bg-black/20 hover:!bg-black/40 !border-white/10 !backdrop-blur-sm !text-white border transition-all">
                Back
            </flux:button>
        </div>

        <div
            class="absolute inset-0
           bg-gradient-to-t
           from-zinc-50
           via-zinc-300/40
           to-transparent
           dark:from-page-gray-900
           dark:via-page-gray-900/40
           dark:to-transparent">
        </div>

        <div class="absolute inset-0 flex items-end justify-center pb-12 md:pb-16">
            <div class="max-w-screen-xl w-full mx-auto px-4 lg:px-6">
                <div class="max-w-4xl">
                    <div
                        class="inline-flex items-center px-4 py-2 mb-4 rounded-lg bg-black/20 backdrop-blur-sm border border-white/10 shadow-sm">

                        <flux:breadcrumbs>
                            <flux:breadcrumbs.item icon="home" :href="route('writing')"
                                class="[&_a]:!text-white [&_.text-zinc-300]:!text-white" />

                            <flux:breadcrumbs.item
                                :href="route('writing', ['category' => $writing->categories->first()?->slug])"
                                class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-none [&_.text-gray-500]:!text-white [&_.text-zinc-800]:!text-white []">
                                {{ $writing->categories->first()?->name ?? 'General' }}
                            </flux:breadcrumbs.item>

                            <flux:breadcrumbs.item
                                class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-none [&_.text-gray-500]:!text-white">
                                {{ $writing->title }}
                            </flux:breadcrumbs.item>
                        </flux:breadcrumbs>

                    </div>

                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($writing->categories as $category)
                                <a href="{{ route('writing', ['category' => $category->slug]) }}"
                                    class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full {{ $category->badge_class }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <h1
                        class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-zinc-900 dark:text-white leading-tight tracking-tight mb-4 drop-shadow-sm">
                        {{ $writing->title }}
                    </h1>

                    @if ($writing->description)
                        <p class="text-lg md:text-xl text-zinc-700 dark:text-zinc-300 leading-relaxed max-w-2xl">
                            {{ $writing->description }}
                        </p>
                    @endif

                    @if ($writing->image_credit && $writing->image_credit_url)
                        <div class="mt-4 flex items-center gap-2">
                            <div
                                class="px-3 py-1.5 bg-black/20 dark:bg-black/40 backdrop-blur-sm rounded-lg border border-white/10 text-xs text-zinc-800 dark:text-zinc-200 shadow-sm inline-flex items-center gap-1">
                                <span class="opacity-70">Photo by</span>
                                <a href="{{ $writing->image_credit_url }}?utm_source={{ urlencode(config('app.name', 'WacanaMuda')) }}&utm_medium=referral"
                                    target="_blank" rel="noopener noreferrer"
                                    class="font-semibold hover:underline decoration-zinc-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $writing->image_credit }}
                                </a>
                                <span class="opacity-70">on</span>
                                <a href="https://unsplash.com/?utm_source={{ urlencode(config('app.name', 'WacanaMuda')) }}&utm_medium=referral"
                                    target="_blank" rel="noopener noreferrer"
                                    class="font-semibold hover:underline decoration-zinc-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    Unsplash
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-4 lg:px-6 py-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            <div class="lg:col-span-8 min-w-0">

                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between py-6 border-b border-t border-zinc-200 dark:border-zinc-700 mb-10">

                    <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                        <img alt="{{ $writing->author_display_name }}"
                            class="w-12 h-12 rounded-full border-2 border-zinc-100 dark:border-zinc-700 object-cover"
                            src="{{ $writing->author_avatar_url }}" />
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-zinc-900 dark:text-white">
                                By {{ $writing->author_display_name }}
                            </span>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                                <time
                                    datetime="{{ $writing->published_at }}">{{ $writing->published_at->format('M d, Y') }}</time>
                                <span>•</span>
                                <span>{{ $writing->reading_time }} min read</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 text-zinc-500 dark:text-zinc-400">
                        <button wire:click="generateInstagramStory"
                            class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors flex items-center justify-center"
                            title="Download Instastory">

                            <x-bi-camera class="w-4 h-4" wire:loading.remove wire:target="generateInstagramStory" />

                            <svg wire:loading wire:target="generateInstagramStory"
                                class="animate-spin w-4 h-4 text-zinc-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                        <button x-data="{
                            copied: false,
                            shareData: {
                                title: '{{ $writing->title }}',
                                text: 'Baca tulisan dari {{ $writing->author_display_name }}: {{ $writing->title }}',
                                url: window.location.href
                            },
                            async share() {
                                if (navigator.share) {
                                    try {
                                        await navigator.share(this.shareData);
                                    } catch (err) {
                                        console.log('Share cancelled');
                                    }
                                } else {
                                    try {
                                        await navigator.clipboard.writeText(`${this.shareData.text}\n\n${this.shareData.url}`);
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 2000);
                                    } catch (err) {
                                        console.error('Gagal menyalin', err);
                                    }
                                }
                            }
                        }" @click="share()"
                            class="p-2 rounded-lg transition-all duration-200 flex items-center gap-2 relative
                            {{ 'hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500' }}"
                            :class="copied ? 'bg-green-50 dark:bg-green-900/20 text-green-600' : ''" title="Share Link">
                            <template x-if="!copied">
                                <x-bi-link class="w-4 h-4" />
                            </template>

                            <template x-if="copied">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </template>

                            <span x-show="copied" x-transition
                                class="text-[10px] font-bold uppercase tracking-wider">Copied</span>
                        </button>
                        <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title="Bookmark">
                            <x-bi-bookmark />
                        </button>
                        <button wire:click="toggleLike"
                            class="p-2 rounded-lg transition-colors flex items-center gap-2
                            {{ $isLiked ? 'text-red-500 bg-red-50 dark:bg-red-900/20' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500' }}"
                            title="Like">

                            @if ($isLiked)
                                <x-bi-heart-fill />
                            @else
                                <x-bi-heart />
                            @endif

                            <span class="text-xs font-bold">{{ $likesCount }}</span>
                        </button>
                    </div>
                </div>

                <div>
                    {{ $this->articleInfolist }}
                </div>

                <div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">

                    <h3
                        class="text-lg font-medium text-zinc-900 dark:text-slate-100 mb-6 border-b border-zinc-200 dark:border-slate-800 pb-2">
                        Comments <span
                            class="text-zinc-500 dark:text-slate-500 text-sm ml-1">({{ $comments->total() }})</span>
                    </h3>

                    @auth
                        <div class="mb-8 flex gap-3">
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
                        @forelse($comments as $comment)

                            <div class="flex flex-col" wire:key="comment-{{ $comment->id }}">

                                <div class="flex gap-3 relative group">
                                    <div class="flex flex-col items-center shrink-0 w-8">
                                        <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                            class="w-8 h-8 rounded-full object-cover ring-2 ring-white dark:ring-[#0B1416] z-10 relative bg-zinc-100 dark:bg-zinc-800">

                                        @if ($comment->children->count() > 0 || $parentCommentId === $comment->id)
                                            <div
                                                class="w-0.5 h-full bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px]">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0 pb-2">
                                        <div class="flex items-center gap-2 text-xs mb-1">
                                            <span
                                                class="font-bold text-zinc-900 dark:text-slate-200">{{ $comment->user->name }}</span>
                                            <span class="text-zinc-500 dark:text-slate-500">•
                                                {{ $comment->created_at->diffForHumans(null, true) }}</span>
                                        </div>

                                        <div
                                            class="fi-prose prose-sm dark:prose-invert dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300">
                                            {!! str($comment->body)->sanitizeHtml() !!}
                                        </div>

                                        <div class="flex items-center gap-2 mt-1">
                                            @auth
                                                <button wire:click="setReplyTo({{ $comment->id }})"
                                                    class="flex items-center gap-1 text-xs font-bold text-zinc-500 dark:text-slate-500 hover:bg-zinc-100 dark:hover:bg-slate-800 px-2 py-2 rounded transition-colors">
                                                    <x-bi-chat-left class="w-4 h-4" /> Reply
                                                </button>

                                                @if (auth()->id() === $comment->user_id || auth()->user()?->hasRole('admin'))
                                                    <button wire:click="deleteComment({{ $comment->id }})"
                                                        wire:confirm="Are you sure you want to delete this comment?"
                                                        class="flex items-center gap-1 text-xs text-red-500 hover:text-red-400 hover:bg-zinc-100 dark:hover:bg-slate-800 px-2 py-2 rounded transition-colors">
                                                        <x-bi-trash class="w-4 h-4" /> Delete
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>

                                        @if ($parentCommentId === $comment->id)
                                            <div class="mt-3 animate-in fade-in slide-in-from-top-1 pl-0">
                                                <form wire:submit="createReply">

                                                    {{ $this->replyForm }}

                                                    <div class="flex justify-end gap-2 mt-4">
                                                        <button type="button"
                                                            wire:click="setReplyTo({{ $comment->id }})"
                                                            class="text-xs text-zinc-500 dark:text-slate-400 hover:text-zinc-900 dark:hover:text-white px-2">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" wire:loading.attr="disabled"
                                                            class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                                                            <span wire:loading.remove
                                                                wire:target="createReply">Reply</span>
                                                            <span wire:loading
                                                                wire:target="createReply">Posting...</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if ($comment->children->count() > 0)
                                    <div class="flex flex-col w-full">
                                        @foreach ($comment->children as $child)
                                            <div class="flex w-full relative" wire:key="child-{{ $child->id }}">

                                                <div class="w-8 shrink-0 flex justify-center relative">
                                                    <div
                                                        class="w-0.5 bg-zinc-200 dark:bg-slate-800 absolute left-4 -ml-[2px] h-full">
                                                    </div>
                                                </div>

                                                <div class="flex-1 pl-4 pt-2">
                                                    <div class="flex gap-3 mb-4">
                                                        <img src="{{ $child->user->avatar ? Storage::url($child->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($child->user->name) }}"
                                                            class="w-6 h-6 rounded-full mt-1 bg-zinc-100 dark:bg-slate-800 object-cover">

                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 text-xs mb-0.5">
                                                                <span
                                                                    class="font-bold text-zinc-900 dark:text-slate-200">{{ $child->user->name }}</span>
                                                                <span
                                                                    class="text-zinc-500 dark:text-slate-500 text-[10px]">{{ $child->created_at->diffForHumans(null, true) }}</span>
                                                            </div>

                                                            <div
                                                                class="text-sm prose fi-prose prose-sm prose-invert prose-p:leading-relaxed prose-a:text-blue-400 dark:prose-invert max-w-none text-zinc-700 dark:text-slate-300">
                                                                {!! str($child->body)->sanitizeHtml() !!}
                                                            </div>

                                                            <div
                                                                class="flex items-center gap-3 mt-1 opacity-70 hover:opacity-100 transition-opacity">
                                                                @if (auth()->id() === $child->user_id || auth()->user()?->hasRole('admin'))
                                                                    <button
                                                                        wire:click="deleteComment({{ $child->id }})"
                                                                        wire:confirm="Are you sure you want to delete this reply?"
                                                                        class="text-[10px] text-red-500 hover:text-red-400 font-medium">Delete</button>
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
                                class="text-center text-zinc-500 dark:text-slate-500 py-10 border rounded-xl border-zinc-200 dark:border-zinc-700">
                                No comments yet. Be the first to start the conversation!
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        @if ($comments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $comments->links() }}
                        @endif
                    </div>
                </div>

            </div>

            <aside class="lg:col-span-4 space-y-8 lg:pt-0 sticky top-6 self-start">
                <div
                    class="bg-zinc-50 dark:bg-[#1f2937] p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 mb-2">
                        Newsletter
                    </h3>
                    <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">
                        Get the latest updates
                    </h4>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed">
                        Get all the stories you need-to-know from the most powerful name in news delivered first thing
                        every morning to your inbox.
                    </p>
                    <button
                        class="w-full bg-brand-hover hover:bg-accent text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                        Subscribe
                    </button>
                </div>

                <div>
                    <h3
                        class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-white mb-5 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Latest News
                    </h3>
                    <div class="space-y-6">
                        @forelse($latestPosts as $post)
                            <div class="flex gap-4 group cursor-pointer"
                                onclick="window.location='{{ route('writing.show', $post->slug) }}'">
                                <div class="shrink-0 overflow-hidden rounded-lg">
                                    <img alt="{{ $post->title }}"
                                        class="w-24 h-24 object-cover transition-transform duration-300 group-hover:scale-110"
                                        src="{{ $post->image_url }}" />
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h4
                                        class="font-bold text-base text-zinc-900 dark:text-white mb-1 leading-snug group-hover:text-blue-500 transition-colors line-clamp-2">
                                        <a href="{{ route('writing.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                        <span>{{ $post->reading_time }} min read</span>
                                    </div>
                                    <a href="{{ route('writing.show', $post->slug) }}"
                                        class="text-sm font-medium text-blue-600 dark:text-blue-500 mt-2 hover:underline">
                                        Read story
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-zinc-500 dark:text-zinc-400 text-sm italic">No other posts available.</p>
                        @endforelse
                    </div>
                </div>

                <div
                    class="bg-zinc-100 dark:bg-zinc-800 h-[300px] rounded-xl flex flex-col items-center justify-center text-center p-4">
                    <span
                        class="text-zinc-400 dark:text-zinc-500 text-xs font-semibold uppercase tracking-widest mb-2">Advertisement</span>
                    <div class="w-16 h-1 border-t-2 border-zinc-300 dark:border-zinc-600"></div>
                </div>

            </aside>
        </div>
    </div>
</div>
