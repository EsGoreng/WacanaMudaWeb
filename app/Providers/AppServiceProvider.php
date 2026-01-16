<?php

namespace App\Providers;

use App\Models\Writing;
use App\Policies\WritingPolicy;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(Writing::class, WritingPolicy::class);

        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Slate,
            'info' => Color::Zinc,
            'primary' => [
                50 => '240, 245, 254',
                100 => '222, 232, 251',
                200 => '196, 216, 249',
                300 => '156, 190, 244',
                400 => '109, 156, 237',

                500 => '59, 130, 246',
                600 => '30, 58, 138',

                700 => '30, 64, 175',
                800 => '30, 41, 59',
                900 => '15, 23, 42',
                950 => '8, 15, 35',
            ],
            'secondary' => Color::Teal,
            'success' => Color::Emerald,
            'warning' => Color::Amber,
        ]);
    }
}
