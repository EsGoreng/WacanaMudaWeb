<x-dashboard.layout>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-4 mb-4">
                <div
                    class="aspect-square rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 flex items-center justify-center">
                    Card A
                </div>
                <div
                    class="aspect-square rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 flex items-center justify-center">
                    Card B
                </div>
                <div
                    class="aspect-square rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 flex items-center justify-center">
                    Card C
                </div>
                <div
                    class="aspect-square rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 flex items-center justify-center">
                    Card D
                </div>
            </div>

            <div x-data="{ activeTab: 'writing' }">
                <x-filament::tabs>
                    <x-filament::tabs.item @click="activeTab = 'writing'" :active="false" icon="heroicon-m-pencil"
                        alpine-active="activeTab === 'writing'">
                        Writing
                    </x-filament::tabs.item>

                    <x-filament::tabs.item @click="activeTab = 'comment'" :active="false"
                        icon="heroicon-m-chat-bubble-left-ellipsis" alpine-active="activeTab === 'comment'">
                        Comment
                    </x-filament::tabs.item>
                </x-filament::tabs>

                <div class="mt-4">
                    <div x-show="activeTab === 'writing'" x-transition>
                        @livewire('writing-crud')
                    </div>

                    <div x-show="activeTab === 'comment'" x-cloak x-transition>
                        <div class="flex flex-col gap-4">
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 2 - Coming Soon
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-8 rounded-xl border border-neutral-200 dark:border-neutral-700 h-[300px] p-6">
                <h3 class="font-semibold mb-2">Sidebar Content</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">This sidebar stays sticky while scrolling</p>
            </div>
        </div>

    </div>
</x-dashboard.layout>
