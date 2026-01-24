<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wacana Muda Berkarya</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script>
    <script>
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smooth: true,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 2rem;
        }

        /* Smooth scroll dengan easing */
        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }

            * {
                scroll-behavior: smooth;
                scroll-snap-type: y proximity;
            }
        }

        /* Custom smooth scrolling dengan CSS */
        body {
            scroll-behavior: smooth;
        }

        .text-outline-white {
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.2);
            color: transparent;
        }

        .section-card {
            border-radius: 1rem;
            overflow: hidden;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }

        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
</head>

<body class="overflow-x-hidden w-full relative">
    <div
        class="bg-slate-50 dark:bg-slate-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased selection:bg-accent selection:text-white px-4 py-4 md:px-6 md:py-6">
        <nav
            class="fixed top-10 inset-x-10 border-2 border-slate-700/30 rounded-2xl z-50 mix-blend-difference backdrop-blur-md text-white px-4 md:px-8 py-4 flex justify-between items-center pointer-events-none">
            <div class="pointer-events-auto cursor-pointer">
                <div class="flex flex-row items-center gap-4">
                    <img src="{{ asset('favicon.svg') }}" class="h-8 w-8">
                    <span class="font-display font-bold text-xl tracking-tighter hidden md:block">WACANA MUDA.</span>
                </div>
            </div>
            <div class="pointer-events-auto cursor-pointer flex gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}"
                            class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-xs font-medium uppercase hover:bg-white hover:text-black transition-colors">
                            Home
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-xs font-medium uppercase hover:bg-white hover:text-black transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-xs font-medium uppercase hover:bg-white hover:text-black transition-colors">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
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
                    <div class="max-w-3xl pt-20">
                        <div class="flex items-center gap-2 mb-6 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                            <span>[ The PHP Framework for Web Artisans ]</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                        <h1 class="font-display text-6xl md:text-8xl font-bold leading-[0.9] tracking-tight mb-8">
                            WACANA MUDA<br />
                            <span class="text-accent">BERKARYA</span>
                        </h1>
                        <p
                            class="text-zinc-400 max-w-md text-sm md:text-base leading-relaxed mb-10 border-l border-zinc-700 pl-4">
                            Laravel has an incredibly rich ecosystem combining branding, web development, and powerful
                            backend tools into a single evolving framework.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a class="group bg-white text-black px-6 py-3 rounded text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-colors flex items-center gap-2"
                                href="https://laravel.com/docs" target="_blank">
                                Documentation
                                <span
                                    class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                            <a class="group border border-white/20 hover:border-white px-6 py-3 rounded text-xs font-bold uppercase tracking-wider text-white transition-colors flex items-center gap-2"
                                href="https://laracasts.com" target="_blank">
                                Laracasts
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

            <section class="section-card py-12 bg-slate-50 dark:bg-slate-900 border-b border-zinc-200/0">
                <div class="container mx-auto px-6 md:px-12 mb-8">
                    <div class="flex items-center gap-2 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                        <span>[ Trusted By Thousands ]</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>
                <div class="w-full overflow-hidden whitespace-nowrap py-4 group">
                    <div
                        class="inline-flex animate-marquee gap-16 items-center grayscale opacity-60 hover:opacity-100 transition-opacity duration-300">
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">LARAVEL</span>
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">ELOQUENT</span>
                        <div class="flex items-center gap-2 mx-8 text-black dark:text-white"><span
                                class="material-symbols-outlined">radio_button_checked</span><span
                                class="font-bold font-sans">BLADE</span></div>
                        <span
                            class="text-2xl font-black font-display text-black dark:text-white mx-8 tracking-tighter">ARTISAN®</span>
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">Forge</span>
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">Vapor</span>
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">LARAVEL</span>
                        <span class="text-2xl font-bold font-display text-black dark:text-white mx-8">ELOQUENT</span>
                        <div class="flex items-center gap-2 mx-8 text-black dark:text-white"><span
                                class="material-symbols-outlined">radio_button_checked</span><span
                                class="font-bold font-sans">BLADE</span></div>
                        <span
                            class="text-2xl font-black font-display text-black dark:text-white mx-8 tracking-tighter">ARTISAN®</span>
                    </div>
                </div>
            </section>

            <section class="section-card py-24 bg-slate-50 dark:bg-slate-900 text-black dark:text-white">
                <div class="container mx-auto px-6 md:px-12">
                    <div class="flex justify-between items-end mb-16">
                        <h2
                            class="font-display text-5xl md:text-6xl font-medium tracking-tight flex items-center gap-4">
                            Key Features
                            <span class="material-symbols-outlined text-4xl transform rotate-45">arrow_downward</span>
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-2/3 w-48 h-48 opacity-90 group-hover:scale-110 transition-transform duration-500">
                                <span class="material-symbols-outlined text-[120px] text-accent">terminal</span>
                            </div>
                            <h3 class="text-xl font-display font-medium relative z-10">Elegant Syntax</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10">Beautiful, expressive
                                code that's a joy to
                                write</p>
                        </div>
                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-2/3 w-48 h-48 opacity-90 group-hover:scale-110 transition-transform duration-500">
                                <span class="material-symbols-outlined text-[120px] text-accent">architecture</span>
                            </div>
                            <h3 class="text-xl font-display font-medium relative z-10">MVC Architecture</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10">Clean separation of
                                concerns for
                                maintainable apps</p>
                        </div>
                        <div
                            class="group relative bg-white dark:bg-slate-800 rounded-lg p-8 h-[400px] flex flex-col justify-end overflow-hidden hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors border border-zinc-200/50 dark:border-zinc-700">
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-2/3 w-48 h-48 opacity-90 group-hover:scale-110 transition-transform duration-500">
                                <span class="material-symbols-outlined text-[120px] text-accent">database</span>
                            </div>
                            <h3 class="text-xl font-display font-medium relative z-10">Eloquent ORM</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 relative z-10">Work with databases
                                using
                                beautiful,
                                expressive syntax</p>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="section-card py-32 bg-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden">
                <div class="container mx-auto px-6 md:px-12 relative z-10">
                    <div
                        class="flex justify-center items-center gap-2 mb-8 text-xs tracking-[0.2em] text-zinc-400 uppercase">
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                        <span>[ Get Started Today ]</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </div>
                    <h2 class="font-display text-6xl md:text-8xl font-black tracking-tighter mb-8 leading-[0.9]">
                        LET'S BUILD <br />
                        SOMETHING GREAT
                        <span class="inline-block align-middle ml-2 text-6xl md:text-8xl">🚀</span>
                    </h2>
                    <div class="flex justify-center gap-4 mt-12">
                        <a class="bg-slate-200 dark:bg-slate-700 text-black dark:text-white px-8 py-4 rounded text-xs font-bold uppercase tracking-wider hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors flex items-center gap-2"
                            href="https://laravel.com/docs" target="_blank">
                            Read Docs
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                        <a class="bg-accent text-white px-8 py-4 rounded text-xs font-bold uppercase tracking-wider hover:bg-brand-hover transition-colors flex items-center gap-2 shadow-lg shadow-accent/30"
                            href="https://cloud.laravel.com" target="_blank">
                            Deploy Now
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </div>
    @include('components.footer')
</body>

</html>
