<?php

use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    //Review
    Route::controller(ReviewController::class)->group(function () {
        Route::get('reviews', 'index');
        Route::post('review', 'store');
        Route::put('review/{review}', 'update');
        Route::delete('review/{review}', 'destroy');
    }); 
});
