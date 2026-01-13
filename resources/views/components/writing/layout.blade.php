<x-layouts.app :title="__('Article & Blog | WMB')">
    {{-- <x-slot:secondary_nav>
        @can(['create posts'])
            <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Overview') }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('dashboard.writing')" :current="request()->routeIs('dashboard.writing')"
                wire:navigate>
                {{ __('Activities') }}
            </flux:navbar.item>
        @endcan
        @can(['validate members', 'manage events'])
            <flux:navbar.item :href="route('dashboard.event')" :current="request()->routeIs('dashboard.event')"
                wire:navigate>
                {{ __('Event') }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('dashboard.member')" :current="request()->routeIs('dashboard.member')"
                wire:navigate>
                {{ __('Validate Member') }}
            </flux:navbar.item>
        @endcan

    </x-slot:secondary_nav> --}}
    {{ $slot }}
</x-layouts.app>
