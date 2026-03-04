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
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image', 255)->nullable();
            $table->decimal('price', 19, 0)->default(0);
            $table->boolean('is_price_visible')->default(true);
            $table->unsignedBigInteger('category_id');
            $table->date('end_registration_date')->nullable();
            $table->date('start_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('max_students')->nullable();
            $table->boolean('allow_overflow')->default(false)->comment('Cho phép nhận thêm học viên khi đã đủ số lượng');
            $table->timestamps();
            $table->string('seo_description', 2000)->nullable();
            $table->string('seo_title', 500)->nullable();
            $table->string('seo_image', 1000)->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
