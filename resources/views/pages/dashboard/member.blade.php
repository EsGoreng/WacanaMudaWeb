<x-dashboard.layout>
    <flux:heading size="xl" level="1">{{ __('Good afternoon') }}, {{ auth()->user()->name }}</flux:heading>
    <flux:text class="mb-6 mt-2 text-base">{{ __("Here's what's new today") }}</flux:text>
    <flux:separator variant="subtle" />
    <div class="flex flex-col gap-4 mt-6">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
    </div>
</x-dashboard.layout>
