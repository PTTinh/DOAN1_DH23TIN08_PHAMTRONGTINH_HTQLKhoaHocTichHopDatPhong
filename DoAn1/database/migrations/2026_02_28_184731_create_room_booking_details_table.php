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
        Schema::create('room_booking_details', function (Blueprint $table) {
            $table->id('booking_detail_id');
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->boolean('cancelled_by_customer')->default(false);
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->boolean('is_duplicate')->default(false);
            $table->timestamps();
            $table->foreign('approved_by', 'fk_room_booking_details_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by', 'fk_room_booking_details_rejected_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cancelled_by', 'fk_room_booking_details_cancelled_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('booking_id', 'fk_room_booking_details_booking_id')->references('booking_id')->on('room_bookings')->onDelete('cascade');
            $table->index(['booking_id', 'booking_date'], 'idx_room_booking_details_booking_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_booking_details');
    }
};
