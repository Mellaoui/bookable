<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Mellaoui\Bookable\Traits\HasBookings;

class User extends Model
{
    use HasBookings;

    protected $fillable = ['name'];
}
