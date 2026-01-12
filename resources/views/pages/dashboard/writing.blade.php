<x-dashboard.layout>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-3">
            <div class="grid grid-cols-4 gap-4 mb-4">
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

            <div x-data="{ activeTab: 'all' }">
                <x-filament::tabs>
                    <x-filament::tabs.item @click="activeTab = 'all'" :active="false" icon="heroicon-m-pencil"
                        alpine-active="activeTab === 'all'">
                        All
                    </x-filament::tabs.item>

                    <x-filament::tabs.item @click="activeTab = 'published'" :active="false"
                        icon="heroicon-m-globe-alt" alpine-active="activeTab === 'published'">
                        Published
                    </x-filament::tabs.item>
                    <x-filament::tabs.item @click="activeTab = 'draft'" :active="false" icon="heroicon-m-clock"
                        alpine-active="activeTab === 'draft'">
                        Draft
                    </x-filament::tabs.item>

                    <x-filament::tabs.item @click="activeTab = 'archived'" :active="false"
                        icon="heroicon-m-archive-box" alpine-active="activeTab === 'archived'">
                        Archived
                    </x-filament::tabs.item>
                </x-filament::tabs>

                <div class="mt-4">
                    <div x-show="activeTab === 'all'" x-transition>
                        <div class="flex flex-col gap-6">
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 1 - Card A
                            </div>
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 1 - Card B
                            </div>
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 1 - Card C
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'published'" x-cloak x-transition>
                        <div class="flex flex-col gap-4">
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 2 - Coming Soon
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'draft'" x-cloak x-transition>
                        <div class="flex flex-col gap-4">
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 3 - Coming Soon
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTab === 'archived'" x-cloak x-transition>
                        <div class="flex flex-col gap-4">
                            <div
                                class="aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 p-6 flex items-center justify-center">
                                Content Tab 4 - Coming Soon
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
