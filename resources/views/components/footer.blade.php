<style>
    .big-text-clamp {
        font-size: clamp(3rem, 15vw, 16rem);
        line-height: 0.8;
        letter-spacing: -0.04em;
    }
</style>

<div class="w-full">
    <footer
        class="bg-white dark:bg-slate-950  w-full overflow-hidden shadow-2xl transition-colors duration-300 relative border-t border-zinc-200 dark:border-zinc-800">

        <div class="px-8 pt-12 md:px-16 md:pt-20 pb-4 max-w-[1400px] mx-auto">
            <div class="flex flex-col lg:flex-row justify-between gap-12 lg:gap-24 mb-12">

                <div class="flex flex-col space-y-8 lg:w-1/3">
                    <div class="flex flex-row space-x-4 items-center">
                        <img src="{{ asset('favicon.svg') }}"
                            class="h-8 w-8 transition-transform duration-300 group-hover:scale-105">
                        <p class="text-gray-500 italic dark:text-gray-400 max-w-sm">
                            #Dari<b>Kata</b>ke<b>Karya</b>
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a class="w-10 h-10 border border-gray-300 dark:border-gray-700 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-black dark:hover:text-white transition-colors"
                            href="https://instagram.com/wacanamuda" target="_blank">
                            <span><x-bi-instagram /></span>
                        </a>
                        <a class="w-10 h-10 border border-gray-300 dark:border-gray-700 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-black dark:hover:text-white transition-colors"
                            href="mailto:hello@wacanamuda.space">
                            <span><x-bi-envelope-fill /></span>
                        </a>
                    </div>
                </div>

                <div class="flex-1 grid grid-cols-2 md:grid-cols-3 gap-8 lg:gap-12">

                    <div class="flex flex-col space-y-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Explore</h3>
                        <ul class="space-y-3">
                            <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="{{ route('writings') }}">Writings</a></li>
                            <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="{{ route('forums') }}">Forums</a></li>
                            <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="{{ route('events') }}">Events</a></li>
                        </ul>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Account</h3>
                        <ul class="space-y-3">
                            @auth
                                <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                        href="{{ route('profile.show', auth()->user()->username ?? 'me') }}">My Profile</a>
                                </li>
                            @else
                                <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                        href="{{ route('login') }}">Sign In</a></li>
                                <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                        href="{{ route('register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Wacana</h3>
                        <ul class="space-y-3">
                            <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="#about">About Us</a></li>
                            {{-- <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="#">Guidelines</a></li>
                            <li><a class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                                    href="#">Privacy Policy</a></li> </ul> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full flex justify-center items-end leading-none select-none pointer-events-none pb-4 md:pb-0">
            <h1
                class="font-sans font-extrabold big-text-clamp text-gray-900 dark:text-white tracking-tighter opacity-100">
                {{ config('app.name', 'Wacana') }}
            </h1>
        </div>
    </footer>
</div>
