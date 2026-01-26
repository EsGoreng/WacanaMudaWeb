<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<link rel="manifest" href="/site.webmanifest" />

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />

<script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script>
<script>
    function initLenis() {
        if (window.lenis) {
            window.lenis.destroy();
        }

        const scrollElement = document.getElementById('main-content') || window;

        window.lenis = new Lenis({
            wrapper: scrollElement === window ? window : scrollElement,
            content: scrollElement === window ? document.documentElement : scrollElement.querySelector('div'),
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),

            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            smoothTouch: false,
            touchMultiplier: 2,
        });

        function raf(time) {
            window.lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);
    }

    document.addEventListener('DOMContentLoaded', initLenis);

    document.addEventListener('livewire:navigated', () => {
        initLenis();
        // Reset scroll position saat navigasi halaman
        window.lenis.scrollTo(0, {
            immediate: true
        });
    });
</script>

@filamentStyles
@vite('resources/css/app.css')
@fluxAppearance
