<div
    class="min-h-screen font-sans antialiased transition-colors duration-100
            bg-zinc-50
            dark:bg-page-gray-900">

    <div class="relative w-full h-[500px] md:h-[500px] lg:h-[600px] group">

        <div class="absolute inset-0 w-full h-full h-min-[200px]">
            <img alt="{{ $writing->title }}" class="w-full h-full object-cover" src="{{ $writing->image_url }}" />
            <div class="absolute inset-0 bg-zinc-900/40"></div>
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
                    <div class="mb-4">
                        <flux:button icon="arrow-left" :href="route('writings')"
                            class="!bg-black/20 hover:!bg-black/40 !border-white/10 !backdrop-blur-sm !text-white border transition-all">
                            Back
                        </flux:button>
                    </div>
                    <div
                        class="inline-flex items-center px-4 py-2 mb-4 rounded-lg bg-black/20 backdrop-blur-sm border border-white/10 shadow-sm">

                        <flux:breadcrumbs>
                            <flux:breadcrumbs.item icon="home" :href="route('writings')"
                                class="[&_a]:!text-white [&_.text-zinc-300]:!text-white" />

                            <flux:breadcrumbs.item
                                :href="route('writings', ['category' => $writing->categories->first()?->slug])"
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
                                <a href="{{ route('writings', ['category' => $category->slug]) }}"
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
                        @if ($writing->is_anonymous)
                            <div class="shrink-0">
                                <img alt="Anonymous"
                                    class="w-12 h-12 rounded-full border-2 border-zinc-100 dark:border-zinc-700 object-cover"
                                    src="{{ $writing->author_avatar_url }}" />
                            </div>
                        @else
                            <a href="{{ route('profile.show', $writing->user) }}" class="shrink-0">
                                <img alt="{{ $writing->author_display_name }}"
                                    class="w-12 h-12 rounded-full border-2 border-zinc-100 dark:border-zinc-700 object-cover hover:ring-2 hover:ring-blue-500 transition-all"
                                    src="{{ $writing->author_avatar_url }}" />
                            </a>
                        @endif

                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-zinc-900 dark:text-white flex items-center gap-1">
                                By
                                @if ($writing->is_anonymous)
                                    <span>{{ $writing->author_display_name }}</span>
                                @else
                                    <a href="{{ route('profile.show', $writing->user) }}"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 hover:underline transition-colors">
                                        {{ $writing->author_display_name }}
                                    </a>
                                @endif
                            </span>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-2">
                                <time
                                    datetime="{{ $writing->published_at }}">{{ $writing->published_at ? $writing->published_at->format('d M Y') : 'Draft' }}</time>
                                <span>•</span>
                                <span>{{ $writing->reading_time }} min read</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 text-zinc-500">

                        <div class="p-2 rounded-lg flex items-center gap-2 text-zinc-500 cursor-default"
                            title="Total Views">
                            <x-bi-eye class="w-5 h-5" />
                            <span class="text-xs font-bold">{{ $writing->view_count }}</span>
                        </div>

                        <button wire:click="generateInstagramStory"
                            class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors flex items-center justify-center"
                            title="Download Instastory">

                            <x-bi-instagram class="w-4 h-4" wire:loading.remove wire:target="generateInstagramStory" />

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

                        <button x-data="{ copied: false }"
                            @click.prevent="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                            class="p-2 rounded-lg transition-all duration-200 flex items-center gap-2 relative hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500"
                            :class="copied ? 'bg-green-50 dark:bg-green-900/20 text-green-600' : ''" title="Copy Link">

                            <template x-if="!copied">
                                <x-bi-link class="w-4 h-4" />
                            </template>

                            <template x-if="copied">
                                <x-bi-link class="w-4 h-4" />
                            </template>

                            <span x-show="copied" x-transition class="text-[10px] font-bold uppercase tracking-wider">
                                Copied
                            </span>
                        </button>

                        <button wire:click="toggleBookmark"
                            class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title=" ">
                            @if ($isBookmarked)
                                <x-bi-bookmark-fill />
                            @else
                                <x-bi-bookmark />
                            @endif
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

                <div class="prose dark:prose-invert max-w-none w-full break-words">
                    {!! $writing->content !!}
                </div>
                <div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">
                    <x-comments.area :comments="$comments" :parentCommentId="$parentCommentId" />
                </div>

            </div>

            <aside class="lg:col-span-4 space-y-8 lg:pt-0 sticky top-6 self-start">

                @if (!$writing->is_anonymous)
                    <livewire:profile.card :user="$writing->user" />
                @endif

                <div>
                    <h3
                        class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-white mb-5 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Latest Writings
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
            </aside>
        </div>
    </div>
</div>
