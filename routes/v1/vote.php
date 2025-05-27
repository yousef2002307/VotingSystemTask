<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper\Routes\RouteHelper;
use App\Http\Controllers\V1\VoteController;
Route::post('vote', [VoteController::class, 'AddVote']);
