<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use Laravel\Fortify\Features;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return Inertia::render('welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


Route::middleware('auth')->get('/dashboard', function () {
    return inertia('dashboard/index');
})->name('dashboard');

Route::middleware('auth')->group(function () {  

    Route::get('/booking', [DashboardController::class, 'bookings'])
        ->name('dashboard.bookings');
     Route::get('/booking/create', [DashboardController::class, 'createbooking'])
        ->name('dashboard.bookings');
    Route::get('/driver', [DashboardController::class, 'driver'])
        ->name('dashboard.driver');
});


Route::get('/vehicle', [VehicleController::class, 'index'])
    ->name('vehicle.index');

require __DIR__.'/settings.php';
