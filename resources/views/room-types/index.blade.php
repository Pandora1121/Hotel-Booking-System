<x-admin-layout title="Tipe Kamar">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Total {{ $roomTypes->total() }} tipe kamar</p>
            <a href="{{ route('admin.room-types.create') }}"
               class="bg-[#12202B] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#1B2F3D]">
                + Tambah Tipe Kamar
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium">Nama Tipe</th>
                    <th class="px-6 py-3 font-medium">Hotel</th>
                    <th class="px-6 py-3 font-medium">Harga / Malam</th>
                    <th class="px-6 py-3 font-medium">Kapasitas</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($roomTypes as $type)
                    <tr>
                        <td class="px-6 py-4 font-medium text-[#12202B]">{{ $type->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $type->hotel->name }}</td>
                        <td class="px-6 py-4 text-gray-600">Rp {{ number_format($type->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $type->capacity }} orang</td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.room-types.edit', $type) }}" class="text-[#12202B] hover:text-[#C9A227] font-medium">Edit</a>
                            <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus tipe kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada data tipe kamar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $roomTypes->links() }}</div>
</x-admin-layout>