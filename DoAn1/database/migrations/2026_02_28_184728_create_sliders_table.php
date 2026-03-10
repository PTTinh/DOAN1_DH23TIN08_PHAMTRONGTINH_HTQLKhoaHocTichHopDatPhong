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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id('slider_id');
            $table->string('title');
            $table->string('description', 1000)->nullable();
            $table->string('image_url');
            $table->string('link_url')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->timestamps();
            $table->index('position', 'idx_sliders_position');
            $table->index(['is_active', 'start_date', 'end_date'], 'idx_sliders_active_dates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
