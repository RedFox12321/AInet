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

use App\Models\Theater;
use App\Models\Movie;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

/* Brezee Routes */
Route::redirect('/', '/movies/showcase');

Route::get('movies/showcase', [MovieController::class, 'showcase'])
    ->name('movies.showcase')
    ->can('viewShowcase', Movie::class);

/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});


/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /* User made Routes */
    Route::resource('tickets', TicketController::class)->except(['edit', 'update']);

    Route::resource('theaters', TheaterController::class);

    Route::resource('seats', SeatController::class);

    Route::resource('screenings', ScreeningController::class);

    Route::resource('purchases', PurchaseController::class)->except(['edit', 'update']);

    Route::resource('movies', MovieController::class);

    Route::resource('genres', GenreController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('users', UserController::class);

    /* Destroy photos */

    Route::delete('users/{user}/image', [UserController::class, 'destroyImage'])
        ->name('users.image.destroy')
        ->can('update', User::class);

    Route::delete('theaters/{theater}/image', [TheaterController::class, 'destroyImage'])
        ->name('theaters.image.destroy')
        ->can('update', Theater::class);

    Route::delete('movies/{movie}/image', [MovieController::class, 'destroyImage'])
        ->name('movies.image.destroy')
        ->can('update', Movie::class);

    Route::delete('customers/{customer}/image', [CustomerController::class, 'destroyImage'])
        ->name('customers.image.destroy')
        ->can('update', Customer::class);

    Route::get('configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
    Route::put('configurations', [ConfigurationController::class, 'update'])->name('configurations.update');


});

Route::get('movies/showcase', [MovieController::class, 'showcase'])->name('movies.showcase');

Route::get('cart/show', [CartController::class, 'show'])->name('cart.show');

Route::post('cart', [CartController::class, 'confirm'])
    ->name('cart.confirm')
    ->can('confirmCart');

Route::middleware('can:useCart')->group(function () {
    Route::post('cart/{screening}/{seat}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::delete('cart/{screening}/{seat}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');

    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');

    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});

require __DIR__ . '/auth.php';
