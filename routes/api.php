<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\MyController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/login', [AuthController::class, 'store']);
// Route::post('/register', [AuthController::class, 'register']);

Route::post('tokens', [StripeController::class, 'stripes']);
Route::get('card', [StripeController::class, 'getCard']);
Route::post('calendar', [CalendarController::class, 'calendar']);
Route::get('fetchData', [CalendarController::class, 'fetchData']);

Route::prefix('auth')->group( function() {
    Route::post('login', [AuthController::class, 'store']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});

//Inside middleware we can write "auth:api" or only "auth"
Route::middleware('authMiddleware')->group( function () {
    Route::prefix('v1')->group( function() {
        Route::get('check', [MyController::class, 'store']);
    });
});