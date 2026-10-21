<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Hero banner --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 px-8 py-10">
                <div class="absolute -right-10 -top-16 w-72 h-72 rounded-full bg-blue-400/20 pointer-events-none"></div>
                <div class="absolute right-20 bottom-[-70px] w-48 h-48 rounded-full bg-blue-300/10 pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <p class="text-blue-200 text-sm">{{ now()->translatedFormat('l, j F Y') }}</p>
                        <h1 class="font-display text-2xl md:text-3xl font-bold text-white mt-1">
                            Halo, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p class="text-blue-100 mt-2 max-w-md">
                            Cari kamar impianmu dan mulai pesan sekarang di Kirana Hotel &amp; Resort.
                        </p>
                    </div>
                    <a href="{{ route('booking.create') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-6 py-3 rounded-xl hover:bg-blue-50 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Booking Sekarang
                    </a>
                </div>
            </div>

            {{-- Quick stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <p class="text-slate-500 text-sm">Total Booking</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $bookings->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <p class="text-slate-500 text-sm">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">
                        {{ $bookings->whereIn('status', ['pending', 'confirmed', 'checked_in'])->count() }}
                    </p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <p class="text-slate-500 text-sm">Selesai</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">
                        {{ $bookings->where('status', 'completed')->count() }}
                    </p>
                </div>
            </div>

            {{-- Recent bookings --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-bold text-slate-900">Riwayat Booking Terakhir</h3>
                    <a href="{{ route('booking.history') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat semua →
                    </a>
                </div>

                @if ($bookings->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-slate-500">Kamu belum punya riwayat booking.</p>
                        <a href="{{ route('booking.create') }}" class="inline-block mt-3 text-blue-600 font-medium hover:text-blue-700">
                            Mulai booking kamar pertamamu →
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($bookings as $booking)
                            @php
                                $statusStyle = match($booking->status) {
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'confirmed' => 'bg-blue-50 text-blue-700',
                                    'checked_in' => 'bg-indigo-50 text-indigo-700',
                                    'completed' => 'bg-emerald-50 text-emerald-700',
                                    'cancelled' => 'bg-red-50 text-red-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                                $statusLabel = match($booking->status) {
                                    'pending' => 'Pending',
                                    'confirmed' => 'Dikonfirmasi',
                                    'checked_in' => 'Check-in',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    default => ucfirst($booking->status),
                                };
                            @endphp
                            <div class="flex items-center justify-between py-4">
                                <div>
                                    <p class="font-medium text-slate-900">{{ $booking->booking_code }}</p>
                                    <p class="text-sm text-slate-500 mt-0.5">
                                        {{ $booking->check_in->translatedFormat('j M Y') }} — {{ $booking->check_out->translatedFormat('j M Y') }}
                                    </p>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusStyle }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>