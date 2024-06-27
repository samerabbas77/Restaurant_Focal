<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\RoleController;

use App\Http\Controllers\Admin\UserController;


use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Auth.login');
});

Auth::routes(['register' => false]); //إيقاف عمل راوت تسجيل الدخول


Route::group(['middleware' => ['auth', 'role:Admin|Waiter']], function () {
    ///................Home.................................
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth', 'check.username']], function () {

    ///...............Admin Dashboard.......................
    Route::resource('/dishes', DishController::class);

    Route::resource('/tables', TableController::class);

    Route::resource('/reservation', ReservationController::class);

    Route::resource('/client', ClientController::class);

    Route::resource('/order', OrderController::class);

    Route::resource('/reviews', ReviewController::class);

    Route::resource('/categories', CategoryController::class);


    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    //....................Soft Delete............................
    //Table
    Route::post('tables/{id}/restore', [TableController::class, 'restore'])->name('tables.restore');
    Route::delete('tables/{id}/forceDelete', [TableController::class, 'forceDelete'])->name('tables.forceDelete');

    //Dish
    Route::post('dishes/{id}/restore', [DishController::class, 'restore'])->name('dishes.restore');
    Route::delete('dishes/{id}/forceDelete', [DishController::class, 'forceDelete'])->name('dishes.forceDelete');

    //Reservation
    Route::post('reservations/{id}/restore', [ReservationController::class, 'restore'])->name('reservations.restore');
    Route::delete('reservations/{id}/forceDelete', [ReservationController::class, 'forceDelete'])->name('reservations.forceDelete');

    //Category
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/forceDelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    //Review
    Route::post('reviews/{id}/restore', [ReviewController::class, 'restore'])->name('reviews.restore');
    Route::delete('reviews/{id}/forceDelete', [ReviewController::class, 'forceDelete'])->name('reviews.forceDelete');

    //Order
    Route::post('orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');
    Route::delete('orders/{id}/forceDelete', [OrderController::class, 'forceDelete'])->name('orders.forceDelete');


});

//Forget password..........................................................................................
Route::get('forgot-password', function () {
    return view('auth.passwords.forgot');
})->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', function ($token) {
    return view('auth.reset', ['token' => $token]);
})->name('auth.password.reset');

Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');






