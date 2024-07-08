<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth.token')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/me', function (Request $request) {
            return $request->user();
        });
        Route::post('edit/{user}', [AuthController::class, 'update']);
        Route::get('/all', [AuthController::class, 'showAll']);
    });
    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/store', [ProjectController::class, 'store']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::post('/{project}', [ProjectController::class, 'update']);
    });
    Route::prefix('activity')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);
        Route::get('/all/{idProject}', [ActivityController::class, 'projectActivities']);
        Route::post('/', [ActivityController::class, 'store']);
        Route::get('/{activity}', [ActivityController::class, 'show']);
        Route::post('/{activity}', [ActivityController::class, 'update']);
    });
});


Route::controller(AuthController::class)->group(function ($router) {
    Route::post('signup', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout')->middleware('auth.token');
    Route::post('refresh', 'refresh')->name('refresh');
});
