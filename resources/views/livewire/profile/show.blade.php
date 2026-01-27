<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <div class="lg:col-span-1">
        <livewire:profile.card :user="$user" />
    </div>

    <div class="lg:col-span-3">
        <div class="mb-4">
            @livewire('dashboard.stats-overview', ['user' => $user])
        </div>

        <div x-data="{ activeTab: 'writing' }">
            <x-filament::tabs>
                <x-filament::tabs.item @click="activeTab = 'writing'" :active="false" icon="heroicon-m-pencil"
                    alpine-active="activeTab === 'writing'">
                    Writing
                </x-filament::tabs.item>

                <x-filament::tabs.item @click="activeTab = 'forum'" :active="false"
                    icon="heroicon-m-chat-bubble-left-ellipsis" alpine-active="activeTab === 'forum'">
                    Forum
                </x-filament::tabs.item>
            </x-filament::tabs>

            <div class="mt-4">
                <div x-show="activeTab === 'writing'" x-transition>
                    <div class="flex flex-col gap-4">
                        @forelse ($writings as $writing)
                            <div wire:key="writing-{{ $writing->writing_id }}">
                                <x-writing.card :writing="$writing" />
                                @if (!$loop->last)
                                    <div class="mt-6 mb-2">
                                        <flux:separator variant="subtle" />
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div
                                class="bg-white dark:bg-zinc-800/50 p-8 rounded-xl text-center border border-zinc-200 dark:border-zinc-800">
                                <div class="text-zinc-500 dark:text-zinc-400">
                                    <x-bi-pen class="w-12 h-12 mx-auto mb-3 opacity-50" />
                                    <p class="font-medium">Belum ada tulisan yang dipublikasikan.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $writings->links() }}
                    </div>
                </div>

                <div x-show="activeTab === 'forum'" x-cloak x-transition>
                    <div class="flex flex-col gap-4">
                        @forelse ($forums as $forum)
                            <x-forum.card :forum="$forum" />
                        @empty
                            <div
                                class="bg-white dark:bg-zinc-800/50 p-8 rounded-xl text-center border border-zinc-200 dark:border-zinc-800">
                                <div class="text-zinc-500 dark:text-zinc-400">
                                    <x-bi-chat-left-text class="w-12 h-12 mx-auto mb-3 opacity-50" />
                                    <p class="font-medium">Belum ada diskusi forum yang dibuat.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    <x-filament-actions::modals />
    <x-event.event-modal wire:model.live="isModalOpen" maxWidth="5xl">
        @if ($selectedEvent)
            <x-event.detail :event="$selectedEvent" :is-bookmarked="$isBookmarked" />
        @endif
    </x-event.event-modal>
</div>
