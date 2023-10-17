<?php

namespace Mellaoui\Bookable\Traits;

use DateTime;
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

    /**
     * @throws BookerException
     */
    public function bookBy(Model $user, DateTime $start_at, DateTime $end_at): Booking
    {
        if (!$user->exists) {
            dd('we here');
            throw BookerException::doesNotExist();
        }

        if ($this->isBookedBy($user)) {
            throw BookerException::alreadyBooked();
        }

        $booking = new Booking([
            'start_at' => $start_at,
            'end_at' => $end_at,
        ]);

        $booking->user()->associate($user);

        $this->bookings()->save($booking);

        return $booking;
    }

    /**
     * @throws BookerException
     */
    public function unbookBy(Model $user): void
    {
        if (!$user->exists) {
            throw BookerException::doesNotExist();
        }

        if (!$this->isBookedBy($user)) {
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

    /**
     * @throws BookerException
     */
    public function isBookedBy(Model $user): bool
    {
        if (!$user->exists) {
            throw BookerException::doesNotExist();
        }

        return $this->bookings()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * @throws BookerException
     */
    public function getDurationFor(Model $user): DateTime
    {
        if (!$user->exists) {
            throw BookerException::doesNotExist();
        }

        if (!$this->isBookedBy($user)) {
            throw BookerException::notBookedByUser();
        }

        $booking = $this->bookings()
            ->where('status', '!=', 'canceled')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return
            $booking->start_at->diff($booking->end_at);
    }
}
