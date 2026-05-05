<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\carsController;
use App\Http\Controllers\MaintenancesController;
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

// Route::controller(MaintenancesController::class)->group(function () {
//     Route::get('/maintenance/{id}', 'index')->name('maintenance.index');
//     Route::get('/maintenance/create/{id}', 'create')->name('maintenance.create');
//     Route::get('/maintenance/edit/{id}', 'edit')->name('maintenance.edit');
//     Route::post('/maintenance', 'store')->name('maintenance.store');
//     Route::put('/maintenance/{id}', 'update')->name('maintenance.update');
//     Route::delete('/maintenance/{id}', 'destroy')->name('maintenance.destroy');
// });
Route::controller(MaintenancesController::class)->group(function () {
    Route::get('/cars/{car}/maintenances', 'index')->name('maintenance.index');
    Route::get('/cars/{car}/maintenances/create', 'create')->name('maintenance.create');
    Route::post('/maintenances', 'store')->name('maintenance.store');
    Route::get('/maintenances/{maintenance}/edit', 'edit')->name('maintenance.edit');
    Route::put('/maintenances/{maintenance}', 'update')->name('maintenance.update');
    Route::delete('/maintenances/{maintenance}', 'destroy')->name('maintenance.destroy');
    Route::get('/cars/maintenance', 'carsNeedingMaintenance')->name('cars.maintenance');
    
});