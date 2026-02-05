<x-layouts.app :title="__('Forum | WMB')">
    <x-slot:secondary_nav>
        <flux:navbar.item :href="route('forums')" :current="request()->routeIs('forums')" wire:navigate>
            For you
        </flux:navbar.item>
        @auth
            <flux:navbar.item :href="route('forums.following')" :current="request()->routeIs('forums.following')"
                wire:navigate>
                Following
            </flux:navbar.item>
        @endauth
    </x-slot:secondary_nav>
    {{ $slot }}
</x-layouts.app>
