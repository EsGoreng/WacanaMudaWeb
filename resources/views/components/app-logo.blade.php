@props([
    'sidebar' => false,
    'size' => 'default',
])

@php
    $sizes = [
        'default' => ['container' => 'size-8', 'icon' => 'size-5', 'font' => 'base'],
        'lg' => ['container' => 'size-12', 'icon' => 'size-8', 'font' => 'lg'],
        'xl' => ['container' => 'size-16', 'icon' => 'size-12', 'font' => 'xl'],
        '2xl' => ['container' => 'size-24', 'icon' => 'size-16', 'font' => '3xl'],
        '3xl' => ['container' => 'size-32', 'icon' => 'size-24', 'font' => '5xl'],
    ];

    $currentSize = $sizes[$size] ?? $sizes['default'];
@endphp

@if ($sidebar)
    <flux:sidebar.brand name="Wacana Muda" :font-size="$currentSize['font']" {{ $attributes }}>
        <x-slot name="logo"
            class="flex aspect-square {{ $currentSize['container'] }} items-center justify-center rounded-md bg-accent-content dark:bg-white text-accent-foreground">
            <x-app-logo-icon class="{{ $currentSize['icon'] }} fill-current text-white dark:text-black" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Wacana Muda Berkarya" :font-size="$currentSize['font']" {{ $attributes }}>
        <x-slot name="logo"
            class="flex aspect-square {{ $currentSize['container'] }} items-center justify-center rounded-md bg-accent-content dark:bg-white text-accent-foreground">
            <x-app-logo-icon class="{{ $currentSize['icon'] }} fill-current text-white dark:text-black" />
        </x-slot>
    </flux:brand>
@endif
