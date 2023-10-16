<?php

namespace Mellaoui\Bookable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mellaoui\Bookable\Exceptions\BookableException;
use Mellaoui\Bookable\Exceptions\BookerException;
use Mellaoui\Bookable\Exceptions\BookingException;
use Mellaoui\Bookable\Models\Booking;

trait HasBookings
{
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function book(Model $bookable, \DateTimeInterface $start_date, \DateTimeInterface $end_date): void
    {
        if ($bookable->isBooked()) {
            throw BookableException::alreadyBooked();
        }

        if (! $bookable->exists) {
            throw BookableException::doesNotExist();
        }

        if ($start_date > $end_date) {
            throw BookingException::invalidDates();
        }

        $this->bookings()->save($bookable->bookings()->make([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]));
    }

    // untested
    public function unbook(Model $bookable): void
    {
        if (! $bookable->isBooked()) {
            throw BookableException::notBooked();
        }

        if (! $this->bookings()->where('bookable_id', $bookable->id)->exists()) {
            throw BookerException::notBookedByUser();
        }

        if (! Booking::where('bookable_id', $bookable->id)->exists()) {
            throw BookingException::doesNotExist();
        }

        $bookable->bookings()->where('bookable_id', $bookable->id)->delete();
    }
}
