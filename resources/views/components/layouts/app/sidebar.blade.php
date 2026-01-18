<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="bg-white dark:bg-zinc-900">

    <x-star-background />

    <div class="flex h-screen overflow-hidden relative">
        <flux:sidebar sticky collapsible="mobile"
            class="border-e border-zinc-200 from-slate-100 to-slate-200 dark:border-slate-800 antialiased bg-linear-to-t dark:bg-linear-to-t dark:from-slate-950 dark:to-slate-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="gap-3">
                <flux:sidebar.group class="grid">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')"
                        wire:navigate>
                        {{ __('Home') }}
                    </flux:sidebar.item>
                    @can(['create posts'])
                        <flux:sidebar.item icon="computer-desktop" :href="route('dashboard')"
                            :current="request()->routeIs('dashboard*')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>

                <flux:separator variant="subtle" />

                <flux:heading>Main Menu</flux:heading>
                <flux:sidebar.group class="grid">
                    <flux:sidebar.item icon="book-open" :href="route('writing')"
                        :current="request()->routeIs('writing*')" wire:navigate>
                        {{ __('Article & Blog') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="chat-bubble-left-right" :href="route('forum')"
                        :current="request()->routeIs('forum*')" wire:navigate>
                        {{ __('Forum') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('home')" :current="request()->routeIs('events')"
                        wire:navigate>
                        {{ __('Event') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />
            <flux:separator variant="subtle" />
            <flux:sidebar.group heading="{{ __('Contact Us') }}">
                <flux:sidebar.nav>
                    <flux:sidebar.item href="https://www.instagram.com/wacanamuda/" target="_blank">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4">
                                <path
                                    d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Z" />
                                <path
                                    d="M12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0 1.5a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7Z" />
                                <circle cx="17.25" cy="6.75" r="1" />
                            </svg>
                        </x-slot:icon>
                        {{ __('Instagram') }}
                    </flux:sidebar.item>
                </flux:sidebar.nav>
            </flux:sidebar.group>

            @auth
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @endauth

            @guest
                <div class="grid grid-cols-2 gap-3 w-full">
                    <flux:button href="{{ route('login') }}" variant="subtle">Login</flux:button>
                    <flux:button href="{{ route('register') }}" variant="subtle">Register</flux:button>
                </div>
            @endguest
        </flux:sidebar>

        <div class="min-h-screen flex flex-1 flex-col overflow-x-hidden" x-data="{
            showTopBar: true,
            lastScrollY: 0,
            handleScroll(e) {
                const currentScrollY = e.target.scrollTop;
        
                if (currentScrollY > this.lastScrollY && currentScrollY > 10) {
                    this.showTopBar = false;
                } else {
                    this.showTopBar = true;
                }
                this.lastScrollY = currentScrollY;
            }
        }">
            <flux:header
                class="sticky top-0 z-10 block! border-b border-zinc-200 dark:border-slate-800 bg-zinc-100/90 dark:bg-zinc-900/80 backdrop-blur-md transition-all duration-300">

                <div class="overflow-hidden transition-all duration-300 ease-in-out lg:!h-auto lg:!opacity-100"
                    @if (isset($secondary_nav)) :class="showTopBar ? 'max-h-20 opacity-100' : 'max-h-0 opacity-0'" @endif>
                    <flux:navbar class="lg:hidden w-full pt-3">
                        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                        <flux:spacer />
                        <flux:dropdown position="top" align="end">
                            <flux:profile :initials="auth()->user() ? auth()->user()->initials() : 'G'" />
                            <flux:menu>
                                @auth
                                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                        class="w-full cursor-pointer">
                                        {{ __('Log Out') }}
                                    </flux:menu.item>
                                @endauth
                                @guest
                                    <flux:menu.item as="button" type="submit" href="{{ route('login') }}"
                                        icon="arrow-left-start-on-rectangle" class="w-full cursor-pointer">
                                        {{ __('Log In') }}
                                    </flux:menu.item>
                                    <flux:menu.item as="button" type="submit" href="{{ route('register') }}"
                                        icon="clipboard-document-list" class="w-full cursor-pointer">
                                        {{ __('Register') }}
                                    </flux:menu.item>
                                @endguest
                            </flux:menu>
                        </flux:dropdown>
                    </flux:navbar>
                </div>

                @if (isset($secondary_nav))
                    <flux:navbar scrollable class="py-2">
                        {{ $secondary_nav }}
                    </flux:navbar>
                @endif

            </flux:header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden" @scroll="handleScroll($event)">
                <div
                    class="min-h-full bg-white dark:bg-transparent dark:bg-gradient-to-b dark:from-page-gray-950/50 dark:to-page-gray-950/90">
                    {{ $slot }}
                </div>


                @include('components.footer')
            </main>

        </div>
    </div>
    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
    @fluxScripts
</body>

</html>
