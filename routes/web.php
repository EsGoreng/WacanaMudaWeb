<?php

use App\Livewire\WritingDetail;
use App\Livewire\WritingForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/writing/{writing:slug}', WritingDetail::class)->name('writing.show');
    Route::view('/writing', 'pages.writing.main')->name('writing');
    Route::view('/home', 'pages.home')->name('home');

    Route::view('/dashboard', 'pages.dashboard.overview')->name('dashboard');

    Route::view('/dashboard/writing', 'pages.dashboard.writing')->name('dashboard.writing');
    Route::get('/dashboard/writing/create', WritingForm::class)->name('dashboard.writing.create');
    Route::get('/dashboard/writing/{writing}/edit', WritingForm::class)->name('dashboard.writing.edit');

    Route::view('/dashboard/event', 'pages.dashboard.event')->name('dashboard.event');
    Route::view('/dashboard/member', 'pages.dashboard.member')->name('dashboard.member');
});

require __DIR__.'/settings.php';
