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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500)->nullable();
            $table->string('slug', 500)->nullable();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('featured_image', 255)->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->datetime('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('seo_title', 500)->nullable();
            $table->string('seo_image', 1000)->nullable();
            $table->string('seo_description', 2000)->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('set null');
            $table->index(['is_published', 'published_at', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
