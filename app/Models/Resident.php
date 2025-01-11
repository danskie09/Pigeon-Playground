<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    //

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'civil_status',
        'address',
        'contact_number',
        'email'
    ];
}
