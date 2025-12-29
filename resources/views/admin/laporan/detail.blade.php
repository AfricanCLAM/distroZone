<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi {{ $transaksi->no_transaksi }}
            </h2>
            <a href="{{ route('admin.laporan.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Kembali ke Laporan
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Status Badge -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                @if($transaksi->isPending())
                    <span
                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Menunggu Verifikasi
                    </span>
                @elseif($transaksi->isValidated())
                    <span
                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Selesai
                    </span>
                @else
                    <span
                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Dibatalkan
                    </span>
                @endif
            </div>

            <!-- Download Struk Button -->
            @if($transaksi->isValidated() && $transaksi->struk)
                <a href="{{ route('transaksi.download-struk', $transaksi->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Struk
                </a>
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
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->no_telp_pembeli }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Alamat Pengiriman Dan Wilayah</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->alamat }} - {{ $transaksi->wilayah }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                    <p class="text-base font-medium text-gray-900">
                        {{ $transaksi->created_at->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                @if($transaksi->isValidated())
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Diverifikasi</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $transaksi->validated_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500">Total Berat</p>
                    <p class="text-base font-medium text-gray-900">{{ $transaksi->total_berat }} kg</p>
                </div>
                @if($transaksi->kasir)
                    <div>
                        <p class="text-sm text-gray-500">Diproses Oleh</p>
                        <p class="text-base font-medium text-gray-900">{{ $transaksi->kasir->nama }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach($transaksi->transaksiItems as $item)
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
                                <p class="text-sm text-gray-600 mt-1">{{ $item->qty }} x Rp
                                    {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
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
                    <span>Subtotal ({{ $transaksi->transaksiItems->sum('qty') }} item)</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Ongkos Kirim ({{ $transaksi->total_berat }} kg)</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="border-t pt-3 flex justify-between text-xl font-bold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-indigo-600">Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}</span>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                    <p class="text-sm text-blue-800">
                        <strong>Metode Pembayaran:</strong> {{ $transaksi->metode_pembayaran }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Status Info -->
        @if($transaksi->isValidated())
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-base font-semibold text-green-900">Transaksi Selesai</p>
                        <p class="text-sm text-green-700 mt-1">
                            Transaksi ini sudah diverifikasi pada {{ $transaksi->validated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @elseif($transaksi->isPending())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-base font-semibold text-yellow-900">Menunggu Verifikasi</p>
                        <p class="text-sm text-yellow-700 mt-1">Transaksi ini sedang menunggu verifikasi dari kasir</p>
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
