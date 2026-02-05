<nav x-data="{
    mobileMenuOpen: false,
    scrolled: false,
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark'));
if (darkMode) document.documentElement.classList.add('dark');

const mainContent = document.getElementById('main-content');
if (mainContent) {
    mainContent.addEventListener('scroll', (e) => {
        this.scrolled = mainContent.scrollTop > 20;
    });
}" @scroll.window="scrolled = (window.scrollY > 20)"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300 ease-out p-0"
    :class="!scrolled
        ?
        'md:top-4 md:p-8 md:mx-4 lg:top-4 lg:p-8' :
        'lg:top-4 lg:p-8 lg:mx-8'">

    <div class="max-w-full mx-auto transition-all duration-300 border-b border-transparent"
        :class="[
            mobileMenuOpen ? 'bg-slate-950 text-white' : (scrolled ?
                'bg-white/90 backdrop-blur-md dark:bg-zinc-900/90 border-zinc-200 dark:border-zinc-700 shadow-md' :
                'bg-transparent'),
        
            !scrolled ?
            'md:rounded-2xl md:border' :
            'lg:rounded-2xl lg:border'
        ]">

        <div class="px-5 lg:px-6 py-3">
            <div class="flex justify-between items-center">

                <a href="#" class="cursor-pointer group flex items-center gap-3">
                    <img src="{{ asset('favicon.svg') }}"
                        class="h-8 w-8 transition-transform duration-300 group-hover:scale-105">
                    <span
                        class="font-display font-bold text-lg tracking-tight hidden lg:block text-zinc-800 dark:text-white group-hover:text-accent-content transition-colors">WACANA
                        MUDA.</span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-1">
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

                <div class="flex items-center gap-3">

                    <button @click="toggleTheme()"
                        class="p-2 rounded-full text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/10 transition-colors focus:outline-none"
                        :class="mobileMenuOpen ? 'text-white hover:bg-white/10' : ''" title="Toggle Dark Mode">
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg x-show="!darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-5 py-2 rounded-full bg-zinc-900 dark:bg-white text-white dark:text-black text-[11px] font-bold uppercase tracking-wider hover:opacity-90 transition-opacity">
                                Home
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="hidden lg:block px-5 py-2 rounded-full border border-zinc-300 dark:border-white/20 text-zinc-800 dark:text-white text-[11px] font-bold uppercase tracking-wider hover:bg-zinc-100 dark:hover:bg-white/10 transition-colors">
                                Log in
                            </a>
                            <a href="{{ route('login') }}" class="lg:hidden p-2 text-zinc-800 dark:text-white"
                                :class="mobileMenuOpen ? 'text-white' : ''">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                            </a>
                        @endauth
                    @endif

                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden p-2 text-zinc-800 dark:text-white" :class="mobileMenuOpen ? 'text-white' : ''">
                        <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                        <span class="material-symbols-outlined" x-show="mobileMenuOpen" x-cloak>close</span>
                    </button>
                </div>
            </div>

            <div x-show="mobileMenuOpen" x-cloak x-collapse
                class="lg:hidden mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-col gap-1">
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}"
                        class="block py-3 px-4 text-sm font-semibold uppercase tracking-widest hover:bg-zinc-100 dark:hover:bg-zinc-900 rounded-lg">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
