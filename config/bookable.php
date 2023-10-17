<?php

return [
    /**
     * Use uuid as primary key.
     */
    'uuids' => false,

    /*
   * User tables foreign key name.
   */
    'user_foreign_key' => 'user_id',

    /*
    * Table name for booking records.
    */
    'bookings_table' => 'bookings',

    /*
   * Model name for booking record.
   */
    'booking_model' => \Mellaoui\Bookable\Models\Booking::class,

    /*
   * Model name for booker.
   */
    'user_model' => class_exists(\App\Models\User::class) ? \App\Models\User::class : null,
];
