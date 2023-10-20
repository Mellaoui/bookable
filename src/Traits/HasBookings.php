<?php

namespace Mellaoui\Bookable\Traits;

use DateTime;
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

    /**
     * @throws BookableException|BookingException
     */
    public function book(Model $bookable, DateTime $start_at, DateTime $end_at = null): void
    {
        if ($bookable->isBooked()) {
            throw BookableException::alreadyBooked();
        }

        if (! $bookable->exists) {
            throw BookableException::doesNotExist();
        }

        if ($start_at < now() || $end_at < now() || $start_at > $end_at) {
            throw BookingException::invalidDates();
        }

        $this->bookings()->save($bookable->bookings()->make([
            'start_at' => $start_at,
            'end_at' => $end_at,
        ]));
    }

    /**
     * @throws BookableException|BookerException|BookingException
     */
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
