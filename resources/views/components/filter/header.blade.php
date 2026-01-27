@props(['results', 'categories', 'selectedCategories', 'search', 'sortBy', 'dateFrom', 'dateTo'])

@if (
    $search ||
        count($selectedCategories) > 0 ||
        $sortBy !== 'latest' ||
        $dateFrom ||
        $dateTo ||
        $attributes->has('custom-active'))
    <div class="mb-6">
        <div
            class="bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border-zinc-200/50 dark:border-zinc-800/50 border rounded-2xl p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div class="flex items-start gap-4">
                    <div
                        class="p-3 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 rounded-xl border border-zinc-400/50 dark:border-zinc-800/50">
                        <svg class="w-5 h-5 text-zinc-900 dark:text-zinc-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-medium text-zinc-950 dark:text-zinc-500 uppercase tracking-wider mb-1">
                            @if ($search)
                                SEARCH RESULTS
                            @elseif(count($selectedCategories) > 0)
                                FILTER BY
                            @else
                                REFINED VIEW
                            @endif
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-black dark:text-white mb-1">
                            @if ($search)
                                Search: "{{ $search }}"
                            @elseif(count($selectedCategories) > 0)
                                Selected Categories
                            @else
                                Filtered Results
                            @endif
                        </h2>
                    </div>
                </div>

                <button wire:click="clearFilters"
                    class="flex items-center gap-2 px-4 py-2 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 rounded-xl border border-zinc-400/50 dark:border-zinc-800/50 text-sm font-medium text-zinc-900 dark:text-zinc-50 hover:text-zinc-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    RESET
                </button>
            </div>

            <div class="flex flex-wrap gap-2">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-zinc-500/10 border border-zinc-500/20 rounded-lg text-xs font-medium text-zinc-950 dark:text-zinc-50">
                    {{ $results->total() }} RESULTS
                </span>

                @if (count($selectedCategories) > 0)
                    @foreach ($categories->whereIn('category_id', $selectedCategories) as $category)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-blue-500/20 {{ $category->badge_class ?? 'bg-blue-600 text-white' }} rounded-lg text-xs font-medium">
                            {{ strtoupper($category->name) }}
                        </span>
                    @endforeach
                @endif

                @if ($sortBy !== 'latest')
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600/90 border border-zinc-500/20 rounded-lg text-xs font-medium text-white">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        {{ strtoupper(str_replace('_', ' ', $sortBy)) }}
                    </span>
                @endif

                @if ($dateFrom || $dateTo)
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600/90 border border-zinc-500/20 rounded-lg text-xs font-medium text-white">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        @if ($dateFrom && $dateTo)
                            {{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} -
                            {{ \Carbon\Carbon::parse($dateTo)->format('M d') }}
                        @elseif($dateFrom)
                            FROM {{ \Carbon\Carbon::parse($dateFrom)->format('M d') }}
                        @else
                            UNTIL {{ \Carbon\Carbon::parse($dateTo)->format('M d') }}
                        @endif
                    </span>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>
@endif
