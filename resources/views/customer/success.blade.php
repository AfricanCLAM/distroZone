<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesanan Berhasil - DistroZone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('customer.catalog') }}" class="text-2xl font-bold text-indigo-600">DISTROZONE</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Success Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Message -->
        <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
            <!-- Success Icon -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-gray-600 mb-6">Pesanan Anda sedang menunggu konfirmasi pembayaran dari kasir</p>

            <!-- Order ID -->
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 inline-block">
                <p class="text-sm text-indigo-700 mb-1">Nomor Pesanan</p>
                <p class="text-2xl font-bold text-indigo-900">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Detail Pesanan</h2>

            <!-- Customer Info -->
            <div class="border-b pb-6 mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Pembeli</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Nama</p>
                        <p class="text-sm font-medium text-gray-900">{{ $transaksi->nama_pembeli }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">No. Telepon</p>
                        <p class="text-sm font-medium text-gray-900">{{ $transaksi->no_pembeli }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500">Alamat Pengiriman</p>
                        <p class="text-sm font-medium text-gray-900">{{ $transaksi->alamat_pembeli }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-b pb-6 mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Item Pesanan</h3>
                <div class="space-y-3">
                    @foreach($transaksi->items as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @if($item->kaos->foto_kaos)
                                    <img src="{{ asset('storage/' . $item->kaos->foto_kaos) }}" alt="{{ $item->kaos->merek }}"
                                        class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->kaos->merek }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->kaos->warna_kaos }} -
                                        {{ $item->kaos->ukuran }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->jumlah }} x Rp
                                        {{ number_format($item->kaos->harga_jual, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="space-y-2">
                <div class="flex justify-between text-gray-700">
                    <span>Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Ongkir ({{ $transaksi->total_berat }} kg)</span>
                    <span class="font-semibold">Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="border-t pt-2 mt-2">
                    <div class="flex justify-between text-xl font-bold text-gray-900">
                        <span>Total Pembayaran</span>
                        <span class="text-indigo-600">Rp
                            {{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Langkah Selanjutnya
            </h3>
            <ol class="list-decimal list-inside space-y-2 text-sm text-blue-800">
                <li>Pesanan Anda akan dikonfirmasi oleh kasir kami</li>
                <li>Lakukan pembayaran via <strong>Bank Transfer</strong></li>
                <li>Kirim bukti pembayaran ke WhatsApp: <strong>081234567890</strong></li>
                <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                <li>Barang akan dikirim ke alamat yang tertera</li>
            </ol>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-yellow-900 mb-3">Informasi Pembayaran</h3>
            <div class="space-y-3">
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Bank BCA</p>
                    <p class="text-lg font-bold text-gray-900">1234567890</p>
                    <p class="text-sm text-gray-600">a.n. DistroZone</p>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Bank Mandiri</p>
                    <p class="text-lg font-bold text-gray-900">0987654321</p>
                    <p class="text-sm text-gray-600">a.n. DistroZone</p>
                </div>
            </div>
            <p class="text-xs text-yellow-700 mt-4">
                ⚠️ <strong>Penting:</strong> Harap transfer sesuai nominal yang tertera dan konfirmasi ke WhatsApp kami
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('customer.catalog') }}"
                class="flex-1 bg-indigo-600 text-white text-center py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                Kembali ke Katalog
            </a>
            <button onclick="window.print()"
                class="flex-1 bg-white border-2 border-indigo-600 text-indigo-600 py-3 rounded-lg hover:bg-indigo-50 transition font-semibold">
                Cetak Detail Pesanan
            </button>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h3 class="text-xl font-bold mb-2">DISTROZONE</h3>
                <p class="text-gray-400 text-sm">Terima kasih telah berbelanja di DistroZone!</p>
                <p class="text-gray-400 text-sm mt-2">© 2024 DistroZone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        @media print {

            header,
            footer,
            button {
                display: none !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
</body>

</html>
