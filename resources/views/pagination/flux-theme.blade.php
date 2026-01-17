@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex sm:hidden">
            <span class="relative z-0 inline-flex items-center gap-1 rounded-lg">
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Previous">
                        <span
                            class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5 opacity-50"
                            aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150"
                        aria-label="Previous">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span
                                class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span
                                        class="relative inline-flex items-center px-3.5 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600 cursor-default rounded-lg leading-5 min-w-[2.5rem] justify-center">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-3.5 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150 min-w-[2.5rem] justify-center"
                                    aria-label="Go to page {{ $page }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150"
                        aria-label="Next">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Next">
                        <span
                            class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5 opacity-50"
                            aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </span>
                @endif
            </span>
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-5 mx-4">
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {{ Str::plural('writings', $paginator->total()) }} found
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex items-center gap-1 rounded-lg">
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous">
                            <span
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5 opacity-50"
                                aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150"
                            aria-label="Previous">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600 cursor-default rounded-lg leading-5 min-w-[2.5rem] justify-center">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150 min-w-[2.5rem] justify-center"
                                        aria-label="Go to page {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg leading-5 hover:bg-zinc-50 dark:hover:bg-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-zinc-100 dark:active:bg-zinc-700 active:text-zinc-700 dark:active:text-zinc-300 transition ease-in-out duration-150"
                            aria-label="Next">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                            <span
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 cursor-default rounded-lg leading-5 opacity-50"
                                aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
