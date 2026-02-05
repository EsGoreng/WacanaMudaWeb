<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1080, initial-scale=1.0">
    <title>{{ $event->title }} - Story</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        "brand-green": "#10b981",
                        "card-bg": "#0f172a",
                        "card-border": "#334155",
                        "text-main": "#f8fafc",
                        "text-muted": "#94a3b8",
                    },
                    fontFamily: {
                        "display": ["'Outfit'", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1920px;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="w-[1080px] h-[1920px] font-display antialiased overflow-hidden text-white relative bg-slate-950">

    <div class="absolute inset-0 z-0">
        <x-star-background />
    </div>


    <div
        class="absolute inset-0 z-0 bg-gradient-to-b from-slate-700/50 to-slate-950/60 backdrop-blur-xs pointer-events-none">
    </div>

    <div class="relative flex h-full w-full flex-col items-center z-10">

        <div class="flex justify-center mt-64 mb-24 scale-[2.5] ">
            <x-app-logo class="text-white drop-shadow-lg font-sans" />
        </div>

        <div
            class="relative w-[850px] bg-card-bg border border-card-border rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col">

            <div class="relative h-[650px] w-full bg-slate-800">
                <img src="{{ str_starts_with($event->banner_image, 'http') ? $event->banner_image : public_path('storage/' . $event->banner_image) }}"
                    alt="Cover" class="w-full h-full object-cover opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-card-bg via-transparent to-transparent"></div>
            </div>

            <div class="flex flex-col px-10 py-10 bg-card-bg flex-1 -mt-5 relative z-20">

                <div class="flex flex-wrap gap-3 mb-8">
                    @forelse($event->categories->take(3) as $category)
                        <span
                            class="inline-flex items-center justify-center {{ $category->badge_class ?? 'bg-slate-700 text-white' }} bg-opacity-90 border border-white/10 px-5 py-2 whitespace-nowrap rounded-full text-lg font-bold uppercase tracking-wide shadow-lg leading-none">
                            {{ $category->name }}
                        </span>
                    @empty
                        <span
                            class="bg-slate-700 text-white border border-white/10 px-5 py-2 rounded-full text-lg font-bold uppercase tracking-wide">
                            Event
                        </span>
                    @endforelse
                </div>

                <div class="flex items-center justify-between mb-8">
                    <span
                        class="inline-flex items-center text-2xl font-medium text-slate-400 whitespace-nowrap leading-none">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}
                    </span>

                    <span
                        class="inline-flex items-center justify-center bg-slate-800 border border-slate-700 text-sky-400 px-6 py-2 whitespace-nowrap rounded-full text-xl font-bold tracking-wide leading-none">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                    </span>
                </div>

                <h1
                    class="text-left text-[3.2rem] leading-[1.2] font-extrabold text-white mb-6 tracking-tight drop-shadow-md truncate">
                    {{ $event->title }}
                </h1>

                <div class="mb-10">
                    <p class="text-left text-3xl leading-relaxed text-slate-400 line-clamp-3 font-normal">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description ?? ''), 180) }}
                    </p>
                </div>

                <div class="flex items-center justify-between mb-10 mt-auto pt-8 border-t border-slate-800/50">
                    <div class="flex items-center gap-4">
                        <span
                            class="text-2xl font-bold text-slate-200 uppercase tracking-wider border border-white/20 px-4 py-1 rounded-lg">
                            {{ $event->statusLabel ?? 'Upcoming' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-6 text-slate-400">
                        <div class="flex items-center gap-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
