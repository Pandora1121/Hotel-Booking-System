<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking Kamar</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($selectedRoom)
                {{-- Form booking untuk kamar yang dipilih --}}
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-[#12202B] mb-1">{{ $selectedRoom->hotel->name }} — Kamar {{ $selectedRoom->room_number }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ $selectedRoom->roomType->name }} · Rp {{ number_format($selectedRoom->roomType->price, 0, ',', '.') }} / malam</p>

                    <form method="POST" action="{{ route('booking.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $selectedRoom->id }}">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Check-in <span class="text-[#C9A227]">*</span></label>
                                <input type="date" name="check_in" required min="{{ date('Y-m-d') }}"
                                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                                @error('check_in') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#12202B] mb-1.5">Check-out <span class="text-[#C9A227]">*</span></label>
                                <input type="date" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">
                                @error('check_out') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#12202B] mb-1.5">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Permintaan khusus, jam kedatangan, dll"
                                      class="w-full rounded-lg border-gray-300 text-sm py-2.5 focus:border-[#C9A227] focus:ring-[#C9A227]">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="bg-[#12202B] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#1B2F3D]">
                                Konfirmasi Booking
                            </button>
                            <a href="{{ route('booking.create') }}" class="text-sm text-gray-500 px-5 py-2.5 hover:text-gray-700">Pilih kamar lain</a>
                        </div>
                    </form>
                </div>
            @else
                {{-- List kamar tersedia --}}
                <h3 class="font-semibold text-[#12202B]">Pilih Kamar Tersedia</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse ($rooms as $room)
                        <div class="bg-white rounded-xl border border-gray-200 p-5">
                            <p class="text-xs text-gray-400 mb-1">{{ $room->hotel->name }} · {{ $room->hotel->city }}</p>
                            <h4 class="font-semibold text-[#12202B]">{{ $room->roomType->name }} — Kamar {{ $room->room_number }}</h4>
                            <p class="text-sm text-gray-500 mb-4">Kapasitas {{ $room->roomType->capacity }} orang</p>
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-[#12202B]">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}<span class="text-xs font-normal text-gray-400">/malam</span></span>
                                <a href="{{ route('booking.create', ['room_id' => $room->id]) }}"
                                   class="bg-[#12202B] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#1B2F3D]">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 col-span-2">Belum ada kamar tersedia saat ini.</p>
                    @endforelse
                </div>
            @endif

        </div>
    </div>
</x-app-layout>