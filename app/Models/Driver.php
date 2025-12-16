<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function region() {
    return $this->belongsTo(Region::class);
}

public function office() {
    return $this->belongsTo(Office::class);
}
}
