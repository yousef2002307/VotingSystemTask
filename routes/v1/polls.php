<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Routes\RouteHelper;
use App\Http\Controllers\V1\pollController;
use App\Http\Controllers\V1\PublicPollController;
Route::apiResource('polls', pollController::class);
Route::get('public-polls', [PublicPollController::class, 'index'])->withoutMiddleware('auth:sanctum');

