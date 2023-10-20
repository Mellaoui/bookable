<?php

namespace Mellaoui\Bookable\Exceptions;

use Exception;

class BookableException extends Exception
{
    public static function alreadyExists(): BookableException
    {
        return new static('Bookable already exists');
    }

    public static function doesNotExist(): BookableException
    {
        return new static('Bookable does not exist');
    }

    public static function alreadyBooked(): BookableException
    {
        return new static('Bookable already booked');
    }

    public static function notBooked(): BookableException
    {
        return new static('Bookable not booked');
    }
}
