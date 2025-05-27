<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Routes\RouteHelper;
use App\Http\Controllers\V1\SecuirtyController;
Route::post('register', [SecuirtyController::class, 'register'])->withoutMiddleware('auth:sanctum');
Route::post('/login', [SecuirtyController::class, 'login'])->withoutMiddleware('auth:sanctum');
Route::post('/logout', [SecuirtyController::class, 'logout'])->middleware('auth:sanctum');
