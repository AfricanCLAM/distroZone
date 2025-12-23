<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - DistroZone</title>
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script defer src="{{ asset('js/alpine.js') }}"></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('customer.catalog') }}" class="text-2xl font-bold text-indigo-600">DISTROZONE</a>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400">Keranjang</span>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-indigo-600 font-semibold">Checkout</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Checkout Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('customer.checkout.place') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customer Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pembeli</h2>

                        <div class="space-y-4">
                            <!-- Nama -->
                            <div>
                                <label for="nama_pembeli" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" name="nama_pembeli" id="nama_pembeli" required
                                    value="{{ old('nama_pembeli') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('nama_pembeli') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('nama_pembeli')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_pembeli" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span class="text-red-600">*</span></label>
                                <input type="text" name="no_pembeli" id="no_pembeli" required
                                    value="{{ old('no_pembeli') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('no_pembeli') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_pembeli')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Wilayah (Region) -->
                            <div>
                                <label for="wilayah" class="block text-sm font-medium text-gray-700 mb-2">Wilayah Pengiriman <span class="text-red-600">*</span></label>
                                <select name="wilayah" id="wilayah" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('wilayah') border-red-500 @enderror">
                                    <option value="">-- Pilih Wilayah --</option>
                                    <option value="Jakarta" {{ old('wilayah') == 'Jakarta' ? 'selected' : '' }}>Jakarta (Rp 24.000/kg)</option>
                                    <option value="Depok" {{ old('wilayah') == 'Depok' ? 'selected' : '' }}>Depok (Rp 24.000/kg)</option>
                                    <option value="Bekasi" {{ old('wilayah') == 'Bekasi' ? 'selected' : '' }}>Bekasi (Rp 25.000/kg)</option>
                                    <option value="Tangerang" {{ old('wilayah') == 'Tangerang' ? 'selected' : '' }}>Tangerang (Rp 25.000/kg)</option>
                                    <option value="Bogor" {{ old('wilayah') == 'Bogor' ? 'selected' : '' }}>Bogor (Rp 27.000/kg)</option>
                                    <option value="Jawa Barat" {{ old('wilayah') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat (Rp 31.000/kg)</option>
                                    <option value="Jawa Tengah" {{ old('wilayah') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah (Rp 39.000/kg)</option>
                                    <option value="Jawa Timur" {{ old('wilayah') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur (Rp 47.000/kg)</option>
                                </select>
                                @error('wilayah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">⚠️ Pengiriman hanya tersedia untuk Pulau Jawa</p>
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat_pembeli" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-600">*</span></label>
                                <textarea name="alamat_pembeli" id="alamat_pembeli" rows="4" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('alamat_pembeli') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, Kecamatan, Kota)">{{ old('alamat_pembeli') }}</textarea>
                                @error('alamat_pembeli')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">📍 Pastikan alamat sesuai dengan wilayah yang dipilih di atas</p>
                            </div>

                            <!-- Calculate Shipping Button -->
                            <button type="button" onclick="calculateShipping()"
                                class="w-full bg-indigo-100 text-indigo-700 py-3 rounded-lg hover:bg-indigo-200 transition font-medium">
                                Hitung Ongkir
                            </button>
                        </div>
                    </div>

                    <!-- Shipping Info (Initially Hidden) -->
                    <div id="shippingInfo" class="bg-white rounded-lg shadow-md p-6 hidden">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Wilayah: <span id="regionName">-</span></p>
                                    <p class="text-sm text-blue-800 mt-1">Berat: <span id="totalWeight">-</span> kg
                                        ({{ array_sum(array_column($cartItems, 'quantity')) }} item)</p>
                                    <p class="text-lg font-bold text-blue-900 mt-2">Ongkir: <span id="shippingCost">-</span></p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="ongkir" id="ongkirValue">
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Pesanan ({{ count($cartItems) }})</h2>

                        <div class="space-y-3">
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                                    <div class="flex items-center space-x-3">
                                        @if($item['kaos']->foto_kaos)
                                            <img src="{{ asset('storage/' . $item['kaos']->foto_kaos) }}"
                                                alt="{{ $item['kaos']->merek }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item['kaos']->merek }}</p>
                                            <p class="text-sm text-gray-600">{{ $item['kaos']->warna_kaos }} -
                                                {{ $item['kaos']->ukuran }}</p>
                                            <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-gray-700">
                                <span>Ongkir</span>
                                <span class="font-semibold" id="ongkirDisplay">Belum dihitung</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-xl font-bold text-gray-900">
                                <span>Total</span>
                                <span class="text-indigo-600" id="grandTotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Payment Method Info -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <h4 class="text-sm font-semibold text-yellow-900 mb-2">Metode Pembayaran</h4>
                            <p class="text-xs text-yellow-800">Transfer Bank (Konfirmasi manual oleh kasir)</p>
                        </div>

                        <button type="submit" id="submitBtn" disabled
                            class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg cursor-not-allowed font-semibold mb-3">
                            Hitung Ongkir Terlebih Dahulu
                        </button>

                        <p class="text-xs text-gray-500 text-center">
                            ⚠️ Pesanan akan dikonfirmasi oleh kasir
                        </p>

                        <a href="{{ route('customer.cart') }}"
                            class="block text-center mt-4 text-indigo-600 hover:text-indigo-800">
                            ← Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        let calculatedOngkir = 0;
        const subtotal = {{ $subtotal }};

        // Shipping rates per kg
        const shippingRates = {
            'Jakarta': 24000,
            'Depok': 24000,
            'Bekasi': 25000,
            'Tangerang': 25000,
            'Bogor': 27000,
            'Jawa Barat': 31000,
            'Jawa Tengah': 39000,
            'Jawa Timur': 47000
        };

        function calculateShipping() {
            const nama = document.getElementById('nama_pembeli').value.trim();
            const noTelp = document.getElementById('no_pembeli').value.trim();
            const wilayah = document.getElementById('wilayah').value;
            const alamat = document.getElementById('alamat_pembeli').value.trim();

            // Validation
            if (!nama) {
                alert('Nama pembeli harus diisi!');
                document.getElementById('nama_pembeli').focus();
                return;
            }

            if (!noTelp) {
                alert('No. telepon harus diisi!');
                document.getElementById('no_pembeli').focus();
                return;
            }

            if (!wilayah) {
                alert('Wilayah pengiriman harus dipilih!');
                document.getElementById('wilayah').focus();
                return;
            }

            if (!alamat) {
                alert('Alamat lengkap harus diisi!');
                document.getElementById('alamat_pembeli').focus();
                return;
            }

            // Calculate shipping
            const totalItems = {{ array_sum(array_column($cartItems, 'quantity')) }};
            const totalWeight = Math.ceil(totalItems / 3); // 3 items = 1 kg
            const ratePerKg = shippingRates[wilayah];
            calculatedOngkir = ratePerKg * totalWeight;

            // Update UI
            document.getElementById('regionName').textContent = wilayah;
            document.getElementById('totalWeight').textContent = totalWeight;
            document.getElementById('shippingCost').textContent = 'Rp ' + calculatedOngkir.toLocaleString('id-ID');
            document.getElementById('ongkirValue').value = calculatedOngkir;
            document.getElementById('ongkirDisplay').textContent = 'Rp ' + calculatedOngkir.toLocaleString('id-ID');

            // Calculate grand total
            const grandTotal = subtotal + calculatedOngkir;
            document.getElementById('grandTotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');

            // Show shipping info
            document.getElementById('shippingInfo').classList.remove('hidden');

            // Enable submit button
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            submitBtn.classList.add('bg-indigo-600', 'text-white', 'hover:bg-indigo-700', 'cursor-pointer');
            submitBtn.textContent = 'Buat Pesanan';

            // Scroll to shipping info
            document.getElementById('shippingInfo').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Validate form before submit
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            if (calculatedOngkir === 0) {
                e.preventDefault();
                alert('Mohon hitung ongkir terlebih dahulu!');
                return false;
            }

            const nama = document.getElementById('nama_pembeli').value.trim();
            const noTelp = document.getElementById('no_pembeli').value.trim();
            const wilayah = document.getElementById('wilayah').value;
            const alamat = document.getElementById('alamat_pembeli').value.trim();

            if (!nama || !noTelp || !wilayah || !alamat) {
                e.preventDefault();
                alert('Semua field harus diisi dengan lengkap!');
                return false;
            }
        });
    </script>
</body>

</html>
