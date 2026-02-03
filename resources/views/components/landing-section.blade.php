@props(['noContainer' => false])

<section
    {{ $attributes->merge([
        'class' => 'relative py-12 md:py-20 overflow-hidden 
                                transition-all duration-500
                                md:rounded-2xl
                                bg-white dark:bg-slate-950 
                                md:border md:border-zinc-200 md:dark:border-white/10',
    ]) }}>

    @if ($noContainer)
        <div class="relative z-10 h-full">
            {{ $slot }}
        </div>
    @else
        <div class="container mx-auto px-4 md:px-12 relative z-10 h-full">
            {{ $slot }}
        </div>
    @endif
</section>
