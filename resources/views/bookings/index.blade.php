<x-admin-layout title="Data Booking">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Total {{ $bookings->total() }} booking</p>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium">Kode</th>
                    <th class="px-6 py-3 font-medium">Tamu</th>
                    <th class="px-6 py-3 font-medium">Kamar</th>
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium">Total</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 font-medium text-[#12202B]">{{ $booking->booking_code }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->room->hotel->name }} · {{ $booking->room->room_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->check_in->translatedFormat('j M Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($booking->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'confirmed', 'checked_in' => 'bg-blue-50 text-blue-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-[#12202B] hover:text-[#C9A227] font-medium">Ubah Status</a>
                            <a href="{{ route('booking.invoice', $booking) }}" class="text-gray-500 hover:text-[#12202B] font-medium">Invoice</a>
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada data booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>
</x-admin-layout>