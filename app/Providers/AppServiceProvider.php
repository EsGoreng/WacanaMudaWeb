<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

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
            'gray' => Color::Slate,  // Sudah sesuai dengan CSS (zinc -> slate)
            'info' => Color::Blue,
            'primary' => [
                50 => '239, 246, 255',   // blue-50
                100 => '219, 234, 254',  // blue-100
                200 => '191, 219, 254',  // blue-200
                300 => '147, 197, 253',  // blue-300
                400 => '96, 165, 250',   // blue-400
                500 => '59, 130, 246',   // blue-500 (accent dark mode)
                600 => '37, 99, 235',    // blue-600
                700 => '29, 78, 216',    // blue-700
                800 => '30, 64, 175',    // blue-800 (brand-hover)
                900 => '30, 58, 138',    // blue-900
                950 => '8, 31, 77',      // brand-navy (#081f4d)
            ],
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
