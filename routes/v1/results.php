<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Routes\RouteHelper;
use App\Http\Controllers\V1\ResultController;
Route::get('results/{id}', [ResultController::class, 'index'])->withoutMiddleware('auth:sanctum');

