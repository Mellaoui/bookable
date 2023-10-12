<?php

namespace Mellaoui\Bookable\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function bookable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}