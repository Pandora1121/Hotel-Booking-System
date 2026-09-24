<x-admin-layout title="Ubah Status Booking">
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-lg">
        <div class="mb-6 text-sm text-gray-600 space-y-1">
            <p><span class="text-gray-400">Kode:</span> <span class="font-medium text-[#12202B]">{{ $booking->booking_code }}</span></p>
            <p><span class="text-gray-400">Tamu:</span> {{ $booking->user->name }}</p>
            <p><span class="text-gray-400">Kamar:</span> {{ $booking->room->hotel->name }} · {{ $booking->room->room_number }}</p>
            <p><span class="text-gray-400">Tanggal:</span> {{ $booking->check_in->translatedFormat('j M Y') }} – {{ $booking->check_out->translatedFormat('j M Y') }}</p>
            <p><span class="text-gray-400">Total:</span> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
        </div>

        <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Status Booking <span class="text-[#C9A227]">*</span></label>
                <select name="status" required
                        class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $booking->status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                    Perbarui Status
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>