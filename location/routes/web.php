<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\carsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('acc');
Route::get('/login', [AuthController::class, 'toLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(CarsController::class)->group(function () {
    Route::get('/cars', 'index')->name('cars');
    Route::get('/cars/{id}/car', 'show')->name('cars.show');
    Route::get('/cars/create', 'create')->name('cars.add');
    Route::post('/cars', 'store')->name('cars.store');
    Route::get('/cars/{id}/edit', 'edit')->name('cars.edit');
    Route::put('/cars/{id}/edit', 'update')->name('cars.update');
    Route::delete('/cars/{id}/delete', 'destroy')->name('cars.destroy');
});