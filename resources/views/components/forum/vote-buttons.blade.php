@props(['orientation' => 'vertical'])

<button wire:click.prevent="vote({{ $forum->id }}, 'up')"
    class="p-1.5 rounded transition-colors relative {{ $userVote?->type === 'up' ? 'text-green-500 bg-green-500/10' : 'text-zinc-400 hover:text-green-500 hover:bg-green-500/10' }}">
    <x-bi-chevron-up class="w-5 h-5" wire:loading.remove wire:target="vote({{ $forum->id }}, 'up')" />
    <svg wire:loading wire:target="vote({{ $forum->id }}, 'up')" class="animate-spin w-5 h-5"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
    </svg>
</button>

<span
    class="text-xs font-bold px-1 {{ $score > 0 ? 'text-green-500' : ($score < 0 ? 'text-red-500' : 'text-zinc-700 dark:text-zinc-300') }}">
    {{ \Illuminate\Support\Number::abbreviate($score) }}
</span>

<button wire:click.prevent="vote({{ $forum->id }}, 'down')"
    class="p-1.5 rounded transition-colors relative {{ $userVote?->type === 'down' ? 'text-red-500 bg-red-500/10' : 'text-zinc-400 hover:text-red-500 hover:bg-red-500/10' }}">
    <x-bi-chevron-down class="w-5 h-5" wire:loading.remove wire:target="vote({{ $forum->id }}, 'down')" />
    <svg wire:loading wire:target="vote({{ $forum->id }}, 'down')" class="animate-spin w-5 h-5"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
    </svg>
</button>
