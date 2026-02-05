@props(['writing'])

@php
    $date = $writing->published_at ? $writing->published_at->format('M d, Y') : $writing->created_at->format('M d, Y');
    $link = route('writing.show', $writing->slug ?? '#');
@endphp

<article
    class="group relative flex flex-col-reverse lg:flex-row gap-6 py-6 hover:opacity-90 duration-300 p-4 lg:p-8 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border-zinc-200/50 dark:border-zinc-800/50 backdrop-blur-xs border rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer overflow-hidden">

    <div class="absolute inset-y-0 right-0 w-[30%] hidden lg:block -z-10">
        <img src="{{ $writing->image_url }}" alt="{{ $writing->title }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

    </div>

    <div class="flex-1 flex flex-col justify-between min-w-0 relative z-10 lg:max-w-[55%]">
        <div class="flex items-center mb-4">
            @if ($writing->is_anonymous)
                {{-- Tampilan untuk Anonymous (Tanpa Link & Efek Hover) --}}
                <div class="flex items-center cursor-default">
                    <img src="{{ $writing->author_avatar_url }}" alt="{{ $writing->author_display_name }}"
                        class="w-6 h-6 rounded-full object-cover mr-2 border border-transparent opacity-80">
                    <span class="text-black dark:text-zinc-100 text-sm">
                        {{ $writing->author_display_name }}
                    </span>
                </div>
            @else
                {{-- Tampilan Normal (Dengan Link ke Profile) --}}
                <a href="{{ route('profile.show', $writing->user) }}"
                    class="flex items-center hover:underline group/author">
                    <img src="{{ $writing->author_avatar_url }}" alt="{{ $writing->author_display_name }}"
                        class="w-6 h-6 rounded-full object-cover mr-2 border border-transparent group-hover/author:border-blue-500 transition-colors">
                    <span
                        class="text-black dark:text-zinc-100 text-sm group-hover/author:text-blue-600 dark:group-hover/author:text-blue-400 transition-colors">
                        {{ $writing->author_display_name }}
                    </span>
                </a>
            @endif
        </div>

        <div class="flex items-center gap-2 mb-2 flex-wrap">
            @foreach ($writing->categories as $category)
                <span
                    class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white {{ $category->badge_class }} rounded">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>

        <a href="{{ $link }}" class="mb-2 block">
            <h2
                class="text-xl font-bold text-black dark:text-zinc-100 leading-tight group-hover:text-gray-500 line-clamp-2 mb-2 transition-colors">
                {{ $writing->title }}
            </h2>
        </a>

        @if ($writing->description)
            <p class="text-gray-800 dark:text-page-gray-200 text-md leading-relaxed mb-2 line-clamp-2 sm:block">
                {{ Str::limit($writing->description, 150) }}
            </p>
        @endif

        <p class="text-gray-700 dark:text-page-gray-400 text-sm leading-relaxed mb-4 line-clamp-2 hidden sm:block">
            {{ Str::limit($writing->excerpt, 180) }}
        </p>

        <div class="flex items-center justify-between mt-auto">
            <div class="flex items-center text-xs text-gray-500">
                <span>{{ $date }}</span>
                <span class="mx-2">·</span>
                <span>{{ $writing->reading_time }} min read</span>
            </div>

            <div class="flex items-center gap-3 text-xs text-gray-500">
                <div class="flex items-center gap-1" title="Views">
                    <x-bi-eye />
                    <span>{{ $writing->view_count ?? 0 }}</span>
                </div>

                <div class="flex items-center gap-1" title="Likes">
                    <x-bi-heart-fill class="text-red-500 bg-red-50 dark:bg-red-900/20" />
                    <span>{{ $writing->likes_count ?? $writing->likes()->count() }}</span>
                </div>

                <div class="flex items-center gap-1" title="Comments">
                    <x-bi-chat-left-text-fill />
                    <span>{{ $writing->comments_count ?? $writing->comments()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full h-48 lg:hidden flex-shrink-0 overflow-hidden rounded relative z-10">
        <a href="{{ $link }}">
            <img src="{{ $writing->image_url }}" alt="{{ $writing->title }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        </a>
    </div>
</article>
