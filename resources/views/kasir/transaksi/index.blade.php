<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Pending - Menunggu Verifikasi
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($transaksis->count() > 0)
            <div class="mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">
                                Ada {{ $transaksis->count() }} transaksi menunggu verifikasi pembayaran
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($transaksis as $transaksi)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Transaksi {{ $transaksi->no_transaksi }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $transaksi->waktu_transaksi->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="mt-2 md:mt-0">
                                    <span
                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending Verification
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi Pembeli</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Nama</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaksi->nama_pembeli }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">No. Telepon</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaksi->no_telp_pembeli }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Alamat</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($transaksi->alamat, 50) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Item Pesanan ({{ $transaksi->items->count() }})
                            </h4>
                            <div class="space-y-3">
                                @foreach($transaksi->items as $item)
                                    <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                                        <div class="flex items-center space-x-3">
                                            @if($item->kaos->foto_kaos)
                                                <img src="{{ asset('storage/' . $item->kaos->foto_kaos) }}"
                                                    alt="{{ $item->kaos->merek }}" class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item->kaos->merek }}</p>
                                                <p class="text-sm text-gray-600">{{ $item->kaos->warna_kaos }} -
                                                    {{ $item->kaos->ukuran }}</p>
                                                <p class="text-xs text-gray-500">Qty: {{ $item->jumlah }} x Rp
                                                    {{ number_format($item->kaos->harga_jual, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-gray-900">Rp
                                                {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            @if($item->kaos->stok_kaos < $item->jumlah)
                                                <p class="text-xs text-red-600 mt-1">⚠️ Stok tidak cukup</p>
                                            @else
                                                <p class="text-xs text-green-600 mt-1">✓ Stok tersedia</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="px-6 py-4 bg-gray-50">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Ongkir ({{ $transaksi->total_berat }} kg)</span>
                                    <span class="font-semibold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t pt-2 flex justify-between text-lg font-bold text-gray-900">
                                    <span>Total Pembayaran</span>
                                    <span class="text-indigo-600">Rp
                                        {{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-white border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('kasir.transaksi.show', $transaksi->id) }}"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-indigo-600 rounded-lg text-indigo-600 font-medium hover:bg-indigo-50 transition">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>

                                @php
                                    $hasInsufficientStock = $transaksi->items->contains(function ($item) {
                                        return $item->kaos->stok_kaos < $item->jumlah;
                                    });
                                @endphp

                                @if($hasInsufficientStock)
                                    <button disabled
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        Stok Tidak Cukup
                                    </button>
                                @else
                                    <form action="{{ route('kasir.transaksi.confirm', $transaksi->id) }}" method="POST"
                                        class="flex-1"
                                        onsubmit="return confirm('Konfirmasi transaksi ini? Pastikan pembayaran sudah diterima.')">
                                        @csrf
                                        <input type="hidden" name="metode_pembayaran" value="Bank Transfer">
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            ACC Transaksi
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('kasir.transaksi.cancel', $transaksi->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition font-medium">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Transaksi Pending</h3>
                <p class="text-gray-600 mb-6">Semua transaksi sudah diverifikasi atau belum ada pesanan baru</p>
                <a href="{{ route('kasir.history') }}"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lihat Riwayat
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
