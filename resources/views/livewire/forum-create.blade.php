<div
    class="mx-auto p-6 bg-gradient-to-b from-zinc-50 to-zinc-200 dark:from-zinc-700/10 dark:to-zinc-900/20 backdrop-blur-xs border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm hover:border-zinc-300 dark:hover:border-zinc-700 transition-all cursor-pointer group overflow-hidden">
    <div class="flex items-start gap-4">

        {{-- Avatar (Kiri) --}}
        <div class="flex-shrink-0">
            @php
                $user = auth()->user();
                $avatarUrl =
                    $user->avatar_url ??
                    'https://ui-avatars.com/api/?name=' .
                        urlencode($user->name) .
                        '&color=7F9CF5&background=EBF4FF&bold=true';
            @endphp
            <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
        </div>

        {{-- Formulir (Kanan) --}}
        <div class="flex-1">
            <form wire:submit="create">
                {{-- Seluruh form (termasuk tombol) dirender di sini --}}
                {{ $this->form }}
            </form>
        </div>
    </div>
</div>
