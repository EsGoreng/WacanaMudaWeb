<x-forum.layout>
    @auth
        <livewire:forums.index :only-following="true" />
    @else
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="p-4 mb-4 rounded-full bg-zinc-100 dark:bg-zinc-800">
                <flux:icon name="lock-closed" class="w-8 h-8 text-zinc-500" />
            </div>
            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Access Limited</h3>
            <p class="max-w-md mt-2 mb-6 text-zinc-500 dark:text-zinc-400">
                Please login to see the latest discussions from the communities you follow..
            </p>
            <div class="flex gap-3">
                <flux:button href="{{ route('login') }}" variant="primary">Log In</flux:button>
                <flux:button href="{{ route('register') }}" variant="subtle">Register</flux:button>
            </div>
        </div>
    @endauth
</x-forum.layout>
