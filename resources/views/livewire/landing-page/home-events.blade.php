<div class="py-12">
    <div class="mb-12 text-center md:text-left">
        @if (isset($data['section_title']))
            <h2 class="font-display text-5xl md:text-7xl font-black tracking-tighter mb-4 leading-[0.9]">
                {{ $data['section_title'] }}
            </h2>
        @endif
        @if (isset($data['section_subtitle']))
            <p class="text-zinc-600 dark:text-zinc-400 max-w-2xl text-lg">
                {{ $data['section_subtitle'] }}
            </p>
        @endif
    </div>

    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 justify-items-center md:justify-items-start">
            @foreach($events as $event)
                <x-event.card :event="$event" />
            @endforeach
        </div>
    @else
        <div class="py-12 text-center border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl">
            <p class="text-zinc-500 italic">Belum ada agenda kegiatan terbaru.</p>
        </div>
    @endif

    <div class="mt-12 flex justify-center md:justify-start">
        <a href="{{ route('events') }}" 
           class="group bg-zinc-900 dark:bg-white text-white dark:text-black px-8 py-3 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-accent hover:text-white dark:hover:bg-accent dark:hover:text-white transition-all flex items-center gap-2">
            Lihat Semua Agenda
            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </a>
    </div>

    <x-event.event-modal wire:model="isModalOpen" maxWidth="5xl" >
        @if ($selectedEvent)
            <x-event.detail :event="$selectedEvent" :is-bookmarked="$isBookmarked"/>
        @endif
    </x-event.event-modal>
</div>