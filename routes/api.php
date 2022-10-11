<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CarController;
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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});

Route::controller(EmployeController::class)->prefix('employees')->middleware('auth:api')->group(function (){
    Route::post('create','create');
    Route::post('give-car','giveCar');
    Route::get('list','index');
    Route::get('cars','employeesCars');
    Route::get('search','search');
    Route::get('get/{id}','employee');
    Route::put('edit/{id}','edit');
    Route::delete('delete/{id}','delete');
});

Route::controller(CarController::class)->prefix('cars')->middleware('auth:api')->group(function (){
    Route::post('create','create');
    Route::get('list','index');
    Route::get('get/{id}','car');
    Route::put('edit/{id}','edit');
    Route::delete('delete/{id}','delete');
});
