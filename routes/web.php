<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
       // Poll Management Page (index.blade.php)
       Route::get('/polls', function () {
        return view('polls.index');
    })->name('polls.index');

    // Public Polls Page (public.blade.php)
    Route::get('/public-polls', function () {
        return view('polls.public');
    })->name('polls.public');
});

require __DIR__.'/auth.php';
