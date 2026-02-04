@props(['data'])

{{-- Header Section --}}
<div id="contact" class="container mx-auto mb-10 md:mb-16">
    <div class="flex flex-col md:flex-row justify-between items-end gap-6">
        <div class="max-w-3xl">
            @if (isset($data['section_title']))
                <span class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">
                    Contact
                </span>
                <h2
                    class="font-display text-4xl md:text-6xl font-black tracking-tight text-zinc-900 dark:text-white mb-4">
                    {{ $data['section_title'] }}
                </h2>
            @endif
            @if (isset($data['section_subtitle']))
                <p class="text-zinc-500 dark:text-zinc-400 text-lg leading-relaxed">
                    {{ $data['section_subtitle'] }}
                </p>
            @endif
        </div>
    </div>
</div>

{{-- Bento Grid Content --}}
<div class="container">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 h-auto ">

        {{-- 1. MAPS CARD --}}
        <div
            class="lg:col-span-2 relative rounded-3xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 group">
            @if (!empty($data['google_maps_code']))
                <div
                    class="w-full h-full min-h-[300px] [&_iframe]:!w-full [&_iframe]:!h-full [&_iframe]:!border-0 grayscale group-hover:grayscale-0 transition-all duration-700 ease-in-out">
                    {!! $data['google_maps_code'] !!}
                </div>
            @else
                <div
                    class="w-full h-full min-h-[300px] flex items-center justify-center text-zinc-400 bg-zinc-50 dark:bg-zinc-900">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">map</span> Map belum disematkan
                    </span>
                </div>
            @endif
        </div>

        {{-- 2. INFO & INSTAGRAM --}}
        <div class="flex flex-col gap-6 lg:gap-8 h-full">
            <div
                class="flex-1 bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-zinc-200 dark:border-zinc-800 flex flex-col justify-center gap-6">
                <div>
                    <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-2 block">Visit Us</span>
                    <p class="text-zinc-800 dark:text-zinc-200 font-medium leading-relaxed whitespace-pre-line">
                        {{ $data['address'] ?? '-' }}
                    </p>
                </div>
                <div class="w-full h-px bg-zinc-100 dark:bg-zinc-800"></div>
                <div class="flex flex-col gap-4">
                    <a href="mailto:{{ $data['email'] ?? '#' }}" class="flex items-center gap-3 group/link">
                        <div
                            class="w-10 h-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover/link:bg-zinc-200 dark:group-hover/link:bg-zinc-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">mail</span>
                        </div>
                        <span
                            class="text-sm font-bold text-zinc-700 dark:text-zinc-300 group-hover/link:text-accent transition-colors">
                            {{ $data['email'] ?? '-' }}
                        </span>
                    </a>
                    <a href="tel:{{ $data['phone'] ?? '#' }}" class="flex items-center gap-3 group/link">
                        <div
                            class="w-10 h-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 group-hover/link:bg-zinc-200 dark:group-hover/link:bg-zinc-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">call</span>
                        </div>
                        <span
                            class="text-sm font-bold text-zinc-700 dark:text-zinc-300 group-hover/link:text-accent transition-colors">
                            {{ $data['phone'] ?? '-' }}
                        </span>
                    </a>
                </div>
            </div>

            @if (!empty($data['instagram']))
                <a href="{{ $data['instagram'] }}" target="_blank"
                    class="relative group overflow-hidden rounded-3xl p-8 flex items-center justify-between transition-transform hover:scale-[1.02] active:scale-[0.98]">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500 opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10 text-white">
                        <span class="block text-[10px] font-bold uppercase tracking-widest opacity-80 mb-1">Social
                            Media</span>
                        <span class="font-display text-2xl font-bold">Instagram</span>
                    </div>
                    <div
                        class="relative z-10 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white group-hover:bg-white group-hover:text-pink-600 transition-all">
                        <span class="material-symbols-outlined text-2xl">arrow_outward</span>
                    </div>
                </a>
            @endif
        </div>
    </div>
</div>
