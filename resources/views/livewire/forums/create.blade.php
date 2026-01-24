<div x-data="{ expanded: false }" @click.self="expanded = !expanded"
    class="mx-auto p-0 lg:p-6 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer group overflow-hidden">
    <div class="flex items-start gap-4 pointer-events-none">

        <div class="flex-shrink-0 hidden md:block">
            @php
                $user = auth()->user();
                $avatarUrl = $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
            @endphp
            <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
        </div>

        <div class="flex-1 pointer-events-auto">

            <div x-show="!expanded" @click="expanded = true"
                class="text-zinc-500 py-2 select-none flex flex-rows items-center">
                <x-bi-chat-left-text class="mr-2" />
                Click here to open new forum
            </div>

            <div x-show="expanded" x-collapse x-cloak @click.stop>
                <form wire:submit="create">
                    {{ $this->form }}

                    <div class="flex justify-end mt-4">
                        <button type="button" @click="expanded = false"
                            class="text-xs text-zinc-500 hover:text-zinc-700 mr-4">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
