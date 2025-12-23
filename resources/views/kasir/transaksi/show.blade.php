<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <a href="{{ route('kasir.transaksi.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Status Badge -->
        <div class="mb-6">
            @if($transaksi->isPending())
                <span
                    class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Menunggu Verifikasi
                </span>
            @elseif($transaksi->isCompleted())
                <span
                    class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Selesai
                </span>
            @else
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Dibatalkan
                </span>
            @endif
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembeli</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->nama_pembeli }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">No. Telepon</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->no_pembeli }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Alamat Pengiriman</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->alamat_pembeli }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                    <p class="text-base font-medium text-gray-900">
                        {{ $transaksi->waktu_transaksi->format('d/m/Y H:i:s') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Berat</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->total_berat }} kg</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach($transaksi->items as $item)
                    <div class="flex items-center justify-between py-4 border-b last:border-b-0">
                        <div class="flex items-center space-x-4">
                            @if($item->kaos->foto_kaos)
                                <img src="{{ asset('storage/' . $item->kaos->foto_kaos) }}" alt="{{ $item->kaos->merek }}"
                                    class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-base font-semibold text-gray-900">{{ $item->kaos->merek }}</h4>
                                <p class="text-sm text-gray-600">{{ $item->kaos->warna_kaos }} - {{ $item->kaos->ukuran }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->jumlah }} x Rp
                                    {{ number_format($item->kaos->harga_jual, 0, ',', '.') }}</p>
                                <div class="mt-2">
                                    @if($item->kaos->stok_kaos >= $item->jumlah)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            ✓ Stok tersedia ({{ $item->kaos->stok_kaos }} pcs)
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            ⚠️ Stok tidak cukup ({{ $item->kaos->stok_kaos }} pcs tersedia)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-700">
                    <span>Subtotal ({{ $transaksi->items->sum('jumlah') }} item)</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Ongkos Kirim ({{ $transaksi->total_berat }} kg)</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="border-t pt-3 flex justify-between text-xl font-bold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-indigo-600">Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                    <p class="text-sm text-blue-800">
                        <strong>Metode Pembayaran:</strong> Bank Transfer
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($transaksi->isPending())
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>

                @php
                    $hasInsufficientStock = $transaksi->items->contains(function ($item) {
                        return $item->kaos->stok_kaos < $item->jumlah;
                    });
                @endphp

                @if($hasInsufficientStock)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-800">Stok Tidak Mencukupi</p>
                                <p class="text-sm text-red-700 mt-1">Beberapa item tidak memiliki stok yang cukup. Hubungi admin
                                    untuk restock atau batalkan transaksi ini.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-800">Siap Diverifikasi</p>
                                <p class="text-sm text-green-700 mt-1">Semua stok tersedia. Pastikan pembayaran sudah diterima
                                    sebelum mengkonfirmasi.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-4">
                    @if(!$hasInsufficientStock)
                        <form action="{{ route('kasir.transaksi.confirm', $transaksi->id) }}" method="POST" class="flex-1"
                            onsubmit="return confirm('Konfirmasi transaksi ini? Pastikan pembayaran sudah diterima via Bank Transfer.')">
                            @csrf
                            <input type="hidden" name="metode_pembayaran" value="Bank Transfer">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-base">
                                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Konfirmasi & ACC Transaksi
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold text-base">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Stok Tidak Cukup
                        </button>
                    @endif

                    <form action="{{ route('kasir.transaksi.cancel', $transaksi->id) }}" method="POST" class="flex-1"
                        onsubmit="return confirm('Yakin ingin membatalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition font-semibold text-base">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Transaksi
                        </button>
                    </form>
                </div>
            </div>
        @elseif($transaksi->isCompleted())
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-base font-semibold text-green-900">Transaksi Selesai</p>
                        <p class="text-sm text-green-700 mt-1">Transaksi ini sudah diverifikasi dan diselesaikan</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div>
                        <p class="text-base font-semibold text-red-900">Transaksi Dibatalkan</p>
                        <p class="text-sm text-red-700 mt-1">Transaksi ini telah dibatalkan</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
