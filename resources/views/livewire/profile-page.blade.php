<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- Sidebar Profile --}}
    <div class="lg:col-span-1">
        <div class="relative w-full max-w-sm mx-auto">
            <div
                class="relative bg-white dark:bg-zinc-800/50 backdrop-blur-xs rounded-[1rem] transition-all duration-300 shadow-sm">

                <div class="relative aspect-square h-auto w-[full] px-4 pt-4">
                    <img alt="Portrait of {{ $user->name }}"
                        class="w-full h-full object-cover object-center rounded-[0.5rem]"
                        src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}   " />
                </div>

                <div class="p-6 pt-4">
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50 tracking-tight">
                            {{ $user->name }}
                        </h2>
                    </div>

                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        {{ $user->bio ?? 'No bio available yet.' }}
                    </p>

                    <div class="flex items-center gap-4 mb-6">
                        <a href="#" class="text-gray-400 hover:text-[#0077b5] transition-colors duration-300">
                            <x-bi-linkedin class="w-5 h-5" />
                        </a>

                        <a href="#" class="text-gray-400 hover:text-[#E1306C] transition-colors duration-300">
                            <x-bi-instagram class="w-5 h-5" />
                        </a>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 text-gray-500 font-medium text-sm">

                            <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                                title="Followers">
                                <x-bi-people class="w-4 h-4" />
                                <span>{{ $user->followers_count ?? '0' }}</span>
                            </div>

                            <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                                title="Writings">
                                <x-bi-pen class="w-4 h-4" />
                                <span>{{ $user->writings()->count() }}</span>
                            </div>

                            <div class="flex items-center gap-1.5 group cursor-pointer hover:text-zinc-900 dark:hover:text-zinc-300 transition-colors"
                                title="Forums">
                                <x-bi-chat-left-text class="w-4 h-4" />
                                <span>{{ $user->forums()->count() }}</span>
                            </div>
                        </div>

                        @if (Auth::id() === $user->id)
                            {{ $this->editProfile }}
                        @else
                            <button
                                class="bg-zinc-600 text-white px-5 py-2 rounded-xl active:scale-95 duration-300 flex items-center gap-1 text-sm font-medium hover:bg-zinc-700">
                                Follow
                                <span class="text-lg leading-none">+</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content (Tabs) --}}
    {{-- ... kode sidebar profile di atas tetap sama ... --}}

    {{-- Main Content (Tabs) --}}
    <div class="lg:col-span-3">
        {{-- Gunakan wire:ignore.self agar tab tidak reset saat ganti halaman pagination --}}
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
                {{-- TAB WRITING --}}
                <div x-show="activeTab === 'writing'" x-transition>
                    <div class="flex flex-col gap-4">
                        {{-- UBAH DISINI: Gunakan variabel $writings --}}
                        @forelse ($writings as $writing)
                            <div wire:key="writing-{{ $writing->writing_id }}">
                                <x-writing-card :image="$writing->image_url" :avatar="$writing->author_avatar_url" :author="$writing->author_display_name" :categories="$writing->categories"
                                    :date="$writing->published_at
                                        ? $writing->published_at->format('M d, Y')
                                        : $writing->created_at->format('M d, Y')" :readTime="$writing->reading_time" :title="$writing->title" :description="$writing->description"
                                    :excerpt="$writing->excerpt" :link="route('writing.show', $writing->slug)" />

                                {{-- Separator Manual (Agar tidak menyatu) --}}
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

                    {{-- TAMBAHKAN INI: Tombol Pagination --}}
                    <div class="mt-8">
                        {{ $writings->links() }}
                    </div>
                </div>

                {{-- TAB FORUM --}}
                <div x-show="activeTab === 'forum'" x-cloak x-transition>
                    <div class="flex flex-col gap-4">
                        @forelse ($forums as $forum)
                            <x-forum-card :forum="$forum" />
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
</div>
