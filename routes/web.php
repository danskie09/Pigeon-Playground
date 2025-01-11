<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Secretary;
use App\Http\Controllers\ResidentController;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/addBook', function () {
    $rooms = \App\Models\Room::all();
    return view('staff.addBook', ['rooms' => $rooms]);
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
Route::get('/calendar', [BookingController::class, 'showCalendar'])->name('bookings.calendar');


Route::patch('/booking/approved/{id}', [BookingController::class, 'approved'])->name('bookings.approved');


Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('check.availability');
Route::get('/entrance-fees', [BookingController::class, 'getEntranceFees'])->name('entrance.fees');





//Secretary Routes
Route::get('/secretary/residents', [Secretary::class, 'show'])->name('secretary.residents');
Route::get('secretary/dashboard', [Secretary::class, 'dashboard'])->name('secretary.dashboard');
Route::get('secretary/activity', [Secretary::class, 'activity'])->name('secretary.activity');
Route::get('/residents/{id}', [ResidentController::class, 'show'])->name('residents.show');

Route::post('/secretary/residents', [ResidentController::class, 'store'])->name('secretary.residents.store');


require __DIR__ . '/auth.php';
