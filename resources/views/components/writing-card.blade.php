@props(['image', 'avatar', 'author', 'date', 'readTime', 'title', 'excerpt', 'link' => '#'])

<div
    class="flex flex-col h-full bg-zinc-900 border border-zinc-700 rounded-xl overflow-hidden hover:border-zinc-600 transition-colors duration-300">
    <div class="h-48 w-full overflow-hidden relative">
        <img src="{{ $image }}" alt="{{ $title }}"
            class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500">
    </div>

    <div class="p-6 flex flex-col flex-grow">

        <div class="flex items-center mb-4">
            <img src="{{ $avatar }}" alt="{{ $author }}"
                class="w-10 h-10 rounded-full object-cover border border-gray-700 mr-3">
            <div class="flex flex-col">
                <span class="text-white text-sm font-semibold leading-tight">{{ $author }}</span>
                <span class="text-gray-500 text-xs mt-0.5">{{ $date }} · {{ $readTime }}</span>
            </div>
        </div>

        <a href="{{ $link }}" class="group">
            <h3
                class="text-xl font-bold text-white mb-3 leading-snug group-hover:text-blue-400 transition-colors line-clamp-2">
                {{ $title }}
            </h3>
        </a>

        <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
            {{ $excerpt }}
        </p>

        <div class="mt-auto">
            <a href="{{ $link }}"
                class="inline-flex items-center text-sm font-medium text-blue-500 hover:text-blue-400 hover:underline">
                Read more
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
    </div>
</div>
