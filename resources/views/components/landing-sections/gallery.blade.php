@props(['data'])

<div id="gallery" class="mb-12 text-center">
    @if (isset($data['section_title']))
        <span
            class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">Documentation</span>
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

@if (isset($data['items']) && count($data['items']) > 0)
    <div x-data="{ limit: 9 }">

        <div class="bento-grid">
            @foreach ($data['items'] as $index => $item)
                @php
                    $extension = pathinfo($item['media_file'], PATHINFO_EXTENSION);
                    $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'webm']);
                    $isWide = $item['is_wide'] ?? false;
                    $bentoClass = $isWide
                        ? 'bento-item-wide'
                        : ($index === 0 || $index === 3
                            ? 'bento-item-large'
                            : ($index % 5 === 0
                                ? 'bento-item-tall'
                                : ''));
                @endphp

                <div x-show="{{ $index }} < limit" x-cloak x-transition.opacity.duration.500ms
                    class="group/item relative overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800 {{ $bentoClass }}">

                    @if ($isVideo)
                        <video
                            class="w-full h-full object-cover transition-transform duration-700 group-hover/item:scale-105 grayscale group-hover/item:grayscale-0"
                            autoplay muted loop playsinline>
                            <source src="{{ Storage::url($item['media_file']) }}" type="video/{{ $extension }}">
                        </video>
                    @else
                        <img src="{{ Storage::url($item['media_file']) }}"
                            alt="{{ $item['caption'] ?? 'Gallery Image' }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover/item:scale-105 grayscale group-hover/item:grayscale-0">
                    @endif

                    @if (!empty($item['caption']))
                        <div
                            class="rounded-xl absolute inset-x-0 bottom-0 opacity-0 group-hover/item:opacity-100 transition-all duration-500
               p-6 pt-32
               backdrop-blur-xl
               [mask-image:linear-gradient(to_top,black_40%,transparent)]
               [-webkit-mask-image:linear-gradient(to_top,black_40%,transparent)]">

                            <p
                                class="text-white text-sm font-medium translate-y-2 group-hover/item:translate-y-0 transition-transform duration-300 drop-shadow-md">
                                {{ $item['caption'] }}
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if (count($data['items']) > 9)
            <div class="mt-12 flex justify-center" x-show="limit < {{ count($data['items']) }}">
                <button @click="limit += 4" type="button"
                    class="group flex items-center gap-2 px-6 py-3 rounded-full border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all duration-300">
                    <span class="text-xs font-bold uppercase tracking-wider text-zinc-800 dark:text-zinc-200">Load
                        More</span>
                    <span
                        class="material-symbols-outlined text-sm transition-transform group-hover:translate-y-0.5">expand_more</span>
                </button>
            </div>
        @endif

    </div>
@else
    <div
        class="p-12 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl text-zinc-400 text-center text-sm">
        Belum ada dokumentasi.
    </div>
@endif
