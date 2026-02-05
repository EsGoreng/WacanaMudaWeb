<x-layouts.app :title="__('Article & Blog | WMB')">

    <x-slot:secondary_nav>
        <flux:navbar.item :href="route('writings')" :current="request()->routeIs('writings')" wire:navigate>
            For you
        </flux:navbar.item>
        @auth
            <flux:navbar.item :href="route('writings.following')" :current="request()->routeIs('writings.following')"
                wire:navigate>
                Following
            </flux:navbar.item>
        @endauth
    </x-slot:secondary_nav>

    {{ $slot }}
</x-layouts.app>
