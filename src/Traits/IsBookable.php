<?php

namespace Mellaoui\Bookable\Traits;

use Mellaoui\Bookable\Models\Booking;

trait IsBookable
{
    public function bookings(){
        return $this->morphMany(Booking::class, 'bookable');
    }

}