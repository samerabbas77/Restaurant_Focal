<?php

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Route as RoutingRoute;
use App\Http\Controllers\ApiController\DishController;
use App\Http\Controllers\ApiController\OrderController;
use App\Http\Controllers\ApiController\TableController;
use App\Http\Controllers\ApiController\ReviewController;
use App\Http\Controllers\ApiController\ReservationController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/all_dishes', [DishController::class, 'all_dishes']);

Route::middleware(['auth:sanctum'])->group(function () {
    //     
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    ///logout==========================================================
    Route::post('/logout', [AuthController::class, 'logout']);

    //Review============================================================================
    Route::controller(ReviewController::class)->group(function () {
        Route::get('reviews', 'index');
        Route::post('review', 'store');
        Route::get('review', 'show');
        Route::put('review/{review}', 'update');
        Route::delete('review/{review}', 'destroy');
    });

    //order============================================================================
    Route::controller(OrderController::class)->group(function () {
        Route::get('/all_order', 'all_order');
        Route::post('/add_order', 'add_order');
        Route::get('/details_order/{id}', 'details_order');
        Route::post('/update_order/{id}', 'update_order');
        Route::delete('/delete_order/{id}', 'delete_order');
    });

        //Table===============================================================================
        Route::controller(TableController::class)->group(function () {
            Route::get('/tables', 'index');
            Route::get('/tables/available', 'available');
            Route::get('/tables/chairs/{number}', 'filterByChairs');
            Route::get('/tables/chairs/available/{number}', 'filteravailableByChairs');
        });
        //ٌReservation==========================================================================
        Route::controller(ReservationController::class)->group(function(){
            Route::post('/reservation', 'store');
            Route::put('/reservation/{id}', 'update');//id for reservation
            Route::delete('/reservation/{id}', 'destroy');//id for reservation
            Route::get('/reservation/{id}', 'show');//id for user 
            Route::put('/reservation/renew/{id}', 'renew');//id for reservation
            Route::get('/reserrvation/user','userReservation');
            
        });

});
