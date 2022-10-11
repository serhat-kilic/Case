<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(\App\Http\Controllers\AdminController::class)->middleware('auth:web')->group(function () {
    Route::get('/', 'employeeList');
    Route::get('/employees/edit/{id}', 'employeeForm');
    Route::get('/employees/add', 'employeeForm');
    Route::get('/employees/give-car/{id}', 'giveCar');
    Route::get('/employees/cars', 'employeesCars');
    Route::get('/cars/list', 'carsList');
    Route::get('/cars/edit/{id}', 'carsForm');
    Route::get('/cars/create', 'carsForm');
});

Route::get('/login',[\App\Http\Controllers\AuthController::class,'showLogin'])->name('login');
Route::post('/login',[\App\Http\Controllers\AuthController::class,'loginUi']);
