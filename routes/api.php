<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController\DishController;
use App\Http\Controllers\ApiController\OrderController;
use App\Http\Controllers\ApiController\TableController;

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

    //order============================================================================
    Route::get('/all_order',[OrderController::class,'all_order']);
    Route::post('/add_order',[OrderController::class,'add_order']);
    Route::get('/details_order/{id}',[OrderController::class,'details_order']);
    Route::post('/update_order/{id}',[OrderController::class,'update_order']);
    Route::post('/delete_order/{id}',[OrderController::class,'delete_order']);

});

Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/available', [TableController::class, 'available']);
Route::get('/tables/chairs/{number}', [TableController::class, 'filterByChairs']);
Route::get('/tables/chairs/available/{number}', [TableController::class, 'filteravailableByChairs']);
