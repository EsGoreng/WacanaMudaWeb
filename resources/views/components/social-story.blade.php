<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $writing->title }} - Story</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800;900&amp;display=swap"
        rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3b82f6",
                        "background-light": "#f6f6f8",
                        "background-dark": "#020410",
                        "card-light": "#ffffff",
                        "card-dark": "#0f172a",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        /* Memaksa ukuran container agar pas 1080x1920 untuk Instagram Story */
        body,
        html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1920px;
            overflow: hidden;
        }

        .vertical-text-rl {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
    </style>
</head>

<body
    class="w-[1080px] h-[1920px] bg-background-light dark:bg-background-dark font-display antialiased selection:bg-primary selection:text-white overflow-hidden transition-colors duration-500">

    <div
        class="relative flex h-full w-full flex-col bg-background-light dark:bg-background-dark text-gray-900 dark:text-white">

        <!-- Background Gradient -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-100"
            style="background: 
                radial-gradient(circle at 15% 25%, rgba(59, 130, 246, 0.12) 0%, transparent 45%), 
                radial-gradient(circle at 85% 75%, rgba(37, 99, 235, 0.10) 0%, transparent 45%),
                radial-gradient(circle at 50% 50%, rgba(30, 58, 138, 0.2) 0%, transparent 60%);">
        </div>

        <!-- Top Spacer -->
        <div class="h-32 w-full shrink-0 z-10"></div>

        <!-- Main Content -->
        <div class="relative z-10 flex flex-1 flex-col items-center justify-center px-16 pb-20 pt-12">

            <!-- Logo -->
            <div class="flex justify-center pb-16 pt-8 scale-150">
                <x-app-logo class="scale-150" />
            </div>

            <!-- Card Container -->
            <div
                class="relative flex flex-col w-full max-w-5xl rounded-[3rem] border-2 border-gray-200 bg-card-light shadow-2xl dark:border-white/10 dark:bg-blue-950/40 dark:backdrop-blur-xl dark:shadow-2xl overflow-hidden">

                <div class="relative flex flex-col p-20 pb-24">

                    <!-- Category Badge -->
                    <div class="flex items-center gap-4 mb-16">
                        <span class="h-4 w-4 rounded-full bg-primary shadow-[0_0_20px_rgba(59,130,246,0.8)]"></span>
                        <span class="text-2xl font-bold tracking-[0.25em] text-gray-500 dark:text-blue-300 uppercase">
                            {{ $writing->category }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1
                        class="text-left text-8xl leading-[1.1] font-black tracking-tight text-gray-900 dark:text-white mb-16">
                        {{ $writing->title }}
                    </h1>

                    <!-- Divider -->
                    <div class="mb-16 w-full flex items-center pr-28">
                        <div class="h-1 w-32 bg-primary"></div>
                        <div class="h-[2px] flex-1 bg-gray-200 dark:bg-blue-900/50"></div>
                    </div>

                    <!-- Description -->
                    <div class="relative pr-24">
                        <p
                            class="text-justify text-4xl font-normal leading-relaxed text-gray-600 dark:text-blue-100/90">
                            @php
                                $displayText = $writing->description;
                                if (empty($displayText) || strlen($displayText) < 100) {
                                    $cleanContent = strip_tags($writing->content);
                                    $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
                                    $displayText = $displayText
                                        ? $displayText . ' ' . Str::limit($cleanContent, 200 - strlen($displayText))
                                        : Str::limit($cleanContent, 200);
                                }
                            @endphp
                            {{ $displayText }}
                        </p>
                    </div>

                    <!-- Right Sidebar (Author & Reading Time) -->
                    <div
                        class="absolute right-0 top-0 bottom-0 z-20 flex w-28 flex-col items-center justify-center py-16 border-l-2 border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-blue-900/10">
                        <div class="h-40 w-[2px] bg-gray-300 dark:bg-blue-800/50 mb-8"></div>
                        <div class="flex-1 flex items-center justify-center">
                            <div
                                class="vertical-text-rl whitespace-nowrap text-xl font-bold tracking-[0.2em] text-gray-400 dark:text-blue-400">
                                BY {{ strtoupper($writing->author_display_name) }} <span
                                    class="mx-4 inline-block h-3 w-3 rounded-full bg-primary align-middle"></span>
                                {{ $writing->reading_time }} MIN READ
                            </div>
                        </div>
                        <div class="h-40 w-[2px] bg-gray-300 dark:bg-blue-800/50 mt-8"></div>
                    </div>

                </div>
            </div>

            <!-- Spacer -->
            <div class="grow"></div>

            <!-- CTA Button -->
            <div class="mb-24 mt-20 flex flex-col gap-6 w-full max-w-5xl">
                <button
                    class="group relative flex w-full items-center justify-between rounded-[2rem] bg-gray-100 p-6 pr-6 shadow-lg transition-all active:scale-[0.98] dark:bg-blue-950/50 dark:border-2 dark:border-white/5 backdrop-blur-sm">
                    <div class="flex flex-col pl-8 py-4 text-left">
                        <span
                            class="text-xl font-bold uppercase tracking-widest text-gray-500 dark:text-blue-300/70">Continue
                            Reading</span>
                        <span
                            class="text-3xl font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</span>
                    </div>
                    <div
                        class="flex h-28 w-28 items-center justify-center rounded-full bg-white text-gray-900 shadow-lg dark:bg-gradient-to-tr dark:from-blue-600 dark:to-blue-400 dark:text-white dark:shadow-[0_0_30px_rgba(59,130,246,0.6)]">
                        <span class="material-symbols-outlined text-6xl">arrow_outward</span>
                    </div>
                </button>
            </div>

        </div>

        <!-- Footer -->
        <div class="absolute bottom-6 left-0 right-0 z-20 flex justify-center">
            <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 dark:text-blue-500/50 uppercase">
                {{ config('app.name') }}
            </p>
        </div>

        <!-- Bottom Spacer -->
        <div class="h-6 w-full shrink-0"></div>

    </div>

</body>

</html>
