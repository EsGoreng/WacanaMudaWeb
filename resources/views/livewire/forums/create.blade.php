<div x-data="{ expanded: false }"
    class="w-full mx-auto bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all overflow-hidden group">

    <div class="p-4 md:p-6">
        <div class="flex gap-3 md:gap-4">

            <div class="shrink-0">
                @php
                    $user = auth()->user();
                    $avatarUrl = $user->avatar
                        ? Storage::url($user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
                @endphp
                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}"
                    class="w-8 h-8 md:w-10 md:h-10 mt-1 md:mt-0  rounded-full object-cover ring-2 ring-white dark:ring-zinc-800">
            </div>

            <div class="flex-1 min-w-0">
                <div x-show="!expanded" @click="expanded = true" class="cursor-text w-full transition-all duration-200">

                    <div
                        class="w-full bg-white/60 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-700/50 rounded-lg px-4 py-2.5 md:py-2 text-sm text-zinc-500 dark:text-zinc-400 hover:bg-white dark:hover:bg-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors flex items-center gap-2 shadow-sm">
                        <x-bi-chat-left-text class="shrink-0 w-4 h-4" />
                        <span class="truncate">Click here to start a new discussion...</span>
                    </div>
                </div>

                <div x-show="expanded" x-cloak x-collapse>
                    <form wire:submit="create">
                        <div class="mt-1">
                            {{ $this->form }}
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-4">
                            <button type="button" @click="expanded = false"
                                class="text-xs md:text-sm font-medium text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-300 px-3 py-2 rounded-lg transition-colors">
                                Cancel
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
