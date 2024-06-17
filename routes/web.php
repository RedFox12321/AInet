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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

use App\Http\Middleware\PaymentSanitizer;
use App\Models\Theater;
use App\Models\Movie;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Customer;
use App\Models\Purchase;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Profiler\Profile;

/* Brezee Routes */

Route::redirect('/', '/movies/showcase');

/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/* ----- Verified users ----- */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /* User made Routes */
    Route::resource('tickets', TicketController::class)->only(['show', 'index', 'update']);

    Route::resource('theaters', TheaterController::class);

    Route::resource('seats', SeatController::class);

    Route::resource('screenings', ScreeningController::class)->except(['index', 'show']);

    Route::resource('purchases', PurchaseController::class)->only(['show', 'index']);

    Route::resource('movies', MovieController::class)->except('show');

    Route::resource('genres', GenreController::class);

    Route::resource('users', UserController::class);

    Route::resource('admins', AdminController::class);

    Route::resource('employees', EmployeeController::class);

    Route::resource('customers', CustomerController::class);


    /* My routes */
    Route::get('purchases/my', [PurchaseController::class, 'myPurchases'])
        ->name('purchases.my')
        ->can('viewMy', Purchase::class);

    Route::get('tickets/my', [TicketController::class, 'myTickets'])
        ->name('tickets.my')
        ->can('viewMy', Ticket::class);


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

    Route::delete('profile/{user}/image', [ProfileController::class, 'destroyImage'])
        ->name('profile.image.destroy')
        ->can('update', User::class);


    // Configuration
    Route::middleware('can:admin')->group(function () {
        Route::get('/configurations/edit', [ConfigurationController::class, 'edit'])->name('configurations.edit');
        Route::put('/configurations', [ConfigurationController::class, 'update'])->name('configurations.update');
    });
});

/* PUBLIC ROUTES */
// Storage routing to get private files
Route::get('storage/pdf/{pdf}', function ($pdf) {
    $path = storage_path('app/pdf_purchases/' . $pdf);
    if (!Storage::exists('pdf_purchases/' . $pdf)) {
        abort(404);
    }
    return response()->file($path);
})
    ->name('storage.pdf')
    ->can('viewPDF', Purchase::class);

Route::get('storage/qrcode/{qrcode}', function ($qr_code) {
    if (!Storage::exists('ticket_qrcodes/' . $qr_code)) {
        abort(404);
    }
    $file = Storage::get('ticket_qrcodes/' . $qr_code);

    return Response::make($file, 200, ['Content-Type' => 'image/png']);
})
    ->name('storage.qrcode')
    ->can('viewQRCode', Ticket::class);


// Resource public routes
Route::get('movies/showcase', [MovieController::class, 'showcase'])->name('movies.showcase');
Route::resource('movies', MovieController::class)->only('show');
Route::resource('screenings', ScreeningController::class)->only(['index', 'show']);

// Cart
Route::middleware('can:useCart')->group(function () {
    Route::post('cart/{screening}/{seat}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::delete('cart/{screening}/{seat}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');

    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])
        ->name('cart.show');

    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])
        ->name('cart.destroy');


    Route::post('cart', [CartController::class, 'confirm'])
        ->name('cart.confirm')
        ->middleware(PaymentSanitizer::class)
        ->can('confirmCart');
});

require __DIR__ . '/auth.php';
