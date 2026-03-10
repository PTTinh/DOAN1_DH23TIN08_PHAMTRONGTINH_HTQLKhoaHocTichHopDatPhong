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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id');
            $table->string('name', 100);
            $table->integer('capacity');
            $table->string('location', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 19, 0)->default(0);        
            $table->enum('status', ['available', 'maintenance', 'unavailable'])->default('available');
            $table->string('image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
