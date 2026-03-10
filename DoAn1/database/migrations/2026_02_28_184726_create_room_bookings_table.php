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
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('reason')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled_by_customer', 'cancelled_by_admin'])->default('pending');
            $table->unsignedInteger('participants_count')->nullable()->default(0);
            $table->string('notes', 500)->nullable();
            $table->string('booking_code', 50)->nullable()->unique();
            $table->json('repeat_days')->nullable()->comment('Các ngày trong tuần sẽ lặp lại (monday, tuesday, ...)');
            $table->boolean('is_duplicate')->default(false);
            $table->timestamps();

            $table->foreign('room_id', 'fk_room_bookings_room_id')->references('room_id')->on('rooms')->onDelete('set null');
            $table->foreign('approved_by', 'fk_room_bookings_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by', 'fk_room_bookings_rejected_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cancelled_by', 'fk_room_bookings_cancelled_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by', 'fk_room_bookings_created_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['room_id', 'start_date', 'end_date']);
            $table->index(['status', 'start_date', 'end_date']);
            $table->index(['approved_by', 'rejected_by', 'cancelled_by'], 'idx_room_bookings_approvals');
            $table->index(['created_by', 'start_date', 'end_date'], 'idx_room_bookings_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
