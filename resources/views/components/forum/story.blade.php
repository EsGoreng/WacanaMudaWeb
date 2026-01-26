<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1080, initial-scale=1.0">
    <title>{{ $forum->title }} - Story</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
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
                        "display": ["'Plus Jakarta Sans'", "sans-serif"]
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

        <div class="flex justify-center mt-40 mb-24 scale-[2.5]">
            <x-app-logo class="text-white drop-shadow-lg" />
        </div>

        <div
            class="relative w-[850px] bg-card-bg border border-card-border rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col">

            <div
                class="relative h-[400px] w-full bg-gradient-to-br from-sky-900 to-indigo-950 flex items-center justify-center">
                <div class="opacity-20">
                    <span class="material-symbols-outlined text-[15rem]">forum</span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-card-bg via-transparent to-transparent"></div>
            </div>

            <div class="flex flex-col px-10 py-10 bg-card-bg flex-1 -mt-5 relative z-20">

                <div class="flex flex-wrap gap-3 mb-8">
                    @foreach ($forum->categories as $category)
                        <span
                            class="{{ $category->badge_class ?? 'bg-blue-600' }} bg-opacity-90 border border-white/10 px-5 py-2 rounded-full text-lg font-bold uppercase tracking-wide shadow-lg">
                            {{ $category->name }}
                        </span>
                    @endforeach
                    @if ($forum->is_pinned)
                        <span
                            class="bg-yellow-500/80 border border-white/10 px-5 py-2 rounded-full text-lg font-bold uppercase tracking-wide shadow-lg">
                            Pinned
                        </span>
                    @endif
                </div>

                <div class="flex items-center justify-between mb-8">
                    <span class="text-2xl font-medium text-slate-400">
                        {{ $forum->created_at->format('M d, Y') }}
                    </span>
                    <span
                        class="bg-slate-800 border border-slate-700 text-sky-400 px-6 py-2 rounded-full text-xl font-bold tracking-wide">
                        Discussion
                    </span>
                </div>

                <h1
                    class="text-left text-[3.2rem] leading-[1.2] font-extrabold text-white mb-6 tracking-tight drop-shadow-md">
                    {{ $forum->title }}
                </h1>

                <div class="mb-10">
                    <p class="text-left text-3xl leading-relaxed text-slate-400 line-clamp-3 font-normal">
                        @php
                            $cleanContent = strip_tags($forum->body);
                            $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
                            $displayText = Str::limit($cleanContent, 180);
                        @endphp
                        {{ $displayText }}
                    </p>
                </div>

                <div class="flex items-center justify-between mb-10 mt-auto pt-8 border-t border-slate-800/50">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-bold text-slate-200">
                            By {{ $forum->user->name }}
                        </span>
                    </div>

                    <div class="flex items-center gap-6 text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-3xl">chat_bubble</span>
                            <span class="text-xl font-bold">{{ $forum->replies()->count() }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-3xl">visibility</span>
                            <span
                                class="text-xl font-bold">{{ \Illuminate\Support\Number::abbreviate($forum->view_count) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
