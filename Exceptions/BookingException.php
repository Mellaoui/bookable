<?php

namespace Mellaoui\Bookable\Exceptions;

use Exception;

class BookingException extends Exception
{
  public static function alreadyExists()
  {
    return new static('This booking is already made');
  }

  public static function doesNotExist()
  {
    return new static('This booking does not exist');
  }
}
