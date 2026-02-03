@props(['data'])

<div id="vision" class="mb-12 text-center">
    @if (isset($data['section_title']))
        <span class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">TARGET</span>
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
<div class="container mx-auto px-4 md:px-10">
    <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-start">
        {{-- Left Column: VISION --}}
        <div class="w-full lg:w-5/12 items-start">
            <div class="flex flex-col gap-6 lg:sticky lg:top-32">
                <div class="flex items-center gap-4">
                    <span class="h-px w-8 bg-accent"></span>
                    <span class="text-zinc-400 dark:text-zinc-500 text-xs font-bold uppercase tracking-[0.2em]">
                        Vision
                    </span>
                </div>
                <blockquote
                    class="text-zinc-900 dark:text-white text-xl md:text-2xl lg:text-3xl font-black leading-tight tracking-tight font-display">
                    {{ $data['vision'] ?? 'Membangun masa depan yang berkelanjutan.' }}
                </blockquote>
                <div class="w-full h-px bg-zinc-200 dark:bg-zinc-800 mt-2"></div>
            </div>
        </div>

        {{-- Right Column: MISSIONS --}}
        <div class="w-full lg:w-7/12 items-start">
            <div class="flex flex-col gap-8">
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-zinc-400 dark:text-zinc-500 text-xs font-bold uppercase tracking-[0.2em]">
                        Mission
                    </span>
                </div>
                <div class="space-y-0">
                    @if (isset($data['missions']) && count($data['missions']) > 0)
                        @foreach ($data['missions'] as $index => $mission)
                            <div
                                class="group flex flex-col md:flex-row md:items-baseline gap-4 md:gap-8 py-6 border-t border-zinc-100 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors duration-500">
                                <span class="text-sm font-mono text-accent-content font-bold">
                                    /{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <p
                                    class="text-lg md:text-xl text-zinc-600 dark:text-zinc-400 font-light leading-relaxed group-hover:text-zinc-900 dark:group-hover:text-zinc-200 transition-colors duration-300">
                                    {{ $mission['value'] ?? '' }}
                                </p>
                            </div>
                        @endforeach
                    @else
                        <div class="py-6 border-t border-dashed border-zinc-200 dark:border-zinc-800 text-zinc-400">
                            Belum ada data misi.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
