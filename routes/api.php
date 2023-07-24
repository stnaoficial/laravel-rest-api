<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Response;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', fn() => redirect('api'));

Route::prefix('api')->name('api')->group(function() {

    Route::get('/', fn() => response()->json([ 'success' => true ], Response::HTTP_OK));

    // public routes with CORS policy
    Route::middleware('cors')->group(function() {

        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::apiResource('users', UserController::class);
    });

    // Protected routes
    Route::middleware('auth:api')->group(function() {
    
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    });
});

