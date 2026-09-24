<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'tbl_rooms';

    protected $fillable = [
        'hotel_id', 'room_type_id', 'room_number', 'status', 'image', 'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}