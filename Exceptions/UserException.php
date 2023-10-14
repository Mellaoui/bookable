<?php

namespace Mellaoui\Bookable\Exceptions;

use Exception;

class UserException extends Exception
{
    public static function doesNotExist()
    {
        return new static('User Does Not Exist');
    }
}
