<x-admin-layout title="Dashboard Admin">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500 mb-1">Total Hotel</p>
            <p class="font-display text-2xl text-[#12202B]">{{ $totalHotels }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500 mb-1">Total Kamar</p>
            <p class="font-display text-2xl text-[#12202B]">{{ $totalRooms }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500 mb-1">Total Booking</p>
            <p class="font-display text-2xl text-[#12202B]">{{ $totalBookings }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
            <p class="font-display text-2xl text-[#12202B]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Dari booking confirmed/completed</p>
        </div>

    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-[#12202B]">Booking Terbaru</h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium">Kode</th>
                    <th class="px-6 py-3 font-medium">Tamu</th>
                    <th class="px-6 py-3 font-medium">Hotel</th>
                    <th class="px-6 py-3 font-medium">Total</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($recentBookings as $booking)
                    <tr>
                        <td class="px-6 py-4 font-medium text-[#12202B]">{{ $booking->booking_code }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->room->hotel->name }}</td>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>