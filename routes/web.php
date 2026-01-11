<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');

Route::view('home', 'pages.home')
    ->middleware(['auth', 'verified'])
    ->name('home');

require __DIR__.'/settings.php';
