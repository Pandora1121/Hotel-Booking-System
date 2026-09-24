<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['hotel', 'roomType'])->where('archived', false)->latest()->paginate(10);

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::where('archived', false)->orderBy('name')->get();
        $roomTypes = RoomType::where('archived', false)->orderBy('name')->get();

        return view('rooms.create', compact('hotels', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id'     => 'required|exists:tbl_hotels,id',
            'room_type_id' => 'required|exists:tbl_room_types,id',
            'room_number'  => 'required|string|max:50',
            'status'       => 'required|in:available,booked,maintenance',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::where('archived', false)->orderBy('name')->get();
        $roomTypes = RoomType::where('archived', false)->orderBy('name')->get();

        return view('rooms.edit', compact('room', 'hotels', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'hotel_id'     => 'required|exists:tbl_hotels,id',
            'room_type_id' => 'required|exists:tbl_room_types,id',
            'room_number'  => 'required|string|max:50',
            'status'       => 'required|in:available,booked,maintenance',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->update(['archived' => true]);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }

    private function uploadImage($file): string
    {
        $filename = now()->format('YmdHis') . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/rooms'), $filename);

        return 'uploads/rooms/' . $filename;
    }
}