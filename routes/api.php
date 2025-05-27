<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Routes\RouteHelper;
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    RouteHelper::getRoutes(__DIR__ . '/../routes/v1');
});
