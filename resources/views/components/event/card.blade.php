@props(['event'])

@php
    $user = auth()->user();
    $isBookmarked = $user ? $event->isBookmarkedBy($user) : false;
@endphp

<div
    class="relative w-full max-w-sm rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] text-white group">
    <div class="relative h-[550px] w-full">
        <img alt="{{ $event->title }}"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
            src="{{ str_starts_with($event->banner_image, 'http') ? $event->banner_image : asset('storage/' . $event->banner_image) }}" />

        <button wire:click.stop="generateInstagramStory({{ $event->id }})" wire:loading.attr="disabled"
            class="absolute top-5 right-[70px] w-10 h-10 rounded-full flex items-center justify-center transition-colors group/btn z-5 shadow-lg border border-white/10 bg-black/20 backdrop-blur-sm hover:bg-white/30 text-white">

            <span wire:loading.remove wire:target="generateInstagramStory({{ $event->id }})"
                class="material-icons-round text-xl group-hover/btn:scale-110 transition-transform flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-instagram" viewBox="0 0 16 16">
                    <path
                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.047-1.096-.047-3.232 0-2.136.009-2.388.047-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                </svg>
            </span>

            <svg wire:loading wire:target="generateInstagramStory({{ $event->id }})"
                class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </button>
        <button wire:click.stop="toggleEventBookmark({{ $event->id }})" wire:loading.attr="disabled"
            class="absolute top-5 right-5 w-10 h-10 rounded-full flex items-center justify-center transition-colors group/btn z-5 shadow-lg border border-white/10
    {{ $isBookmarked
        ? 'bg-yellow-500/90 text-white hover:bg-yellow-600'
        : 'bg-black/20 backdrop-blur-sm hover:bg-white/30 text-white' }}">

            <span wire:loading.remove wire:target="toggleEventBookmark({{ $event->id }})"
                class="material-icons-round text-xl group-hover/btn:scale-110 transition-transform flex items-center justify-center">
                @if ($isBookmarked)
                    <x-bi-bookmark-fill />
                @else
                    <x-bi-bookmark />
                @endif
            </span>

            <svg wire:loading wire:target="toggleEventBookmark({{ $event->id }})"
                class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </button>

        <div class="absolute inset-0 bg-gradient-glass pointer-events-none z-10"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 flex flex-col justify-end h-full">
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

                    <span class="w-1 h-1 rounded-full bg-blue-200/50"></span>

                </div>

                <div class="flex items-center justify-between mb-2">
                    <h2
                        class="text-sm font-bold tracking-tight {{ $event->statusColor }} drop-shadow-md backdrop-blur-sm px-3 py-1.5 rounded-lg border border-white/10 text-xs font-medium cursor-default">
                        {{ $event->statusLabel }}
                    </h2>
                </div>

                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-2xl font-bold tracking-tight text-white drop-shadow-md">{{ $event->title }}
                    </h2>
                </div>

                <p class="text-white/90 text-sm leading-relaxed mb-5 font-medium pr-2 drop-shadow-sm break-all">
                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 80) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-6">
                    @forelse($event->categories as $category) 
                        <div
                            class="{{ $category->badgeClass }} backdrop-blur-sm px-3 py-1.5 rounded-lg border border-white/10 text-xs font-medium text-white cursor-default">
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
