<?php

namespace Mellaoui\Bookable\Interfaces;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Mellaoui\Bookable\Models\Booking;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface UsePointBooking
{
    public function bookings(): MorphMany;
    public function bookBy(Model $user, DateTime $start_at): Booking;
    public function unbookBy(Model $user): void;
    public function unbookAll(): void;
    public function isBooked(): bool;
    public function isBookedBy(Model $user): bool;
}
