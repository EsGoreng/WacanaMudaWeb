<div x-data="{ activeTab: 'writing' }">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">My Bookmarks</h2>
        <p class="text-zinc-500 text-sm mt-1">Kelola semua konten yang telah Anda simpan di satu tempat.</p>
    </div>

    <x-filament::tabs>
        <x-filament::tabs.item @click="activeTab = 'writing'" :active="false" icon="heroicon-m-pencil"
            alpine-active="activeTab === 'writing'">
            Writings
        </x-filament::tabs.item>

        <x-filament::tabs.item @click="activeTab = 'forum'" :active="false" icon="heroicon-m-chat-bubble-left-ellipsis"
            alpine-active="activeTab === 'forum'">
            Forums
        </x-filament::tabs.item>

        <x-filament::tabs.item @click="activeTab = 'event'" :active="false" icon="heroicon-m-calendar-days"
            alpine-active="activeTab === 'event'">
            Events
        </x-filament::tabs.item>
    </x-filament::tabs>

    <div class="mt-6">
        <div x-show="activeTab === 'writing'" x-transition>
            @if ($bookmarkedWritings->count() > 0)
                <div class="flex flex-col gap-4">
                    @foreach ($bookmarkedWritings as $writing)
                        <div wire:key="bm-writing-{{ $writing->writing_id }}">
                            <x-writing.card :writing="$writing" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $bookmarkedWritings->links() }}
                </div>
            @else
                <div
                    class="bg-white dark:bg-zinc-800/50 p-12 rounded-xl text-center border border-zinc-200 dark:border-zinc-800">
                    <x-bi-pen class="w-12 h-12 mx-auto mb-3 opacity-50 text-zinc-400" />
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">Belum ada tulisan yang disimpan.</p>
                </div>
            @endif
        </div>

        <div x-show="activeTab === 'forum'" x-cloak x-transition>
            @if ($bookmarkedForums->count() > 0)
                <div class="flex flex-col gap-4">
                    @foreach ($bookmarkedForums as $forum)
                        <div wire:key="bm-forum-{{ $forum->id }}">
                            <x-forum.card :forum="$forum" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $bookmarkedForums->links() }}
                </div>
            @else
                <div
                    class="bg-white dark:bg-zinc-800/50 p-12 rounded-xl text-center border border-zinc-200 dark:border-zinc-800">
                    <x-bi-chat-left-text class="w-12 h-12 mx-auto mb-3 opacity-50 text-zinc-400" />
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">Belum ada diskusi forum yang disimpan.
                    </p>
                </div>
            @endif
        </div>

        <div x-show="activeTab === 'event'" x-cloak x-transition>
            @if ($bookmarkedEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($bookmarkedEvents as $event)
                        <div wire:key="bm-event-{{ $event->id }}">
                            <x-event.card :event="$event" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $bookmarkedEvents->links() }}
                </div>
            @else
                <div
                    class="bg-white dark:bg-zinc-800/50 p-12 rounded-xl text-center border border-zinc-200 dark:border-zinc-800">
                    <x-bi-calendar-event class="w-12 h-12 mx-auto mb-3 opacity-50 text-zinc-400" />
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">Belum ada acara yang disimpan.</p>
                </div>
            @endif
        </div>
    </div>

    <x-event.event-modal wire:model.live="isModalOpen" maxWidth="5xl">
        @if ($selectedEvent)
            <x-event.detail :event="$selectedEvent" :is-bookmarked="$isBookmarked" />
        @endif
    </x-event.event-modal>
</div>
