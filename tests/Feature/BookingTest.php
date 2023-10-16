<?php

namespace Tests\Feature;

test('bookable model can be booked by a user', function () {
    $user = \Tests\User::create(['name' => 'Mohamed']);
    $room = \Tests\Room::create(['number' => 1]);

    expect($room->isBooked())->toBeFalse();

    $room->bookBy($user);

    expect($room->isBooked())->toBeTrue();
    expect($room->isBookedBy($user))->toBeTrue();
});

test('user can book a bookable model', function () {
    $user = \Tests\User::create(['name' => 'Mohamed']);
    $room = \Tests\Room::create(['number' => 1]);

    $user->book($room, now(), now()->addDay());

    expect($user->bookings->count())->toBe(1);
});

test('user can unbook a booking', function () {
    $user = \Tests\User::create(['name' => 'Mohamed']);
    $room = \Tests\Room::create(['number' => 1]);

    $booking = $user->book($room, now(), now()->addDay());

    expect($user->bookings->count())->toBe(1);

    $user->unbook($booking);

    expect($user->bookings->count())->toBe(0);
});
