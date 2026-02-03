@props(['data'])

<div id="writing" class="mb-12 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        @if (isset($data['section_title']))
            <span class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">Our
                Writing</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold tracking-tight mb-0 text-zinc-900 dark:text-white">
                {{ $data['section_title'] }}
            </h2>
        @endif
        @if (isset($data['section_subtitle']))
            <p class="mt-4 text-zinc-500 dark:text-zinc-400 max-w-2xl text-base leading-relaxed hidden md:block">
                {{ $data['section_subtitle'] }}
            </p>
        @endif
    </div>
    <a href="{{ route('writings') }}"
        class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-700 pb-1 hover:border-accent hover:text-accent-content transition-colors">
        Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
    </a>
</div>

@php
    $writings = \App\Models\Writing::query()
        ->where('status', 'Published')
        ->latest('published_at')
        ->take($data['limit'] ?? 4)
        ->with(['user', 'categories'])
        ->withCount(['likes', 'comments'])
        ->get();
@endphp

@if ($writings->count() > 0)
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 text-left">
        @foreach ($writings as $writing)
            <x-writing.card :writing="$writing" />
        @endforeach
    </div>
@else
    <div class="py-12 text-center border border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl text-zinc-400">
        Can't found last writing.
    </div>
@endif

<div class="mt-8 md:hidden flex justify-center">
    <a href="{{ route('writings') }}"
        class="text-xs font-bold uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-700 pb-1">
        See All
    </a>
</div>
