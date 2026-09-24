<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('tbl_hotels')->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained('tbl_room_types')->cascadeOnDelete();
            $table->string('room_number');
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->string('image')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();

            $table->unique(['hotel_id', 'room_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_rooms');
    }
};