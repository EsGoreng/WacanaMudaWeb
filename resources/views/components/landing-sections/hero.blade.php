<header
    class="relative min-h-[94vh] flex items-center overflow-hidden md:rounded-2xl transition-all duration-500 bg-white dark:bg-slate-950">

    {{-- Background Image Section --}}
    {{-- Mengakses variabel scrollY dari parent scope (body) --}}
    <div class="absolute inset-0 z-0 parallax-bg" :style="'transform: translateY(' + (scrollY * 0.3) + 'px)'">
        <img alt="Hero section dark"
            class="hidden dark:block w-full h-[120%] object-cover scale-105 object-[80%_center] md:object-center opacity-60"
            src="{{ asset('images/hero_section_desktop_dark.png') }}" />

        <img alt="Hero section light"
            class="block dark:hidden w-full h-[120%] object-cover scale-105 object-[80%_center] md:object-center opacity-70"
            src="{{ asset('images/hero_section_desktop_light.png') }}" />
    </div>

    {{-- Overlay Utama --}}
    <div
        class="absolute inset-0 bg-gradient-to-r from-white/60 via-white/20 to-transparent dark:from-slate-950/80 dark:via-slate-950/40 dark:to-transparent z-[1]">
    </div>

    {{-- Bottom Fade Gradient --}}
    <div class="absolute inset-x-0 bottom-0 h-32 z-[2] bg-gradient-to-t from-white dark:from-slate-950 to-transparent">
    </div>

    {{-- Content --}}
    <div class="container mx-auto px-6 md:px-12 lg:px-20 relative z-10 pt-20">
        <div class="max-w-4xl">
            {{-- Badge --}}
            <div
                class="inline-flex items-center gap-3 mb-8 px-4 py-2 rounded-full border border-zinc-200 dark:border-white/20 bg-white/80 dark:bg-slate-900 backdrop-blur-sm">
                <span class="text-[10px] tracking-[0.2em] text-zinc-600 dark:text-zinc-300 uppercase font-bold">
                    Wacana Muda Berkarya
                </span>
            </div>

            {{-- Main Title --}}
            <h1 class="font-display text-5xl sm:text-7xl md:text-8xl font-bold leading-[0.9] tracking-tight mb-8">
                <span class="block text-zinc-900 dark:text-white">DARI KATA</span>
                <span class="block text-zinc-500 dark:text-zinc-400">KE <span
                        class="text-accent relative inline-block">KARYA</span></span>
            </h1>

            {{-- Description --}}
            <p class="text-zinc-700 dark:text-zinc-300 max-w-lg text-lg leading-relaxed mb-10 font-light">
                Wacana Muda Berkarya bukan tempat bagi yang sudah sempurna, tapi ruang aman untuk yang mau belajar
                bersama.
            </p>

            {{-- CTA --}}
            <div class="flex flex-wrap gap-4">
                <a class="bg-zinc-900 dark:bg-white text-white dark:text-black px-8 py-4 rounded-full text-xs font-bold uppercase tracking-wider hover:scale-105 transition-transform flex items-center gap-2"
                    href="{{ route('writings') }}">
                    <span>Explore</span>
                    <span class="material-symbols-outlined text-sm">north_east</span>
                </a>
            </div>
        </div>
    </div>
</header>
