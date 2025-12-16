<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
      protected $fillable = [
        'region_id',
        'name',
        'code',
        'type',
        'address',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
