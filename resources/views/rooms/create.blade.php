<x-admin-layout title="Tambah Kamar">
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Hotel <span class="text-[#C9A227]">*</span></label>
                <select name="hotel_id" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    <option value="">-- Pilih Hotel --</option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                    @endforeach
                </select>
                @error('hotel_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Tipe Kamar <span class="text-[#C9A227]">*</span></label>
                <select name="room_type_id" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    <option value="">-- Pilih Tipe Kamar --</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }} ({{ $type->hotel->name }})</option>
                    @endforeach
                </select>
                @error('room_type_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Nomor Kamar <span class="text-[#C9A227]">*</span></label>
                <input type="text" name="room_number" value="{{ old('room_number') }}" required autofocus placeholder="Contoh: 101"
                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                @error('room_number') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Status <span class="text-[#C9A227]">*</span></label>
                <select name="status" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Dibooking</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                </select>
                @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Foto Kamar</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#12202B] file:text-white file:text-sm">
                <p class="mt-1.5 text-xs text-gray-400">Format JPG/PNG/WEBP, maksimal 2MB.</p>
                @error('image') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                    Simpan
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>