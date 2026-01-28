<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark overflow-x-hidden">

<head>
    @include('partials.head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        .section-card {
            border-radius: 1rem;
            overflow: hidden;
        }
    </style>
</head>

<body class="overflow-x-hidden w-full relative">
    <div
        class="bg-slate-50 dark:bg-slate-950/50 text-zinc-900 dark:text-zinc-100 font-sans antialiased selection:bg-accent selection:text-white px-4 py-4 md:px-6 md:py-6">

        <nav x-data="{ mobileMenuOpen: false }"
            class="fixed top-10 inset-x-10 z-50 transition-all duration-300 ease-in-out backdrop-blur-md rounded-xl">

            <div class="border-2 border-slate-700/30 text-white px-4 md:px-8 py-4 bg-slate-900/20 transition-all duration-300 rounded-xl"
                :class="mobileMenuOpen ? 'bg-slate-950/90' : ''">

                <div class="flex justify-between items-center">
                    <a href="#" class="cursor-pointer">
                        <div class="flex flex-row items-center gap-4">
                            <img src="{{ asset('favicon.svg') }}" class="h-8 w-8">
                            <span class="font-display font-bold text-xl tracking-tighter hidden md:block">WACANA
                                MUDA.</span>
                        </div>
                    </a>

                    <div class="hidden md:flex items-center gap-8">
                        <a href="#about"
                            class="text-xs font-bold uppercase tracking-widest hover:text-accent transition-colors">About</a>
                        <a href="#pillars"
                            class="text-xs font-bold uppercase tracking-widest hover:text-accent transition-colors">Pillars</a>
                        <a href="#activities"
                            class="text-xs font-bold uppercase tracking-widest hover:text-accent transition-colors">Activities</a>
                        <a href="#events"
                            class="text-xs font-bold uppercase tracking-widest hover:text-accent transition-colors">Events</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex gap-2">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}"
                                        class="bg-white/10 px-4 py-2 rounded-full text-xs font-medium uppercase hover:bg-white hover:text-black transition-colors">Home</a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="bg-white/10 px-4 py-2 rounded-full text-xs font-medium uppercase hover:bg-white hover:text-black transition-colors">Log
                                        in</a>
                                @endauth
                            @endif
                        </div>

                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 text-white hover:bg-white/10 transition-all relative z-50 rounded-xl">
                            <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                            <span class="material-symbols-outlined" x-show="mobileMenuOpen" x-cloak>close</span>
                        </button>
                    </div>
                </div>

                <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="md:hidden mt-6 pb-4 border-t border-white/10 pt-6 flex flex-col gap-6 text-center">

                    <a @click="mobileMenuOpen = false" href="#about"
                        class="text-sm font-bold uppercase tracking-widest hover:text-accent">About</a>
                    <a @click="mobileMenuOpen = false" href="#pillars"
                        class="text-sm font-bold uppercase tracking-widest hover:text-accent">Pillars</a>
                    <a @click="mobileMenuOpen = false" href="#activities"
                        class="text-sm font-bold uppercase tracking-widest hover:text-accent">Activities</a>
                    <a @click="mobileMenuOpen = false" href="#events"
                        class="text-sm font-bold uppercase tracking-widest hover:text-accent">Events</a>
                </div>
            </div>
        </nav>
        <div class="space-y-4 md:space-y-6 max-w-[1920px] mx-auto">
            <header class="section-card relative min-h-[95vh] flex items-center bg-slate-950 text-white pt-20">
                <div class="absolute inset-0 z-0">
                    <img alt="Hero section" class="w-full h-full object-cover opacity-60 mix-blend-hard-light"
                        src="{{ asset('images/hero_section_desktop.png') }}" />
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/40 to-transparent"></div>
                </div>
                <div
                    class="container mx-auto px-6 md:px-12 relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12 h-full items-center">
                    <div class="max-w-3xl">
                        <div class="flex items-center gap-2 mb-6 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                            <span>[ Dari <b>Kata</b> ke <b>Karya</b> ]</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                        <h1 class="font-display text-6xl md:text-8xl font-bold leading-[0.9] tracking-tight mb-8">
                            WACANA MUDA<br />
                            <span class="text-accent">BERKARYA</span>
                        </h1>
                        <p
                            class="text-zinc-400 max-w-lg text-sm md:text-base leading-relaxed mb-10 border-l border-zinc-700 pl-4">
                            Wacana Muda Berkarya bukan tempat bagi yang
                            sudah sempurna, tapi ruang aman dan nyaman
                            untuk yang mau belajar bersama. Yang ingin
                            bersuara, berkarya, dan merasa.
                            Maka dari itu mari melangkah Bersama. Entah lewat
                            Ruang Kata, Jejak Karya, atau Jelajah Rasa. Jalanmu
                            bisa dimulai dari sini.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a class="group bg-white text-black px-6 py-3 rounded text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-colors flex items-center gap-2"
                                href="#about">
                                Explore
                                <span
                                    class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-8 right-6 md:right-12 text-xs text-zinc-600 font-mono">
                    v1.0
                </div>
            </header>

            <section id="about"
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <div
                        class="flex justify-center items-center gap-2 mb-8 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                        <span>[ Lorem Ipsum ]</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </div>
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        ABOUT US
                    </h2>
                </div>
            </section>

            <section id="pillars" class="section-card py-24 bg-slate-50 dark:bg-slate-900 text-black dark:text-white">
                <div class="container mx-auto px-6 md:px-12">
                    <div class="flex justify-between items-end mb-16">
                        <h2
                            class="font-display text-5xl md:text-6xl font-medium tracking-tight flex items-center gap-4">
                            3 Pillars
                            <span class="material-symbols-outlined text-4xl transform rotate-45">arrow_downward</span>
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <h3 class="text-xl font-display font-medium relative z-10">WMB Ruang Kata</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10">A place where
                                <b>ideas</b> are born, discourse is <b>nurtured</b>, and reason is <b>tested</b>.
                                Here, we converse <b>not to win</b>, but <b>to understand</b>.
                                Discussions, forums, and a space for exchanging perspectives.
                                This is a space for words that truly matter.
                        </div>

                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <h3 class="text-xl font-display font-medium relative z-10">WMB Jelajah Rasa</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10"><b>Exploring</b>
                                places, time, and emotions that are <b>not written in books</b>. We wander not only to
                                see, but also to <b>feel</b> and <b>understand</b>. Every step is a lesson,
                                and every journey deserves to be <b>reflected upon</b>.
                            </p>
                        </div>
                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <h3 class="text-xl font-display font-medium relative z-10">WMB Jejak Karya</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10">Not content with <b>
                                    merely having a voice</b>, we also seek to
                                <b>touch reality</b>. Through action and service, we learn to leave
                                meaningful footprints in our surroundings.
                                Because <b>work is not about scale, but about impact</b>.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="activities"
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <div
                        class="flex justify-center items-center gap-2 mb-8 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                        <span>[ Lorem Ipsum ]</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </div>
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        WHAT ARE WE DOING
                    </h2>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        PRINCIPLE
                    </h2>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        LATEST WRITING CONTENT
                    </h2>
                </div>
            </section>

            <section id="events"
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <div
                        class="flex justify-center items-center gap-2 mb-8 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                        <span>[ Lorem Ipsum ]</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </div>
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        OUR EVENT
                    </h2>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        FOUNDER
                    </h2>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        FEEDBACK
                    </h2>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        EXPLORE APP
                    </h2>
                </div>
            </section>

        </div>
    </div>
    @include('components.footer')
</body>

</html>
