@props(['noContainer' => false])

<section
    {{ $attributes->merge(['class' => 'section-card py-12 md:py-16 g-slate-50 dark:bg-slate-900 text-black dark:text-white text-center relative overflow-hidden']) }}>
    @if ($noContainer)
        {{ $slot }}
    @else
        <div class="container mx-auto px-6 py-6 md-md:px-12 relative z-10">
            {{ $slot }}
        </div>
    @endif
</section>
