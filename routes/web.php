<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\BaseController;

Route::get('/', function () { return view('welcome'); })->middleware(['guest'])->name('welcome');
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');

Route::get('/set-locale/{lang}', [LocaleController::class, 'setLocale']);
Route::get('/user-list', [BaseController::class, 'renderUserList'])->middleware(['auth'])->name('user-list');

Route::get('/facebook', function () { return view('facebook'); })->middleware(['auth'])->name('facebook');
Route::get('/facebook/credentials', [BaseController::class, 'getFacebookCredentials'])->middleware(['auth']);

Route::get('/profile', [BaseController::class, 'showProfile'])->middleware(['auth'])->name('profile');
Route::post('/profile/update', [BaseController::class, 'updateProfile'])->middleware(['auth'])->name('update-profile');

require __DIR__.'/auth.php';
