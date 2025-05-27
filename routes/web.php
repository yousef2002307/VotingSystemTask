<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Authentication Routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']); // Assuming a standard LoginController

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']); // Assuming a standard RegisterController

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Your authenticated routes here
    Route::get('/', function () {
        return view('welcome');
    })->name('home'); // Example: Make welcome page the home for authenticated users

    // Poll Management Route
    Route::get('/polls', function () {
        return view('polls.index');
    })->name('polls.index');

    // Public Polls Route
    Route::get('/public-polls', function () {
        return view('polls.public');
    })->name('polls.public');

    // Example of a protected route:
    // Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});


// Fallback route to redirect to login if not authenticated
Route::middleware(['guest'])->group(function () {
    Route::any('/{any}', function () {
        return redirect()->route('login');
    })->where('any', '.*');
});
