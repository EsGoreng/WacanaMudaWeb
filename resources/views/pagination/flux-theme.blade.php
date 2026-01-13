<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

            {{-- Mobile View (Simple Previous/Next) --}}
            <div class="flex justify-between flex-1 sm:hidden">
                @if ($paginator->onFirstPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-500 bg-zinc-900 border border-zinc-700 cursor-default leading-5 rounded-md">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-300 bg-zinc-900 border border-zinc-700 leading-5 rounded-md hover:text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-accent transition ease-in-out duration-150">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-zinc-300 bg-zinc-900 border border-zinc-700 leading-5 rounded-md hover:text-white hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-accent transition ease-in-out duration-150">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span
                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-zinc-500 bg-zinc-900 border border-zinc-700 cursor-default leading-5 rounded-md">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            {{-- Desktop View --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                {{-- Text Summary --}}
                <div class="mx-4">
                    <p class="text-sm text-zinc-400">
                        Showing
                        <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium text-white">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                {{-- Number Links --}}
                <div>
                    <span class="relative z-0 inline-flex shadow-sm rounded-md -space-x-px">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-zinc-500 bg-zinc-900 border border-zinc-700 cursor-default rounded-l-md leading-5"
                                    aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @else
                            <button wire:click="previousPage" rel="prev"
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-zinc-400 bg-zinc-900 border border-zinc-700 rounded-l-md leading-5 hover:text-white hover:bg-zinc-800 focus:z-10 focus:outline-none focus:ring-1 focus:ring-accent transition ease-in-out duration-150"
                                aria-label="{{ __('pagination.previous') }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-zinc-400 bg-zinc-900 border border-zinc-700 cursor-default leading-5">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        {{-- ACTIVE STATE: Menggunakan variable --color-accent dari CSS --}}
                                        <span aria-current="page">
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-accent-foreground bg-accent border border-accent cursor-default leading-5 z-10">
                                                {{ $page }}
                                            </span>
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-zinc-400 bg-zinc-900 border border-zinc-700 leading-5 hover:text-white hover:bg-zinc-800 focus:z-10 focus:outline-none focus:ring-1 focus:ring-accent transition ease-in-out duration-150"
                                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" rel="next"
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-zinc-400 bg-zinc-900 border border-zinc-700 rounded-r-md leading-5 hover:text-white hover:bg-zinc-800 focus:z-10 focus:outline-none focus:ring-1 focus:ring-accent transition ease-in-out duration-150"
                                aria-label="{{ __('pagination.next') }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span
                                    class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-zinc-500 bg-zinc-900 border border-zinc-700 cursor-default rounded-r-md leading-5"
                                    aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
