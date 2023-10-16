<?php

namespace Mellaoui\Bookable\Exceptions;

use Exception;

class BookerException extends Exception
{
    public static function doesNotExist(): BookerException
    {
        return new static('User Does Not Exist');
    }

    public static function alreadyBooked(): BookerException
    {
        return new static('Bookable already booked');
    }

    public static function notBookedByUser(): BookerException
    {
        return new static('Bookable not booked by this user');
    }
}
