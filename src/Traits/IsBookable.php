<?php

namespace Mellaoui\Bookable\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mellaoui\Bookable\Exceptions\BookingException;
use Mellaoui\Bookable\Exceptions\UserException;
use Mellaoui\Bookable\Models\Booking;

trait IsBookable
{
    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function book(Authenticatable $user): Booking
    {
        if (!$user->exists) {
            throw UserException::doesNotExist();
        }

        if ($this->isBookedBy($user)) {
            throw BookingException::alreadyExists();
        }

        $booking = new Booking();

        $booking->user()->associate($user);

        $this->bookings()->save($booking);

        return $booking;
    }

    public function unbook(): void
    {
        if (!$this->isBooked()) {
            throw BookingException::doesNotExist();
        }

        $this->bookings()->delete();
    }

    public function isBooked(): bool
    {
        return $this->bookings()->exists();
    }

    // Untested
    public function isBookedBy(Authenticatable $user): bool
    {
        if (!$user->exists) {
            throw UserException::doesNotExist();
        }

        return $this->bookings()
            ->where('user_id', $user->id)
            ->exists();
    }

    // public function isAvailable(DateTime $startDate, DateTime $endDate): bool
    // {
    //     return !$this->bookings()
    //         ->where('start_date', '<=', $endDate)
    //         ->where('end_date', '>=', $startDate)
    //         ->exists();
    // }
}
