<x-dashboard.layout>
    <div>
        <flux:heading size="xl" level="1">Manage Event</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Overview of all event</flux:text>

    </div>
    <flux:separator class="mb-6" variant="subtle" />
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-4">
            <livewire:events.table />
        </div>
        {{-- <div class="lg:col-span-1">
        </div> --}}
    </div>
</x-dashboard.layout>
