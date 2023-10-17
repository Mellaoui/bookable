<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('booking.bookings_table'), function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger(config('booking.user_foreign_key'))->index()->comment('user_id');
            $table->morphs('bookable');

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();

            // $table->index(['bookable_id', 'bookable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('booking.bookings_table'));
    }
};
