<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Mellaoui\Bookable\Traits\IsBookable;

class Room extends Model
{
    use IsBookable;

    protected $fillable = ['number'];
}
