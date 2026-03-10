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
            $table->id('news_id');
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
            $table->unsignedBigInteger('news_category_id')->nullable();
            $table->timestamps();

            $table->foreign('author_id', 'fk_news_author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('news_category_id', 'fk_news_category_id')->references('news_category_id')->on('news_categories')->onDelete('set null');
            $table->index(['is_published', 'published_at', 'is_featured'], 'idx_news_published_featured');
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
