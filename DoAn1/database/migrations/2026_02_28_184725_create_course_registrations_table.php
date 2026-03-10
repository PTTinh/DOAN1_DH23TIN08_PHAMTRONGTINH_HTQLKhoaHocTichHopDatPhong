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
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id('registration_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('registration_date')->useCurrent();
            $table->string('student_name');
            $table->string('student_email')->nullable();
            $table->string('student_phone');
            $table->string('student_address')->nullable()->default(null);
            $table->date('student_birth_date')->nullable();
            $table->string('student_gender')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->decimal('actual_price', 15, 0)->nullable()->comment('Số tiền đã thu của học viên');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();

            $table->foreign('course_id', 'fk_course_registrations_course_id')->references('course_id')->on('courses')->onDelete('cascade');
            $table->foreign('created_by', 'fk_course_registrations_created_by')->references('id')->on('users')->onDelete('set null');
            $table->index('student_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
