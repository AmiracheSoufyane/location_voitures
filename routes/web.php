<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarsController; 
use App\Http\Controllers\MaintenancesController;
use App\Http\Controllers\ReservationController; 
use App\Http\Controllers\ClientController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('acc');

Route::get('/login', [AuthController::class, 'toLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par Auth
Route::middleware('auth')->group(function () {

    // Gestion des Voitures
    Route::controller(CarsController::class)->group(function () {
        Route::get('/cars', 'index')->name('cars');
        Route::get('/cars/{id}/car', 'show')->name('cars.show');
        Route::get('/cars/create', 'create')->name('cars.add');
        Route::post('/cars', 'store')->name('cars.store');
        Route::get('/cars/{id}/edit', 'edit')->name('cars.edit');
        Route::put('/cars/{id}/edit', 'update')->name('cars.update');
        Route::delete('/cars/{id}/delete', 'destroy')->name('cars.destroy');
    });

    // Gestion des Maintenances
    Route::controller(MaintenancesController::class)->group(function () {
        Route::get('/cars/{car}/maintenances', 'index')->name('maintenance.index');
        Route::get('/cars/{car}/maintenances/create', 'create')->name('maintenance.create');
        Route::post('/maintenances', 'store')->name('maintenance.store');
        Route::get('/maintenances/{maintenance}/edit', 'edit')->name('maintenance.edit');
        Route::put('/maintenances/{maintenance}', 'update')->name('maintenance.update');
        Route::delete('/maintenances/{maintenance}', 'destroy')->name('maintenance.destroy');
    });

    // Gestion des Clients
    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'index')->name('clients.index');
        Route::get('/clients/create', 'create')->name('clients.create');
        Route::post('/clients', 'store')->name('clients.store');
        Route::get('/clients/{client}/edit', 'edit')->name('clients.edit');
        Route::put('/clients/{client}', 'update')->name('clients.update');
        Route::get('/clients/{id}', 'show')->name('clients.show');
    });

    // Gestion des Réservations
    Route::controller(ReservationController::class)->group(function () {
        Route::get('/reservations', 'index')->name('reservations.index');
        Route::get('/reservations/create', 'create')->name('reservations.create');
        Route::post('/reservations', 'store')->name('reservations.store');
        Route::get('/reservations/{id}', 'show')->name('reservations.show');
        Route::get('/reservations/{reservation}/edit', 'edit')->name('reservations.edit');
        Route::put('/reservations/{reservation}', 'update')->name('reservations.update');
    });

});