@props(['event'])

<div
    class="relative w-full max-w-sm rounded-xl overflow-hidden shadow-2xl transition-all duration-300 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] text-white group">
    <div class="relative h-[600px] w-full">
        {{-- Pastikan URL image sudah dihandle di Model accessor atau gunakan Storage::url jika perlu --}}
        <img alt="{{ $event->title }}"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            src="{{ str_starts_with($event->banner_image, 'http') ? $event->banner_image : asset('storage/' . $event->banner_image) }}" />

        <button
            class="absolute top-5 right-5 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white/30 transition-colors group/btn z-20 shadow-lg border border-white/10">
            <span
                class="material-icons-round text-white text-xl group-hover/btn:scale-110 transition-transform"><x-bi-bookmark></x-bi-bookmark></span>
        </button>

        <div class="absolute inset-0 bg-gradient-glass pointer-events-none z-10"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 z-20 flex flex-col justify-end h-full">
            <div class="mt-auto backdrop-blur-md bg-black/20 rounded-xl p-5 border border-white/10 shadow-lg">
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
                            class="bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 text-xs font-medium text-white transition-colors hover:bg-white/20 cursor-default shadow-sm">
                            {{ $category->name }}
                        </div>
                    @empty
                        <div
                            class="bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 text-xs font-medium text-white shadow-sm">
                            Uncategorized
                        </div>
                    @endforelse
                </div>

                <button
                    class="w-full bg-white hover:bg-gray-50 text-black font-bold py-3.5 rounded-xl transition-all active:scale-[0.98] shadow-lg flex items-center justify-center gap-2">
                    Detail
                </button>
            </div>
        </div>
    </div>
</div>
