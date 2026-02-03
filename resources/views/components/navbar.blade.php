<nav x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 50)"
    class="fixed top-0 md:top-4 inset-x-0 z-50 transition-all duration-300 ease-out p-0 md:p-6"
    :class="scrolled ? 'pt-0 md:pt-2' : ''">

    <div class="max-w-7xl mx-auto md:rounded-2xl transition-all duration-300 border-b md:border border-transparent"
        :class="[
            mobileMenuOpen ? 'bg-slate-950 text-white' : (scrolled ?
                'bg-white dark:bg-slate-950 border-zinc-200 dark:border-zinc-800' :
                'bg-transparent')
        ]">

        <div class="px-5 md:px-6 py-3">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <a href="#" class="cursor-pointer group flex items-center gap-3">
                    <img src="{{ asset('favicon.svg') }}"
                        class="h-8 w-8 transition-transform duration-300 group-hover:scale-105">
                    <span
                        class="font-display font-bold text-lg tracking-tight hidden md:block text-zinc-800 dark:text-white group-hover:text-accent-content transition-colors">WACANA
                        MUDA.</span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-1">
                    @php
                        $navItems = [
                            ['href' => '#about', 'label' => 'About'],
                            ['href' => '#vision', 'label' => 'Vision & Mission'],
                            ['href' => '#pillar', 'label' => 'Pillar'],
                            ['href' => '#gallery', 'label' => 'Gallery'],
                            ['href' => '#writing', 'label' => 'Writing'],
                            ['href' => '#event', 'label' => 'Event'],
                            ['href' => '#contact', 'label' => 'Contact Us'],
                        ];
                    @endphp
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] }}"
                            class="relative px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors duration-300">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-5 py-2 rounded-full bg-zinc-900 dark:bg-white text-white dark:text-black text-[11px] font-bold uppercase tracking-wider hover:opacity-90 transition-opacity">
                                Home
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-5 py-2 rounded-full border border-zinc-300 dark:border-white/20 text-zinc-800 dark:text-white text-[11px] font-bold uppercase tracking-wider hover:bg-zinc-100 dark:hover:bg-white/10 transition-colors">
                                Log in
                            </a>
                        @endauth
                    @endif

                    {{-- Mobile Toggle --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 text-zinc-800 dark:text-white">
                        <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                        <span class="material-symbols-outlined" x-show="mobileMenuOpen" x-cloak>close</span>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu Dropdown --}}
            <div x-show="mobileMenuOpen" x-cloak x-collapse
                class="md:hidden mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col gap-1">
                <a href="#about"
                    class="block py-3 px-4 text-sm font-semibold uppercase tracking-widest hover:bg-zinc-100 dark:hover:bg-zinc-900 rounded-lg">About</a>
                <a href="#pillars"
                    class="block py-3 px-4 text-sm font-semibold uppercase tracking-widest hover:bg-zinc-100 dark:hover:bg-zinc-900 rounded-lg">Pillars</a>
                <a href="#activities"
                    class="block py-3 px-4 text-sm font-semibold uppercase tracking-widest hover:bg-zinc-100 dark:hover:bg-zinc-900 rounded-lg">Activities</a>
            </div>
        </div>
    </div>
</nav>
