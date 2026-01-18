@props([
    'image',
    'avatar',
    'author',
    'categories',
    'date',
    'readTime',
    'title',
    'description',
    'excerpt',
    'link' => '#',
])

<article
    class="group flex gap-6 py-6 hover:opacity-90 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 border border-zinc-200/50 dark:border-zinc-800/50 transition-all duration-300 rounded-lg backdrop-blur-xs p-4 my-2 lg:p-8 lg:my-4">

    <div class="flex-1 flex flex-col justify-between min-w-0">
        <div class="flex items-center mb-4">
            <img src="{{ $avatar }}" alt="{{ $author }}" class="w-6 h-6 rounded-full object-cover mr-2">
            <span class="text-black dark:text-zinc-100  text-sm">{{ $author }}</span>
        </div>

        <div class="flex items-center gap-2 mb-2 flex-wrap">
            @foreach ($categories as $category)
                <span
                    class="px-3 py-1 text-xs font-bold uppercase tracking-wider text-white {{ $category->badge_class }} rounded-full">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>

        <a href="{{ $link }}" class="mb-2 block">
            <h2
                class="text-xl font-bold text-black dark:text-zinc-100 leading-tight group-hover:text-gray-500 line-clamp-2 mb-2 transition-colors">
                {{ $title }}
            </h2>
        </a>

        @if ($description)
            <p class="text-gray-800 dark:text-page-gray-200 text-md leading-relaxed mb-2 line-clamp-2 sm:block">
                {{ $description }}
            </p>
        @endif

        <p class="text-gray-700 dark:text-page-gray-400 text-sm leading-relaxed mb-4 line-clamp-2 hidden sm:block">
            {{ $excerpt }}
        </p>

        <div class="flex items-center text-xs text-gray-500 mt-auto">
            <span>{{ $date }}</span>
            <span class="mx-2">·</span>
            <span>{{ $readTime }} min read</span>
        </div>
    </div>

    <div class="w-38 lg:w-48 h-auto flex-shrink-0 overflow-hidden rounded">
        <a href="{{ $link }}">
            <img src="{{ $image }}" alt="{{ $title }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        </a>
    </div>

</article>
