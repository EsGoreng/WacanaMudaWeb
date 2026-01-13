<x-writing.layout>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3">
            <livewire:writing-list />
        </div>
        <div class="lg:col-span-1">
            <div class="sticky top-8 rounded-xl border border-neutral-200 dark:border-neutral-700 h-[300px] p-6">
                <h3 class="font-semibold mb-2">Sidebar Content</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">This sidebar stays sticky while scrolling</p>
            </div>
        </div>
    </div>
</x-writing.layout>
