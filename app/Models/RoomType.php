<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'tbl_room_types';

    protected $fillable = [
        'hotel_id', 'name', 'description', 'price', 'capacity', 'image', 'archived',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'archived' => 'boolean',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}