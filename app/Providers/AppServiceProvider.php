<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Slate,
            'info' => Color::Blue,
            'primary' => [
                50 => '239, 246, 255',
                100 => '219, 234, 254',
                200 => '191, 219, 254',
                300 => '147, 197, 253',
                400 => '96, 165, 250',
                500 => '59, 130, 246',
                600 => '37, 99, 235',
                700 => '29, 78, 216',
                800 => '30, 64, 175',
                900 => '30, 58, 138',
                950 => '8, 31, 77',
            ],
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
