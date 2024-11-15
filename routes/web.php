<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $rooms = \App\Models\Room::all();
    return view('book', ['rooms' => $rooms]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/showbook', [BookingController::class, 'show'])->name('bookings.show');
Route::post('/get-room-prices', [RoomController::class, 'getRoomPrices'])->name('get.room.prices');


Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('check.availability');


require __DIR__ . '/auth.php';
