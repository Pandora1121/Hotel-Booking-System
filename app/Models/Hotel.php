<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'tbl_hotels';

    protected $fillable = [
        'name', 'slug', 'city', 'address', 'description', 'image', 'rating', 'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class, 'hotel_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }
}