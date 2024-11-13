<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //



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
}
