<div class=""> {{-- Padding dihapus karena biasanya sudah diatur parent container --}}

    {{-- HEADER SECTION --}}
    <div class="mb-12 text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] text-accent-content font-bold mb-3 block">
                Agenda
            </span>
            <h2 class="font-display text-4xl md:text-5xl font-bold tracking-tight mb-0 text-zinc-900 dark:text-white">
                {{ $data['section_title'] ?? 'Kegiatan Terbaru' }}
            </h2>
            @if (isset($data['section_subtitle']))
                <p class="mt-4 text-zinc-500 dark:text-zinc-400 max-w-2xl text-base leading-relaxed hidden md:block">
                    {{ $data['section_subtitle'] }}
                </p>
            @endif
        </div>

        {{-- Desktop View All Link --}}
        <a href="{{ route('events') }}"
            class="hidden md:flex items-center gap-2 text-xs font-bold uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-700 pb-1 hover:border-accent hover:text-accent transition-colors">
            See All <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>

    {{-- GRID SECTION --}}
    @if ($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 text-left">
            @foreach ($events as $event)
                {{-- Menggunakan Component Card yang sudah distyle sebelumnya --}}
                <x-event.card :event="$event" />
            @endforeach
        </div>
    @else
        {{-- EMPTY STATE --}}
        <div
            class="py-12 text-center border border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl text-zinc-400">
            <p class="text-sm italic">
                There are no new activity agendas yet.</p>
        </div>
    @endif

    {{-- MOBILE BUTTON (Hanya muncul di HP) --}}
    <div class="mt-8 md:hidden flex justify-center">
        <a href="{{ route('events') }}"
            class="text-xs font-bold uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-700 pb-1 hover:text-accent transition-colors">
            Lihat Semua Agenda
        </a>
    </div>

    {{-- MODAL (Tetap dipertahankan jika dibutuhkan untuk fitur pop-up) --}}
    <x-event.event-modal wire:model="isModalOpen" maxWidth="5xl">
        @if ($selectedEvent)
            <x-event.detail :event="$selectedEvent" :is-bookmarked="$isBookmarked" />
        @endif
    </x-event.event-modal>
</div>
