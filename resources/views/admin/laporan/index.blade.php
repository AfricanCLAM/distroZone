<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.laporan.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode
                        Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Metode</option>
                        <option value="Bank Transfer" {{ request('metode_pembayaran') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="Tunai" {{ request('metode_pembayaran') === 'Tunai' ? 'selected' : '' }}>Tunai
                        </option>
                        <option value="QRIS" {{ request('metode_pembayaran') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <!-- Kasir Filter -->
                <div>
                    <label for="id_kasir" class="block text-sm font-medium text-gray-700 mb-2">Kasir</label>
                    <select name="id_kasir" id="id_kasir"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Kasir</option>
                        @foreach($kasirs as $kasir)
                            <option value="{{ $kasir->id }}" {{ request('id_kasir') == $kasir->id ? 'selected' : '' }}>
                                {{ $kasir->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Income -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Pemasukan</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                    </div>
                    <svg class="h-16 w-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Transaksi</p>
                        <p class="text-3xl font-bold">{{ $totalTransaksi }}</p>
                    </div>
                    <svg class="h-16 w-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            <!-- Total Shipping -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Total Ongkir</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($totalOngkir, 0, ',', '.') }}</p>
                    </div>
                    <svg class="h-16 w-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kasir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pembeli</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ongkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grand Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Struk</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transaksis as $transaksi)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ str_pad($transaksi->no_transaksi, 6, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $transaksi->validated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $transaksi->kasir->nama ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $transaksi->nama_pembeli ?? 'N/A (Pembeli Offline)' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $transaksi->no_telp_pembeli ?? '' }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                                    Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                             {{ $transaksi->metode_pembayaran === 'Bank Transfer' ? 'bg-blue-100 text-blue-800' :
                            ($transaksi->metode_pembayaran === 'Cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                                        {{ $transaksi->metode_pembayaran }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($transaksi->struk)
                                                        <a href="{{ route('transaksi.download-struk', $transaksi->id) }}"
                                                            class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            Unduh
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500">Tidak ada transaksi ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
