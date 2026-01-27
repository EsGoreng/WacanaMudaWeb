<?php

use App\Livewire\Forums;
use App\Livewire\MyBookmarks;
use App\Livewire\Profile;
use App\Livewire\Writings;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {});

Route::view('/', 'pages.welcome')->name('welcome');
Route::view('/home', 'pages.home')->name('home');

Route::get('/profile/{user:username}', Profile\Show::class)->name('profile.show');

Route::get('/writing/{writing:slug}', Writings\Show::class)->name('writing.show');
Route::view('/writing', 'pages.writing.main')->name('writings');

Route::get('/forum/{forum:slug}', Forums\Show::class)->name('forum.show');
Route::view('/forum', 'pages.forum.main')->name('forums');

Route::view('/event', 'pages.event.main')->name('events');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('/dashboard', 'pages.dashboard.myprofile')->name('dashboard');

    Route::view('/dashboard/writing', 'pages.dashboard.writing')->name('dashboard.writing');
    Route::get('/dashboard/writing/create', Writings\Form::class)->name('dashboard.writing.create');
    Route::get('/dashboard/writing/{writing}/edit', Writings\Form::class)->name('dashboard.writing.edit');

    Route::get('/dashboard/mybookmark', MyBookmarks\Index::class)->name('dashboard.mybookmark');

    Route::view('/dashboard/event', 'pages.dashboard.event')->name('dashboard.event');
    Route::view('/dashboard/member', 'pages.dashboard.member')->name('dashboard.member');
});

require __DIR__.'/settings.php';
