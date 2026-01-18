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
                        class="inline-flex items-center px-4 py-2 mb-4 rounded-lg bg-black/20 backdrop-blur-md border border-white/10 shadow-sm">

                        <flux:breadcrumbs>
                            <flux:breadcrumbs.item icon="home" :href="route('writing')"
                                class="[&_a]:!text-white [&_.text-zinc-300]:!text-white" />

                            <flux:breadcrumbs.item
                                :href="route('writing', ['category' => $writing->categories->first()?->slug])">
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
                                class="px-3 py-1.5 bg-black/20 dark:bg-black/40 backdrop-blur-md rounded-lg border border-white/10 text-xs text-zinc-800 dark:text-zinc-200 shadow-sm inline-flex items-center gap-1">
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

                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">
                        Comments ({{ $comments->count() }})
                    </h3>

                    @auth
                        <form wire:submit.prevent="postComment" class="mb-8">
                            <div class="mb-4">
                                <textarea wire:model="commentBody"
                                    class="w-full p-4 rounded-xl border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                    rows="3" placeholder="What are your thoughts?"></textarea>
                                @error('commentBody')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-brand-hover hover:bg-accent text-white font-semibold rounded-lg transition-colors">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-8 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl text-center">
                            <p class="text-zinc-600 dark:text-zinc-400">Please <a href="{{ route('login') }}"
                                    class="text-blue-600 hover:underline">login</a> to leave a comment.</p>
                        </div>
                    @endauth

                    <div class="space-y-2">
                        @forelse($comments as $comment)
                            @php
                                $user = auth()->user();
                                $isCurrentUser = $user->id === $comment->user_id;
                                $isAdmin = $user->hasAnyRole(['superadmin', 'admin']);
                                $canManage = $isCurrentUser || $isAdmin;
                            @endphp

                            <div
                                class="group flex gap-3 md:gap-4 w-full {{ $isCurrentUser ? 'flex-row-reverse' : 'flex-row' }}">

                                <div class="shrink-0 flex flex-col justify-start mt-5">
                                    <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                        alt="{{ $comment->user->name }}"
                                        class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover shadow-sm ring-2 ring-white dark:ring-zinc-800">
                                </div>
                                <div
                                    class="flex flex-col max-w-[85%] sm:max-w-[70%] {{ $isCurrentUser ? 'items-end' : 'items-start' }}">

                                    <div
                                        class="flex items-center gap-2 mb-1 px-1 opacity-90 {{ $isCurrentUser ? 'flex-row-reverse' : 'flex-row' }}">
                                        <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">
                                            {{ $isCurrentUser ? 'You' : $comment->user->name }}
                                        </span>
                                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500">
                                            {{ $comment->created_at->format('H:i') }}
                                        </span>
                                    </div>

                                    @if ($editingCommentId === $comment->id)
                                        <div
                                            class="w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-3 shadow-lg relative z-20">
                                            <textarea wire:model="editingBody"
                                                class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm text-zinc-900 dark:text-white resize-none placeholder:text-zinc-400"
                                                rows="3"></textarea>

                                            <div class="flex justify-end gap-2 mt-2">
                                                <button wire:click="cancelEdit"
                                                    class="text-xs text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 font-medium px-2 py-1">Cancel</button>
                                                <button wire:click="updateComment"
                                                    class="text-xs bg-zinc-700 hover:bg-zinc-600 text-white font-medium px-3 py-1 rounded-md transition-colors">Save</button>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="relative px-4 py-2 shadow-md transition-all duration-200 hover:shadow-lg group/bubble
                    {{ $isCurrentUser
                        ? 'bg-zinc-700 text-white rounded-2xl rounded-tr-sm ' . ($canManage ? 'pr-9' : '')
                        : 'bg-white dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700/50 text-zinc-800 dark:text-zinc-200 rounded-2xl rounded-tl-sm ' .
                            ($canManage ? 'pr-9' : '') }}">

                                            {{-- blade-formatter-disable --}}
                    <p class="text-sm md:text-[15px] leading-normal whitespace-pre-line tracking-wide break-words">{{ trim($comment->body) }}</p>
                    {{-- blade-formatter-enable --}}
                                            @if ($canManage)
                                                <div x-data="{ open: false }" class="absolute top-2 right-1">

                                                    <button @click="open = !open" @click.outside="open = false"
                                                        class="p-1 rounded-full hover:bg-black/10 dark:hover:bg-white/10 transition-all opacity-0 group-hover/bubble:opacity-100 focus:opacity-100 {{ $isCurrentUser ? 'text-zinc-300 hover:text-white' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200' }}"
                                                        title="Options">
                                                        <x-bi-three-dots-vertical class="w-3.5 h-3.5" />
                                                    </button>

                                                    <div x-show="open" x-transition.origin.top.right
                                                        style="display: none;"
                                                        class="absolute right-0 mt-1 w-28 bg-white dark:bg-zinc-900 rounded-lg shadow-xl border border-zinc-200 dark:border-zinc-700 py-1 z-50 overflow-hidden text-left">

                                                        @if ($isCurrentUser)
                                                            <button wire:click="editComment({{ $comment->id }})"
                                                                @click="open = false"
                                                                class="w-full text-left px-3 py-2 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2">
                                                                <x-bi-pencil class="w-3 h-3" /> Edit
                                                            </button>
                                                        @endif

                                                        <button wire:click="deleteComment({{ $comment->id }})"
                                                            @click="open = false"
                                                            class="w-full text-left px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
                                                            <x-bi-trash class="w-3 h-3" /> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                    <div
                                        class="flex items-center gap-3 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $isCurrentUser ? 'flex-row-reverse' : 'flex-row' }}">
                                        <span class="text-[10px] text-zinc-300 dark:text-zinc-600">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="flex flex-col items-center justify-center py-12 px-4 border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-2xl bg-zinc-50/50 dark:bg-zinc-800/20">
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-full mb-4">
                                    <x-bi-chat-quote class="w-8 h-8 text-blue-500 dark:text-blue-400" />
                                </div>
                                <h3 class="text-zinc-900 dark:text-white font-bold mb-1">No comments yet</h3>
                                <p class="text-zinc-500 dark:text-zinc-400 text-sm text-center max-w-xs">
                                    Be the first to share your thoughts and start the conversation.
                                </p>
                            </div>
                        @endforelse
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
