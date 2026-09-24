<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center justify-between">
                <p class="text-gray-600">Cari kamar dan mulai pesan sekarang.</p>
                <a href="{{ route('booking.create') }}"
                   class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                    Booking Sekarang
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Riwayat Booking Terakhir</h3>
                @forelse ($bookings as $booking)
                    <div class="border-b py-2">
                        {{ $booking->booking_code }} — Status: {{ $booking->status }}
                    </div>
                @empty
                    <p class="text-gray-500">Kamu belum pernah booking.</p>
                @endforelse
                <a href="{{ route('booking.history') }}" class="inline-block mt-4 text-sm text-[#12202B] hover:text-[#C9A227] font-medium">
                    Lihat semua riwayat →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>