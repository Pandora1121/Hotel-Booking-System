<x-admin-layout title="Data Kamar">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Total {{ $rooms->total() }} kamar</p>
            <a href="{{ route('admin.rooms.create') }}"
               class="bg-[#12202B] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#1B2F3D]">
                + Tambah Kamar
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium">No. Kamar</th>
                    <th class="px-6 py-3 font-medium">Hotel</th>
                    <th class="px-6 py-3 font-medium">Tipe Kamar</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 font-medium text-[#12202B]">{{ $room->room_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $room->hotel->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $room->roomType->name }}</td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($room->status) {
                                    'available' => 'bg-emerald-50 text-emerald-700',
                                    'booked' => 'bg-amber-50 text-amber-700',
                                    'maintenance' => 'bg-gray-100 text-gray-600',
                                };
                                $label = match($room->status) {
                                    'available' => 'Tersedia',
                                    'booked' => 'Dibooking',
                                    'maintenance' => 'Perbaikan',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="text-[#12202B] hover:text-[#C9A227] font-medium">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada data kamar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $rooms->links() }}</div>
</x-admin-layout>