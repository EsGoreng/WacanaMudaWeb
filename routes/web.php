<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');

Route::group([
    'middleware' => ['auth', 'verified'],
], function () {
    Route::view('/home', 'pages.home')->name('home');
});

Route::group(['middleware' => ['auth', 'verified'],], function () {
    Route::view('/dashboard', 'pages.dashboard.overview')->name('dashboard');
    Route::view('/dashboard/writing', 'pages.dashboard.writing')->name('dashboard.writing');
    Route::view('/dashboard/event', 'pages.dashboard.event')->name('dashboard.event');
    Route::view('/dashboard/member', 'pages.dashboard.member')->name('dashboard.member');
});


require __DIR__.'/settings.php';
