@props(['event'])

<div
    class="relative w-full max-w-sm rounded-xl overflow-hidden shadow-2xl transition-all duration-300 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] text-white group">
    <div class="relative h-[500px] w-full">
        <img alt="{{ $event->title }}"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            src="{{ str_starts_with($event->banner_image, 'http') ? $event->banner_image : asset('storage/' . $event->banner_image) }}" />

        <button
            class="absolute top-5 right-5 w-10 h-10 bg-black/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition-colors group/btn z-20 shadow-lg border border-white/10">
            <span
                class="material-icons-round text-white text-xl group-hover/btn:scale-110 transition-transform"><x-bi-bookmark></x-bi-bookmark></span>
        </button>

        <div class="absolute inset-0 bg-gradient-glass pointer-events-none z-10"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 z-20 flex flex-col justify-end h-full">
            <div class="mt-auto backdrop-blur-sm bg-black/20 rounded-xl p-5 border border-white/10 shadow-lg">

                <div class="flex items-center gap-3 text-xs font-medium text-blue-100/90 mb-2">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('d M, Y') }}
                        </span>
                    </div>

                    <span class="w-1 h-1 rounded-full bg-blue-200/50"></span>

                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-2xl font-bold tracking-tight text-white drop-shadow-md">{{ $event->title }}
                    </h2>
                </div>

                <p class="text-white/90 text-sm leading-relaxed mb-5 font-medium pr-2 drop-shadow-sm">
                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 100) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-6">
                    @forelse($event->categories as $category)
                        <div
                            class="{{ $category->badgeClass }} backdrop-blur-sm px-3 py-1.5 rounded-lg border border-white/10 text-xs font-medium text-white transition-colors cursor-default">
                            {{ $category->name }}
                        </div>
                    @empty
                        <div
                            class="bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/10 text-xs font-medium text-white shadow-sm">
                            Event
                        </div>
                    @endforelse
                </div>

                <button wire:click="openModal({{ $event->id }})" wire:loading.attr="disabled"
                    class="w-full bg-white hover:bg-gray-50 text-black font-bold h-10 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">

                    <svg wire:loading wire:target="openModal({{ $event->id }})"
                        class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <span wire:loading.remove wire:target="openModal({{ $event->id }})">Detail</span>
                </button>
            </div>
        </div>
    </div>
</div>
