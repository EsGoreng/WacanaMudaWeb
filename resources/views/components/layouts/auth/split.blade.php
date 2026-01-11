<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-slate-950 dark:to-slate-900">
    <div
        class="relative grid min-h-screen flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div
            class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-slate-800">
            <div class="absolute inset-0 bg-slate-900"></div>
            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-md">
                    <div
                        class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content dark:bg-white text-accent-foreground">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                    </div>
                </span>
                {{ config('app.name', 'Laravel') }}
            </a>

            @php
                [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
            @endphp

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <flux:heading class="text-white" size="lg">
                        &ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                    <footer>
                        <flux:heading class="text-white">{{ trim($author) }}</flux:heading>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="w-full py-12     lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
                    wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <div
                            class="flex aspect-square size-12 items-center justify-center rounded-md bg-accent-content dark:bg-white text-accent-foreground">
                            <x-app-logo-icon class="size-9 fill-current text-white" />
                        </div>
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
