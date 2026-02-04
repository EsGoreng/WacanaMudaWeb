<x-dashboard.layout>
    <flux:heading size="xl" level="1">Manage Members</flux:heading>
    <flux:text class="mb-6 mt-2 text-base">Overview of all registered accounts</flux:text>

    <flux:separator class="mb-6" variant="subtle" />

    <div class="mt-6">
        <livewire:members.table />
    </div>
</x-dashboard.layout>
