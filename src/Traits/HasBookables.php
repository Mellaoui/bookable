<?php

namespace Mellaoui\Bookable\Traits;

use Mellaoui\Bookable\Models\Booking;

trait HasBookables
{
    public function bookings(){
        return $this->hasMany(Booking::class);
    }

}