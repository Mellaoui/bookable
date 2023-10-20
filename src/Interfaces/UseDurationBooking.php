<?php

namespace Mellaoui\Bookable\Interfaces;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mellaoui\Bookable\Models\Booking;

interface UseDurationBooking
{
    public function bookings(): MorphMany;

    public function bookBy(Model $user, DateTime $start_at, DateTime $end_at): Booking;

    public function unbookBy(Model $user): void;

    public function unbookAll(): void;

    public function isBooked(): bool;

    public function isBookedBy(Model $user): bool;

    public function getDurationFor(Model $user): DateTime;
}
