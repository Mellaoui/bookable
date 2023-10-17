<?php

namespace Mellaoui\Bookable\Exceptions;

use Exception;

class BookingException extends Exception
{
    public static function doesNotExist(): BookingException
    {
        return new static('Booking does not exist');
    }

    public static function alreadyMade(): BookingException
    {
        return new static('Booking already made');
    }

    public static function invalidDates(): BookingException
    {
        return new static('Booking dates are invalid');
    }
}
