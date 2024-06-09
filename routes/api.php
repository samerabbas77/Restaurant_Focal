<?php

use App\Http\Controllers\ApiController\DishController;
use App\Http\Controllers\ApiController\OrderController;
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

Route::get('/all_dishes' , [DishController::class,'all_dishes']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/add_order',[OrderController::class,'add_order']);
    Route::get('/all_order',[OrderController::class,'all_order']);
    Route::get('/details_order/{id}',[OrderController::class,'details_order']);

});
