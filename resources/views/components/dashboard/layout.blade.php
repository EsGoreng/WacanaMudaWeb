<x-layouts.app :title="__('Dashboard | WMB')">
    <x-slot:secondary_nav>
        @can(['create posts'])
            <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                My Profile
            </flux:navbar.item>
            <flux:navbar.item :href="route('dashboard.writing')" :current="request()->routeIs('dashboard.writing')"
                wire:navigate>
                Activities
            </flux:navbar.item>
            <flux:navbar.item :href="route('dashboard.mybookmark')" :current="request()->routeIs('dashboard.mybookmark')"
                wire:navigate>
                My Bookmark
            </flux:navbar.item>
        @endcan
        @can(['manage events'])
            <flux:navbar.item :href="route('dashboard.event')" :current="request()->routeIs('dashboard.event')"
                wire:navigate>
                Event
            </flux:navbar.item>
        @endcan
        @can(['manage events', 'setting landingpage'])
            <flux:navbar.item :href="route('dashboard.member')" :current="request()->routeIs('dashboard.member')"
                wire:navigate>
                User Management
            </flux:navbar.item>
            <flux:navbar.item :href="route('dashboard.landingsetting')"
                :current="request()->routeIs('dashboard.landingsetting')" wire:navigate>
                Landing Page
            </flux:navbar.item>
        @endcan

    </x-slot:secondary_nav>
    {{ $slot }}
</x-layouts.app>
