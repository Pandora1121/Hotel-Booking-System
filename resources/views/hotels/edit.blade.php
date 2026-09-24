<x-admin-layout title="Edit Hotel">
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.hotels.update', $hotel) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Nama Hotel <span class="text-[#C9A227]">*</span></label>
                <input type="text" name="name" value="{{ old('name', $hotel->name) }}" required autofocus
                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Kota <span class="text-[#C9A227]">*</span></label>
                <input type="text" name="city" value="{{ old('city', $hotel->city) }}" required
                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                @error('city') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Alamat Lengkap <span class="text-[#C9A227]">*</span></label>
                <textarea name="address" rows="3" required
                          class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">{{ old('address', $hotel->address) }}</textarea>
                @error('address') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">{{ old('description', $hotel->description) }}</textarea>
                @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Foto Hotel</label>
                @if ($hotel->image)
                    <img src="{{ asset($hotel->image) }}" class="w-32 h-20 object-cover rounded-lg mb-2 border border-gray-200">
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
                <a href="{{ route('admin.hotels.index') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>