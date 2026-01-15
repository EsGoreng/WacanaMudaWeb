<div
    class="min-h-screen font-sans antialiased transition-colors duration-100
            bg-zinc-50
            dark:bg-page-gray-800">

    <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] group">

        <div class="absolute inset-0 w-full h-full">
            <img alt="{{ $writing->title }}" class="w-full h-full object-cover" src="{{ $writing->image_url }}" />
            <div class="absolute inset-0 bg-zinc-900/40"></div>
        </div>

        <div class="absolute top-6 left-4 lg:left-8">
            <flux:button icon="arrow-left" :href="route('writing')"
                class="!bg-black/20 hover:!bg-black/40 !border-white/10 !backdrop-blur-sm !text-white border transition-all">
                Back
            </flux:button>
        </div>

        <div
            class="absolute inset-0
           bg-gradient-to-t
           from-page-gray-300/90
           via-page-gray-300/40
           to-transparent
           dark:from-page-gray-800
           dark:via-page-gray-800/40
           dark:to-transparent">
        </div>

        <div class="absolute inset-0 flex items-end justify-center pb-12 md:pb-16">
            <div class="max-w-screen-xl w-full mx-auto px-4 lg:px-6">
                <div class="max-w-4xl">
                    @if ($writing->category)
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white {{ $writing->category->badge_class }} rounded-full">
                                {{ $writing->category->name }}
                            </span>
                        </div>
                    @endif

                    <h1
                        class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-zinc-900 dark:text-white leading-tight tracking-tight mb-4 drop-shadow-sm">
                        {{ $writing->title }}
                    </h1>

                    @if ($writing->description)
                        <p
                            class="text-lg md:text-xl text-zinc-700 dark:text-zinc-300 font-light leading-relaxed max-w-2xl">
                            {{ $writing->description }}
                        </p>
                    @endif

                    {{-- Proper Unsplash Attribution --}}
                    @if ($writing->image_credit && $writing->image_credit_url)
                        <div class="mt-4 flex items-center gap-2">
                            <div
                                class="px-3 py-1.5 bg-black/20 dark:bg-black/40 backdrop-blur-md rounded-lg border border-white/10 text-xs text-zinc-800 dark:text-zinc-200 shadow-sm inline-flex items-center gap-1">
                                <span class="opacity-70">Photo by</span>
                                {{-- Link ke photographer dengan UTM tracking --}}
                                <a href="{{ $writing->image_credit_url }}?utm_source={{ urlencode(config('app.name', 'WacanaMuda')) }}&utm_medium=referral"
                                    target="_blank" rel="noopener noreferrer"
                                    class="font-semibold hover:underline decoration-zinc-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $writing->image_credit }}
                                </a>
                                <span class="opacity-70">on</span>
                                {{-- Link ke Unsplash dengan UTM tracking --}}
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

            <div class="lg:col-span-8">

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
                        <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title="Share on Facebook">
                            <x-bi-facebook />
                        </button>
                        <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title="Tweet">
                            <x-bi-share />
                        </button>
                        <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title="Copy Link">
                            <x-bi-link />
                        </button>
                        <button class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            title="Bookmark">
                            <x-bi-bookmark />
                        </button>
                    </div>
                </div>

                <div
                    class="prose prose-xl prose-slate dark:prose-invert max-w-none 
    prose-headings:font-bold prose-headings:text-zinc-900 dark:prose-headings:text-white
    prose-img:rounded-xl prose-img:shadow-lg [&_.fi-in-text-item]:text-zinc-700 dark:[&_.fi-in-text-item]:text-zinc-300">
                    {{ $this->articleInfolist }}
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

                {{-- Latest News --}}
                <div>
                    <h3
                        class="text-sm font-bold uppercase tracking-wider text-zinc-900 dark:text-white mb-5 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Latest News
                    </h3>
                    <div class="space-y-6">
                        @forelse($latestPosts as $post)
                            <div class="flex gap-4 group cursor-pointer"
                                onclick="window.location='{{ route('writing.show', $post->slug) }}'">
                                {{-- Thumbnail --}}
                                <div class="shrink-0 overflow-hidden rounded-lg">
                                    <img alt="{{ $post->title }}"
                                        class="w-24 h-24 object-cover transition-transform duration-300 group-hover:scale-110"
                                        src="{{ $post->image_url }}" />
                                </div>
                                {{-- Text --}}
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

                {{-- Advertisement (Optional) --}}
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
