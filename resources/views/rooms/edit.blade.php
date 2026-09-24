<x-admin-layout title="Edit Kamar">
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Hotel <span class="text-[#C9A227]">*</span></label>
                <select name="hotel_id" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                    @endforeach
                </select>
                @error('hotel_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Tipe Kamar <span class="text-[#C9A227]">*</span></label>
                <select name="room_type_id" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }} ({{ $type->hotel->name }})</option>
                    @endforeach
                </select>
                @error('room_type_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Nomor Kamar <span class="text-[#C9A227]">*</span></label>
                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required autofocus
                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                @error('room_number') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Status <span class="text-[#C9A227]">*</span></label>
                <select name="status" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Dibooking</option>
                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                </select>
                @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Foto Kamar</label>
                @if ($room->image)
                    <img src="{{ asset($room->image) }}" class="w-32 h-20 object-cover rounded-lg mb-2 border border-gray-200">
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#12202B] file:text-white file:text-sm">
                <p class="mt-1.5 text-xs text-gray-400">Kosongkan kalau tidak ingin mengganti foto.</p>
                @error('image') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                    Perbarui
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>