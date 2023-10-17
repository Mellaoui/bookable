<?php

namespace Mellaoui\Bookable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    public $appends = ['bookingsCount'];

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('bookable.bookings_table');

        parent::__construct($attributes);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('bookable.user_model'));
    }

    // -- Scopes -- //

    public function scopeIsCancelled(Builder $query): void
    {
        $query->where('status', 'cancelled');
    }

    public function scopeIsPending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    public function scopeIsConfirmed(Builder $query): void
    {
        $query->where('status', 'confirmed');
    }
}
