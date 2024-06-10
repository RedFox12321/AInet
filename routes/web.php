<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

use Illuminate\Support\Facades\Route;

/* Brezee Routes */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/* User made Routes */
Route::resource('tickets', TicketController::class)->except(['edit', 'update']);

Route::resource('theaters', TheaterController::class);

Route::resource('seats', SeatController::class); //TODO

Route::resource('screenings', ScreeningController::class);

Route::resource('purchases', PurchaseController::class)->except(['edit', 'update']);

Route::resource('movies', MovieController::class);

Route::resource('genre', GenreController::class); //TODO

Route::resource('customer', CustomerController::class);

Route::resource('user', UserController::class);

Route::get('movies/showcase', [MovieController::class, 'showcase'])->name('movies.showcase');

Route::get('configuration/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
Route::put('configuration', [ConfigurationController::class, 'update'])->name('configurations.update');

Route::get('cart/show', [CartController::class, 'show'])->name('cart.show');
