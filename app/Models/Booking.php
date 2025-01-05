<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    protected $fillable = [
        'room_id',
        'booking_number',
        'user_id',
        'check_in',
        'check_out',
        'adult',
        'kids',
        'payment_method',
        'special_request',
        'total_amount',
        'status'
    ];

    /**
     * Generate the next booking number
     *
     * @return string
     */
    public static function generateBookingNumber()
    {
        $latest = self::latest()->first();
        $number = $latest ? intval(substr($latest->booking_number, -10)) + 1 : 1;
        return 'PGR-BK-' . str_pad($number, 10, '0', STR_PAD_LEFT);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id');
    }
}
