<?php

namespace Mellaoui\Bookable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mellaoui\Bookable\Exceptions\BookerException;
use Mellaoui\Bookable\Models\Booking;

trait IsBookable
{
    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function bookBy(Model $user): Booking
    {
        if (! $user->exists) {
            throw BookerException::doesNotExist();
        }

        if ($this->isBookedBy($user)) {
            throw BookerException::alreadyBooked();
        }

        $booking = new Booking();

        $booking->user()->associate($user);

        $this->bookings()->save($booking);

        return $booking;
    }

    public function unbookBy(Model $user): void
    {
        if (! $user->exists) {
            throw BookerException::doesNotExist();
        }

        if (! $this->isBookedBy($user)) {
            throw BookerException::notBookedByUser();
        }

        $this->bookings()->delete();
    }

    public function unbookAll(): void
    {
        $this->bookings()->delete();
    }

    public function isBooked(): bool
    {
        return $this->bookings()->exists();
    }

    public function isBookedBy(Model $user): bool
    {
        if (! $user->exists) {
            throw BookerException::doesNotExist();
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
