<?php

namespace Mellaoui\Bookable\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Mellaoui\Bookable\Models\Booking;

trait HasBookings
{
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function book(Booking $booking): void
    {
        if ($booking->isBooked()) {
            throw new \Exception('The booking is already booked');
        }

        $this->bookings()->save($booking);
    }

    public function unbook(Booking $booking): void
    {
        if (! $this->bookings()->where('id', $booking->id)->exists()) {
            throw new \Exception('The booking is not made by this user');
        }

        $booking->delete();
    }
}
