<x-admin-layout title="Tambah Tipe Kamar">
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.room-types.store') }}" enctype="multipart/form-data" class="space-y-5">
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
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Nama Tipe Kamar <span class="text-[#C9A227]">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Deluxe Room"
                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#12202B] mb-1.5">Harga / Malam (Rp) <span class="text-[#C9A227]">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="500000"
                           class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    @error('price') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#12202B] mb-1.5">Kapasitas (orang) <span class="text-[#C9A227]">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', 2) }}" required min="1"
                           class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    @error('capacity') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Fasilitas & keterangan tipe kamar"
                          class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Foto Tipe Kamar</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#12202B] file:text-white file:text-sm">
                <p class="mt-1.5 text-xs text-gray-400">Format JPG/PNG/WEBP, maksimal 2MB.</p>
                @error('image') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                    Simpan
                </button>
                <a href="{{ route('admin.room-types.index') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>