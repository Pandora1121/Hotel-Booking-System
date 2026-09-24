<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained('tbl_users')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('tbl_rooms')->cascadeOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedInteger('total_nights');
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'completed', 'cancelled'])
                  ->default('pending');
            $table->text('notes')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_bookings');
    }
};