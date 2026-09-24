<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::where('archived', false)->latest()->paginate(10);

        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil ditambahkan.');
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil diperbarui.');
    }

    public function destroy(Hotel $hotel)
    {
        // Soft delete sesuai standar brief: pakai field archived, bukan hapus permanen
        $hotel->update(['archived' => true]);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel berhasil dihapus.');
    }

    private function uploadImage($file): string
    {
        $filename = now()->format('YmdHis') . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/hotels'), $filename);

        return 'uploads/hotels/' . $filename;
    }
}