<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\EntranceFee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'adult' => 'required|integer|min:1',
            'kids' => 'nullable|integer|min:0',
            'payment_method' => 'required|string',
            'special_request' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        DB::beginTransaction();
        try {

            // Create or find user based on email
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => bcrypt(Str::random(16)) // Generate random password
                ]
            );

            // Generate booking number
            $bookingNumber = Booking::generateBookingNumber();

            // Create the booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'booking_number' => $bookingNumber,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'adult' => $request->adult,
                'kids' => $request->kids,
                'payment_method' => $request->payment_method,
                'special_request' => $request->special_request,
                'total_amount' => $request->total_amount,
                'status' => 'approved'
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


    

    public function approved(Booking $id)
    {
        $id->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Booking approved successfully!');
    }




    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_ids' => 'required|array',
            'room_ids.*' => 'exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in'
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
                        $q->where(function ($q) use ($checkIn, $checkOut) {
                            $q->where('check_in', '<', $checkOut)
                              ->where('check_out', '>', $checkIn);
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

    public function getEntranceFees()
    {
        $adultFee = EntranceFee::where('type', 'adult')->first();
        $kidFee = EntranceFee::where('type', 'kid')->first();
        
        return response()->json([
            'adult_rate' => $adultFee ? $adultFee->price : 0,
            'child_rate' => $kidFee ? $kidFee->price : 0
        ]);
    }





    public function show()
    {

        $bookings = Booking::with(['user', 'rooms'])->get();
        return view('staff.bookings', compact('bookings'));
    }



    public function showCalendar(){
        $bookings = Booking::with(['user', 'rooms'])->get();
        return view('staff.calendar', compact('bookings'));
    }
}
