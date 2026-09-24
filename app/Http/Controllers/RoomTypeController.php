<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('hotel')->where('archived', false)->latest()->paginate(10);

        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        $hotels = Hotel::where('archived', false)->orderBy('name')->get();

        return view('room-types.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id'    => 'required|exists:tbl_hotels,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'capacity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        RoomType::create($validated);

        return redirect()->route('admin.room-types.index')->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function edit(RoomType $roomType)
    {
        $hotels = Hotel::where('archived', false)->orderBy('name')->get();

        return view('room-types.edit', compact('roomType', 'hotels'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'hotel_id'    => 'required|exists:tbl_hotels,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'capacity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $roomType->update($validated);

        return redirect()->route('admin.room-types.index')->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->update(['archived' => true]);

        return redirect()->route('admin.room-types.index')->with('success', 'Tipe kamar berhasil dihapus.');
    }

    private function uploadImage($file): string
    {
        $filename = now()->format('YmdHis') . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/room_types'), $filename);

        return 'uploads/room_types/' . $filename;
    }
}