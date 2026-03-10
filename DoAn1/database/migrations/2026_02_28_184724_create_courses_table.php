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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->decimal('price', 19, 0)->default(0);
            $table->boolean('is_price_visible')->default(true);
            $table->integer('max_students')->nullable();
            $table->date('end_registration_date')->nullable();
            $table->date('start_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('allow_overflow')->default(false)->comment('Cho phép nhận thêm học viên khi đã đủ số lượng');
            $table->timestamps();

            $table->foreign('category_id', 'fk_courses_category_id')->references('category_id')->on('categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
