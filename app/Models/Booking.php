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
        'user_id',
        'check_in',
        'check_out',
        'adult',
        'kids',
        'payment_method',
        'proof',
        'special_request',
        'total_amount',
        'status',
    ];



    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id');
    }
}
