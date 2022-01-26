<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);
    Route::put('users/{user}/updateStatus/{status}', [UserController::class, 'updateStatus']);
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::get('users/{user}/attendances', [AttendanceController::class, 'perUser']);
    Route::post('users/{user}/attendances', [AttendanceController::class, 'signin']);
    Route::put('users/{user}/attendances', [AttendanceController::class, 'signout']);
    Route::put('users/{user}/attendances/updateLocation', [AttendanceController::class, 'updateLocation']);
});
