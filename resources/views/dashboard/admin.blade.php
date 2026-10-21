<x-admin-layout title="Dashboard Admin">

    {{-- Banner sambutan --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-700 to-blue-900 px-8 py-10 mb-8">
    {{-- lingkaran dekoratif, dikunci di dalam container --}}
    <div class="absolute -right-10 -top-16 w-72 h-72 rounded-full bg-blue-500/20 pointer-events-none"></div>
    <div class="absolute right-16 bottom-[-60px] w-40 h-40 rounded-full bg-blue-400/10 pointer-events-none"></div>

    <div class="relative z-10">
        <p class="text-blue-200 text-sm">{{ now()->translatedFormat('l, j F Y') }}</p>
        <h1 class="font-display text-3xl font-bold text-white mt-1">
            Selamat datang kembali, {{ auth()->user()->name }}!
        </h1>
        <p class="text-blue-100 mt-2">
            Berikut ringkasan performa Kirana Hotel &amp; Resort hari ini.
        </p>
    </div>
</div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-lg bg-[#12202B]/5 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-[#12202B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500">Total Hotel</p>
            <p class="font-display text-3xl text-[#12202B]">{{ $totalHotels }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-lg bg-[#C9A227]/10 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-[#C9A227]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v11a1 1 0 001 1h4v-4h8v4h4a1 1 0 001-1V7M3 7l9-4 9 4M3 7h18" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500">Total Kamar</p>
            <p class="font-display text-3xl text-[#12202B]">{{ $totalRooms }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500">Total Booking</p>
            <p class="font-display text-3xl text-[#12202B]">{{ $totalBookings }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2m9-8a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500">Pendapatan</p>
            <p class="font-display text-xl text-[#12202B]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        {{-- Mini chart tren booking --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm font-medium text-[#12202B]">Tren Booking — 7 Hari Terakhir</p>
                <span class="text-xs text-gray-400">{{ $last7Days->sum('count') }} booking</span>
            </div>
            <div class="flex items-end justify-between gap-3 h-32">
                @foreach ($last7Days as $day)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full rounded-t-md bg-gradient-to-t from-[#12202B] to-[#C9A227]/70"
                             style="height: {{ $day['count'] > 0 ? max(8, ($day['count'] / $maxCount) * 100) : 4 }}px"
                             title="{{ $day['count'] }} booking"></div>
                        <span class="text-xs text-gray-400">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Status kamar --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-sm font-medium text-[#12202B] mb-4">Status Kamar</p>
            @if ($totalRooms > 0)
                <div class="flex h-2.5 rounded-full overflow-hidden bg-gray-100 mb-4">
                    <div class="bg-emerald-400" style="width: {{ $roomsAvailable / $totalRooms * 100 }}%"></div>
                    <div class="bg-amber-400" style="width: {{ $roomsBooked / $totalRooms * 100 }}%"></div>
                    <div class="bg-gray-400" style="width: {{ $roomsMaintenance / $totalRooms * 100 }}%"></div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-gray-600"><span class="w-2 h-2 rounded-full bg-emerald-400"></span>Tersedia</span>
                        <span class="font-medium text-[#12202B]">{{ $roomsAvailable }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-gray-600"><span class="w-2 h-2 rounded-full bg-amber-400"></span>Dibooking</span>
                        <span class="font-medium text-[#12202B]">{{ $roomsBooked }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-gray-600"><span class="w-2 h-2 rounded-full bg-gray-400"></span>Perbaikan</span>
                        <span class="font-medium text-[#12202B]">{{ $roomsMaintenance }}</span>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-400">Belum ada data kamar.</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Check-in mendatang --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200">
                <p class="text-sm font-medium text-[#12202B]">Check-in Mendatang</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($upcomingCheckins as $booking)
                    <div class="px-5 py-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[#12202B]">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->room->hotel->name }} · {{ $booking->check_in->translatedFormat('j M') }}</p>
                        </div>
                        <span class="text-xs text-[#C9A227] font-medium">{{ $booking->check_in->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="px-5 py-8 text-sm text-gray-400 text-center">Tidak ada check-in dalam waktu dekat.</p>
                @endforelse
            </div>
        </div>

        {{-- Booking Terbaru --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold text-[#12202B] text-sm">Booking Terbaru</h3>
                @if ($totalBookings > 0)
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs text-[#12202B] hover:text-[#C9A227] font-medium">Lihat semua →</a>
                @endif
            </div>

            @if ($recentBookings->isEmpty())
                <div class="py-14 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-gray-50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm">Belum ada booking masuk.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentBookings as $booking)
                            <tr>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-7 h-7 rounded-full bg-[#12202B] text-white text-xs flex items-center justify-center font-medium shrink-0">
                                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                        </span>
                                        <div>
                                            <p class="text-[#12202B] font-medium leading-tight">{{ $booking->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $booking->room->hotel->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-gray-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-3.5 text-right">
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
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-admin-layout>