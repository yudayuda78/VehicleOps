<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    //
      protected $fillable = [
        'region_id',
        'vehicle_id',
        'driver_id',
        'approver_level_1_id',
        'approver_level_2_id',
        'date',
        'user_id',
        'created_by',
        'status',
    ];


      public function requester()
    {
        return $this->belongsTo(User::class, 'user_id'); // user_id = pemesan
    }
     public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Relasi ke Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Relasi ke User yang memesan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User yang membuat record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi Approver Level 1
    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approver_level_1_id');
    }

    // Relasi Approver Level 2
    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approver_level_2_id');
    }

    // Relasi ke Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
