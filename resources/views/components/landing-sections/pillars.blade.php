@props(['data'])

<div id="pillar" class="mb-12 text-center">
    @if (isset($data['section_title']))
        <span class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">PILLAR</span>
        <h2 class="font-display text-4xl md:text-5xl font-bold tracking-tight mb-4 text-zinc-900 dark:text-white">
            {{ $data['section_title'] }}
        </h2>
    @endif
    @if (isset($data['section_subtitle']))
        <p class="text-zinc-500 dark:text-zinc-400 max-w-xl mx-auto text-base leading-relaxed">
            {{ $data['section_subtitle'] }}
        </p>
    @endif
</div>
@if (isset($data['items']))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
        @foreach ($data['items'] as $index => $pillar)
            <div
                class="group relative p-8 rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 hover:border-accent/50 transition-colors duration-300">
                <div
                    class="text-5xl font-bold text-zinc-100 dark:text-zinc-800 mb-6 group-hover:text-accent-content/10 transition-colors">
                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                </div>
                <h3 class="font-display text-xl font-bold mb-3 text-zinc-900 dark:text-white">
                    {{ $pillar['title'] ?? '' }}
                </h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    {{ $pillar['description'] ?? '' }}
                </p>
            </div>
        @endforeach
    </div>
@endif
