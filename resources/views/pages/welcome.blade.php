<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark overflow-x-hidden scroll-smooth">

<head>
    @include('partials.head')
    @livewireStyles
    <style>
        /* Parallax Background Layers */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 200px;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 180px;
            }
        }

        .bento-item-wide {
            grid-column: span 2;
        }

        .bento-item-tall {
            grid-row: span 2;
        }

        .bento-item-large {
            grid-column: span 2;
            grid-row: span 2;
        }
    </style>
</head>

<body
    class="overflow-x-hidden w-full relative bg-gradient-to-b from-slate-300 to-slate-400 dark:bg-transparent dark:bg-gradient-to-b dark:from-page-gray-950/50 dark:to-page-gray-950/90"
    x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.scrollY">

    <div
        class="relative z-10 text-zinc-800 dark:text-zinc-100 font-sans antialiased selection:bg-slate-950 selection:text-white">

        <x-star-background />

        <x-navbar />

        <div class="space-y-0 md:space-y-8 max-w-[1920px] mx-auto px-0 py-0 md:px-6 md:py-6">

            <x-landing-sections.hero />

            @foreach ($landingPage->content ?? [] as $block)
                @php $data = $block['data']; @endphp

                <x-landing-section :id="$block['type']">

                    @if ($block['type'] === 'about_section')
                        <x-landing-sections.about :data="$data" />
                    @endif

                    @if ($block['type'] === 'vision_mission_section')
                        <x-landing-sections.vision-mission :data="$data" />
                    @endif

                    @if ($block['type'] === 'pillars_section')
                        <x-landing-sections.pillars :data="$data" />
                    @endif

                    @if ($block['type'] === 'gallery_section')
                        <x-landing-sections.gallery :data="$data" />
                    @endif

                    @if ($block['type'] === 'latest_writings_section')
                        <x-landing-sections.writings :data="$data" />
                    @endif

                    @if ($block['type'] === 'events_section')
                        <x-landing-sections.events :data="$data" />
                    @endif

                    @if ($block['type'] === 'contact_section')
                        <x-landing-sections.contact :data="$data" />
                    @endif

                </x-landing-section>
            @endforeach

        </div>

        @include('components.footer')
    </div>
</body>

</html>
