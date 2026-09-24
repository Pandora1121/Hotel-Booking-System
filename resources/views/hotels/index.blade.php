<x-admin-layout title="Data Hotel">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <p class="text-sm text-gray-500">Total {{ $hotels->total() }} hotel</p>
            <a href="{{ route('admin.hotels.create') }}"
               class="bg-[#12202B] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#1B2F3D]">
                + Tambah Hotel
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3 font-medium">Nama</th>
                    <th class="px-6 py-3 font-medium">Kota</th>
                    <th class="px-6 py-3 font-medium">Ditambahkan</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($hotels as $hotel)
                    <tr>
                        <td class="px-6 py-4 font-medium text-[#12202B]">{{ $hotel->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $hotel->city }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $hotel->created_at->translatedFormat('j M Y') }}</td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.hotels.edit', $hotel) }}" class="text-[#12202B] hover:text-[#C9A227] font-medium">Edit</a>
                            <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus hotel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada data hotel.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $hotels->links() }}
    </div>
</x-admin-layout>