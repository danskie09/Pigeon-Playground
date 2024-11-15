<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adult' => 'required|integer|min:1',
            'kids' => 'nullable|integer|min:0',
            'payment_method' => 'required|string',
            'special_request' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'adult' => $request->adult,
                'kids' => $request->kids,
                'payment_method' => $request->payment_method,
                'special_request' => $request->special_request,
                'total_amount' => $request->total_amount,
                'status' => 'pending'
            ]);

            // Attach all selected rooms to the booking
            $booking->rooms()->attach($request->room_ids);

            DB::commit();
            return redirect()->back()->with('success', 'Booking completed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to complete booking. Please try again.');
        }
    }


    // In your BookingController

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_ids' => 'required|array',
            'room_ids.*' => 'exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in'
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        // Check each requested room for existing bookings in the date range
        foreach ($request->room_ids as $roomId) {
            $existingBooking = Booking::whereHas('rooms', function ($query) use ($roomId) {
                $query->where('rooms.id', $roomId);
            })
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->where(function ($q) use ($checkIn, $checkOut) {
                        // Check if there's any overlap with existing bookings
                        $q->whereBetween('check_in', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out', [$checkIn, $checkOut])
                            ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                $q->where('check_in', '<=', $checkIn)
                                    ->where('check_out', '>=', $checkOut);
                            });
                    });
                })
                ->first();

            if ($existingBooking) {
                return response()->json([
                    'available' => false,
                    'message' => 'Some selected rooms are not available for these dates.'
                ]);
            }
        }

        return response()->json([
            'available' => true,
            'message' => 'All selected rooms are available for booking!'
        ]);
    }



    public function show()
    {

        $bookings = Booking::with(['user', 'rooms'])->get();
        return view('staff.bookings', compact('bookings'));
    }
}
