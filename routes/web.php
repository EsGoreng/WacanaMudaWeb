<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\WritingCreate;
use App\Livewire\WritingEdit;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');

Route::group(['middleware' => ['auth', 'verified'],], function () {
    Route::view('/home', 'pages.home')->name('home');
});

Route::group(['middleware' => ['auth', 'verified'],], function () {
    Route::view('/dashboard', 'pages.dashboard.overview')->name('dashboard');
    
    Route::view('/dashboard/writing', 'pages.dashboard.writing')->name('dashboard.writing');
    Route::get('/dashboard/writing/create', WritingCreate::class)->name('dashboard.writing.create');
    Route::get('/dashboard/writing/{writing}/edit', WritingEdit::class)->name('dashboard.writing.edit');
    
    Route::view('/dashboard/event', 'pages.dashboard.event')->name('dashboard.event');
    Route::view('/dashboard/member', 'pages.dashboard.member')->name('dashboard.member');
});

require __DIR__.'/settings.php';