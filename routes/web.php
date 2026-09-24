<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('hotels', HotelController::class);
    Route::resource('room-types', RoomTypeController::class);
    Route::resource('rooms', RoomController::class);
   Route::resource('bookings', BookingController::class)->except(['create', 'store']);
});

Route::middleware(['auth'])->prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/history', [BookingController::class, 'myBookings'])->name('history');
    Route::get('/{booking}/invoice', [BookingController::class, 'downloadInvoice'])->name('invoice');
});

require __DIR__.'/auth.php';