<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark overflow-x-hidden">

<head>
    @include('partials.head')
    @livewireStyles
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
                            <span>[ Wacana Muda Berkarya ]</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                        <h1 class="font-display text-6xl md:text-8xl font-bold leading-[0.9] tracking-tight mb-8">
                            DARI KATA<br />KE
                            <span class="text-accent">KARYA</span>
                        </h1>
                        <p
                            class="text-zinc-400 max-w-lg text-sm md:text-base leading-relaxed mb-10 border-l border-zinc-700 pl-4">
                            Wacana Muda Berkarya bukan tempat bagi yang
                            sudah sempurna, tapi ruang aman dan nyaman
                            untuk yang mau belajar bersama, Yang ingin
                            bersuara, berkarya, dan merasa.
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

            @foreach ($landingPage->content ?? [] as $block)
                @php $data = $block['data']; @endphp

                    <x-landing-section :id="$block['type']">
                        @if ($block['type'] === 'about_section')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

                            <div class="order-2 md:order-1 flex flex-col text-left">
                                @if (isset($data['section_title']))
                                    <h2
                                        class="font-serif italic text-5xl md:text-7xl font-bold  tracking-tighter mb-6 leading-[0.9]">
                                        {{ $data['section_title'] }}
                                    </h2>
                                @endif

                                <div
                                    class="prose dark:prose-invert max-w-none text-lg text-zinc-600 dark:text-zinc-400">
                                    {!! $data['content'] !!}
                                </div>
                            </div>

                            <div class="order-1 md:order-2 relative">
                                <div
                                    class="relative rounded-2xl overflow-hidden shadow-2xl border border-zinc-200 dark:border-zinc-800 group">
                                    @if (isset($data['image']))
                                        <img src="{{ Storage::url($data['image']) }}" alt="About Us"
                                            class="w-full h-full object-cover aspect-video transform transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <div
                                            class="bg-zinc-200 dark:bg-zinc-800 h-64 w-full flex items-center justify-center text-zinc-500">
                                            No Image Uploaded
                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>
                        @endif

                        @if ($block['type'] === 'vision_mission_section')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 mt-12 text-left">
                                
                                <div class="group relative p-8 rounded-3xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10 overflow-hidden">
                                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity transform rotate-12 translate-x-4 -translate-y-4">
                                        <span class="material-symbols-outlined text-9xl">visibility</span>
                                    </div>
                                    
                                    <div class="relative z-10">
                                        <h3 class="font-display text-3xl font-bold mb-6 text-accent">VISI</h3>
                                        <p class="text-xl md:text-2xl font-serif italic leading-relaxed text-zinc-700 dark:text-zinc-200">
                                            &ldquo;{{ $data['vision'] ?? '...' }}&rdquo;
                                        </p>
                                    </div>
                                </div>

                                <div class="group relative p-8 rounded-3xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10 overflow-hidden">
                                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity transform rotate-12 translate-x-4 -translate-y-4">
                                        <span class="material-symbols-outlined text-9xl">target</span>
                                    </div>

                                    <div class="relative z-10">
                                        <h3 class="font-display text-3xl font-bold mb-6 text-accent">MISI</h3>
                                        @if(isset($data['missions']) && count($data['missions']) > 0)
                                            <ul class="space-y-4">
                                                @foreach($data['missions'] as $mission)
                                                    <li class="flex items-start gap-4">
                                                        <span class="mt-1 flex-shrink-0 bg-accent/10 text-accent rounded-full p-1">
                                                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                                                        </span>
                                                        <span class="text-lg text-zinc-700 dark:text-zinc-300 leading-snug">
                                                            {{ $mission['value'] ?? '' }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        @endif

                        @if ($block['type'] === 'pillars_section')
                            @if (isset($data['items']))
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                                    @foreach ($data['items'] as $pillar)
                                        <div
                                            class="p-6 rounded-2xl bg-white dark:bg-white/5 border border-zinc-200 dark:border-white/10">
                                            <h3 class="font-display text-xl font-bold mb-3">{{ $pillar['title'] ?? '' }}
                                            </h3>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                                {{ $pillar['description'] ?? '' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        @if ($block['type'] === 'gallery_section')        
                                <div class="mb-12">
                                    @if (isset($data['section_title']))
                                        <h2 class="font-display text-5xl md:text-7xl font-black tracking-tighter mb-4 leading-[0.9]">
                                            {{ $data['section_title'] }}
                                        </h2>
                                    @endif
                                    @if (isset($data['section_subtitle']))
                                        <p class="text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto text-lg">
                                            {{ $data['section_subtitle'] }}
                                        </p>
                                    @endif
                                </div>

                                @if (isset($data['items']) && count($data['items']) > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 auto-rows-[300px]">
                                        @foreach ($data['items'] as $item)
                                            @php
                                                $extension = pathinfo($item['media_file'], PATHINFO_EXTENSION);
                                                $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'webm']);
                                                $isWide = $item['is_wide'] ?? false;
                                            @endphp

                                            <div class="group relative overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-white/5 {{ $isWide ? 'md:col-span-2' : 'md:col-span-1' }}">
                                                
                                                @if ($isVideo)
                                                    <video class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 " 
                                                        autoplay muted loop playsinline>
                                                        <source src="{{ Storage::url($item['media_file']) }}" type="video/{{ $extension }}">
                                                    </video>
                                                @else
                                                    <img src="{{ Storage::url($item['media_file']) }}" 
                                                        alt="{{ $item['caption'] ?? 'Gallery Image' }}"
                                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                                @endif

                                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 group-hover:backdrop-blur-xs rounded-2xl transition-opacity duration-300 flex items-end p-6">
                                                    @if(!empty($item['caption']))
                                                        <p class="text-white font-medium transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                            {{ $item['caption'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-12 border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl text-zinc-500">
                                        Belum ada dokumentasi yang diunggah.
                                    </div>
                                @endif

                        @endif

                        @if ($block['type'] === 'latest_writings_section')
                            {{-- Header Section --}}
                            <div class="mb-12 text-center md:text-left">
                                @if (isset($data['section_title']))
                                    <h2 class="font-display text-5xl md:text-7xl font-black tracking-tighter mb-4 leading-[0.9]">
                                        {{ $data['section_title'] }}
                                    </h2>
                                @endif
                                @if (isset($data['section_subtitle']))
                                    <p class="text-zinc-600 dark:text-zinc-400 max-w-2xl text-lg">
                                        {{ $data['section_subtitle'] }}
                                    </p>
                                @endif
                            </div>

                            {{-- Query Data Tulisan --}}
                            @php
                                $writings = \App\Models\Writing::query()
                                    ->where('status', 'Published')
                                    ->latest('published_at')
                                    ->take($data['limit'] ?? 4) // Default saya naikkan ke 4 agar genap di layout 2 kolom
                                    ->with(['user', 'categories']) 
                                    ->withCount(['likes', 'comments']) // Penting: Hitung jumlah like & komen untuk card
                                    ->get();
                            @endphp

                            @if($writings->count() > 0)
                                {{-- Menggunakan grid 1 kolom (Mobile) sampai 2 kolom (Desktop Besar) karena Card berbentuk Horizontal --}}
                                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 text-left">
                                    @foreach($writings as $writing)
                                        <x-writing.card :writing="$writing" />
                                    @endforeach
                                </div>
                            @else
                                <div class="py-12 text-center border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl">
                                    <p class="text-zinc-500 italic">Belum ada tulisan terbaru.</p>
                                </div>
                            @endif
                                
                            {{-- Button Action --}}
                            <div class="mt-12 flex justify-center">
                                <a href="{{ route('writings') }}" class="group bg-zinc-900 dark:bg-white text-white dark:text-black px-8 py-3 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-all flex items-center gap-2">
                                    Lihat Semua Artikel
                                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                        @endif

                        @if ($block['type'] === 'upcoming_events_section')
                            @livewire('landing-page.upcoming-events', ['data' => $block['data']])
                        @endif

                    </x-landing-section>
                
            @endforeach

        </div>
    </div>
    @include('components.footer')
    @livewireScripts
</body>

</html>
