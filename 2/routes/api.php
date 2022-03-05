<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', AuthController::class)->middleware(['throttle:60,1', 'guest']);
// Route::resource('events', EventController::class)->middleware('auth:sanctum')->except(['create', 'edit']);
Route::get('events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::get('events/{event}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::post('events', [EventController::class, 'store'])->middleware('auth:sanctum');
Route::post('events/{event}', [EventController::class, 'update'])->middleware('auth:sanctum');
Route::delete('events/{event}', [EventController::class, 'destroy'])->middleware('auth:sanctum');
