<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'adult' => 'required|integer|min:1',
            'kids' => 'nullable|integer|min:0',
            'payment_method' => 'required|string',
            'proof' => 'nullable|string',
            'special_request' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Check if the room is already booked within the specified date range
        $existingBooking = Booking::where('room_id', $validatedData['room_id'])
            ->where('status', '!=', 'cancelled') // Assuming cancelled bookings make the room available again
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('check_in', [$validatedData['check_in'], $validatedData['check_out']])
                    ->orWhereBetween('check_out', [$validatedData['check_in'], $validatedData['check_out']])
                    ->orWhere(function ($query) use ($validatedData) {
                        $query->where('check_in', '<=', $validatedData['check_in'])
                            ->where('check_out', '>=', $validatedData['check_out']);
                    });
            })
            ->exists();

        // If a booking exists, show an error
        if ($existingBooking) {
            return redirect()->back()->withErrors('The room is not available for the selected dates.');
        }

        // Create a new booking instance
        $booking = new Booking();
        $booking->room_id = $validatedData['room_id'];
        $booking->user_id = Auth::user()->id;
        $booking->check_in = $validatedData['check_in'];
        $booking->check_out = $validatedData['check_out'];
        $booking->adult = $validatedData['adult'];
        $booking->kids = $validatedData['kids'];
        $booking->payment_method = $validatedData['payment_method'];
        $booking->proof = $validatedData['proof'] ?? "With Proof";
        $booking->special_request = $validatedData['special_request'];
        $booking->total_amount = $validatedData['total_amount'];
        $booking->status = "pending";

        // Save the booking and handle potential errors
        if ($booking->save()) {
            return redirect()->back()->with('message', 'Booking created successfully');
        } else {
            return redirect()->back()->withErrors('Failed to create booking. Please try again.');
        }
    }


    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $existingBooking = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                    });
            })
            ->exists();

        return response()->json([
            'available' => !$existingBooking,
            'message' => $existingBooking ? 'Room is not available for the selected dates.' : 'Room is available.',
        ]);
    }
}
