<x-layouts.app.sidebar :title="$title ?? null">

    @if (isset($secondary_nav))
        <x-slot:secondary_nav>
            {{ $secondary_nav }}
        </x-slot:secondary_nav>
    @endif

    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
