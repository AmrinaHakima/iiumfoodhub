<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () { return redirect('/login'); });

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Main App Routes
Route::middleware(['auth'])->group(function () {
    // Screen 1: Cafe Selection
    Route::get('/foodhub', [AuthController::class, 'index'])->name('foodhub');
    
    // Screen 2: Menu
    Route::get('/cafe/{id}/menu', [AuthController::class, 'showMenu'])->name('cafe.menu');
    
    // Screens 3-5: Placing Order
    Route::post('/place-order', [AuthController::class, 'placeOrder'])->name('order.place');
    
    // Screen 6: Order Confirmed
    Route::get('/order-success/{id}', [AuthController::class, 'orderSuccess'])->name('order.success');
});