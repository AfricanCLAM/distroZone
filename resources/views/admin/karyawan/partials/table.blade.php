<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telp</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($karyawans as $karyawan)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->NIK }}</td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($karyawan->foto)
                            <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="{{ $karyawan->nama }}"
                                class="h-15 w-15 rounded-full object-cover mr-3">
                        @else
                            <div class="h-15 w-15 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                <span class="text-gray-600 font-semibold">{{ substr($karyawan->nama, 0, 1) }}</span>
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-900">{{ $karyawan->nama }}</span>
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <span class="text-sm font-medium text-gray-900">{{ $karyawan->username }}</span>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <span
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $karyawan->role === 'kasir online' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucwords($karyawan->role) }}
                    </span>
                </td>
                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->no_telp }}</td>
                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                    @if($karyawan->shift_start && $karyawan->shift_end)
                        {{ $karyawan->shift_start->format('H:i') }} - {{ $karyawan->shift_end->format('H:i') }}
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}"
                        class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>Tidak ada data ditemukan</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
<div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
    {{ $karyawans->links() }}
</div>
