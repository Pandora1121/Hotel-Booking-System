<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Booking</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                @forelse ($bookings as $booking)
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-[#12202B]">{{ $booking->room->hotel->name }} — {{ $booking->room->roomType->name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $booking->check_in->translatedFormat('j M Y') }} – {{ $booking->check_out->translatedFormat('j M Y') }}
                                · {{ $booking->booking_code }}
                            </p>
                        </div>
                        <div class="text-right">
                            @php
                                $badge = match($booking->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'confirmed', 'checked_in' => 'bg-blue-50 text-blue-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($booking->status) }}</span>
                            <p class="text-sm text-gray-600 mt-1">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <a href="{{ route('booking.invoice', $booking) }}" class="inline-block mt-2 text-xs text-[#12202B] hover:text-[#C9A227] font-medium underline">
                                Download Invoice
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="p-10 text-center text-gray-400">Kamu belum pernah booking.</p>
                @endforelse
            </div>

            <div class="mt-4">{{ $bookings->links() }}</div>
        </div>
    </div>
</x-app-layout>