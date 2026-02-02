@props(['noContainer' => false])

<section {{ $attributes->merge(['class' => 'section-card py-16 md:py-24 relative overflow-hidden group']) }}>

    <!-- Enhanced background with gradient -->
    <div class="absolute inset-0 -z-10">
        <!-- Dynamic gradient background -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/50 via-slate-900/30 to-slate-950/50"></div>

        <!-- Animated accent glows -->
        <div
            class="absolute top-1/3 -right-64 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl group-odd:opacity-100 group-even:opacity-50 transition-opacity duration-1000">
        </div>
        <div
            class="absolute -bottom-32 left-1/4 w-80 h-80 bg-cyan-500/5 rounded-full blur-3xl group-odd:opacity-50 group-even:opacity-100 transition-opacity duration-1000">
        </div>
    </div>

    @if ($noContainer)
        {{ $slot }}
    @else
        <div class="container mx-auto px-6 py-6 md:px-12 relative z-10">
            {{ $slot }}
        </div>
    @endif
</section>
