<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingLog extends Model
{
     protected $fillable = [
        'booking_id',
        'user_id',
        'action',
        'note',
    ];

    public function booking()
    {
        return $this->belongsTo(VehicleBooking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
