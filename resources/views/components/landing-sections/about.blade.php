@props(['data'])

<section id="about" class="relative py-12 md:py-20 overflow-hidden">
    <div class="container mx-auto px-4 md:px-10">
        <div class="flex flex-col lg:flex-row gap-12 lg:items-center">
            {{-- Left Image Column --}}
            <div class="w-full lg:w-1/2">
                <div
                    class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 group bg-zinc-100 dark:bg-zinc-900">
                    @if (isset($data['image']))
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            style="background-image: url('{{ Storage::url($data['image']) }}');">
                        </div>
                    @else
                        <div class="absolute inset-0 bg-zinc-800 flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-zinc-700">image</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Content Column --}}
            <div class="w-full lg:w-1/2 flex flex-col gap-6">
                <div class="flex flex-col gap-4">
                    <p class="text-accent-content font-bold text-xs uppercase tracking-widest leading-none">
                        introducing
                    </p>
                    @if (isset($data['section_title']))
                        <h2
                            class="text-zinc-900 dark:text-white text-4xl md:text-5xl font-black leading-tight tracking-tight font-display">
                            {{ $data['section_title'] }}
                        </h2>
                    @endif
                    <div
                        class="prose prose-lg dark:prose-invert text-zinc-500 dark:text-zinc-400 font-normal leading-relaxed">
                        {!! $data['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
