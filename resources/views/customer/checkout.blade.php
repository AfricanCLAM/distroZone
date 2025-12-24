<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - DistroZone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        <form action="{{ route('customer.checkout.place') }}" method="POST" id="checkoutForm" x-data="checkoutData()">
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
                                <label for="nama_pembeli" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_pembeli" id="nama_pembeli" required
                                    value="{{ old('nama_pembeli') }}" x-model="formData.nama_pembeli"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('nama_pembeli') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('nama_pembeli')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_telp_pembeli" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_telp_pembeli" id="no_telp_pembeli" required
                                    value="{{ old('no_telp_pembeli') }}" x-model="formData.no_telp_pembeli"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('no_telp_pembeli') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_telp_pembeli')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label for="wilayah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Wilayah Pengiriman <span class="text-red-500">*</span>
                                </label>
                                <select name="wilayah" id="wilayah" required x-model="formData.wilayah"
                                    @change="resetShipping()"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('wilayah') border-red-500 @enderror">
                                    <option value="">-- Pilih Wilayah --</option>
                                    <option value="Jakarta" {{ old('wilayah') === 'Jakarta' ? 'selected' : '' }}>Jakarta
                                        (Rp 24.000/kg)</option>
                                    <option value="Depok" {{ old('wilayah') === 'Depok' ? 'selected' : '' }}>Depok (Rp
                                        24.000/kg)</option>
                                    <option value="Bekasi" {{ old('wilayah') === 'Bekasi' ? 'selected' : '' }}>Bekasi (Rp
                                        25.000/kg)</option>
                                    <option value="Tangerang" {{ old('wilayah') === 'Tangerang' ? 'selected' : '' }}>
                                        Tangerang (Rp 25.000/kg)</option>
                                    <option value="Bogor" {{ old('wilayah') === 'Bogor' ? 'selected' : '' }}>Bogor (Rp
                                        27.000/kg)</option>
                                    <option value="Jawa Barat" {{ old('wilayah') === 'Jawa Barat' ? 'selected' : '' }}>
                                        Jawa Barat (Rp 31.000/kg)</option>
                                    <option value="Jawa Tengah" {{ old('wilayah') === 'Jawa Tengah' ? 'selected' : '' }}>
                                        Jawa Tengah (Rp 39.000/kg)</option>
                                    <option value="Jawa Timur" {{ old('wilayah') === 'Jawa Timur' ? 'selected' : '' }}>
                                        Jawa Timur (Rp 47.000/kg)</option>
                                </select>
                                @error('wilayah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Pilih wilayah untuk menghitung ongkir otomatis</p>
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat" id="alamat" rows="4" required x-model="formData.alamat"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, Kecamatan)">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">⚠️ Pastikan alamat sesuai dengan wilayah yang
                                    dipilih</p>
                            </div>

                            <!-- Calculate Shipping Button -->
                            <button type="button" @click="calculateShipping()" :disabled="!canCalculateShipping()"
                                :class="canCalculateShipping() ? 'bg-indigo-600 hover:bg-indigo-700 text-white cursor-pointer' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
                                class="w-full py-3 rounded-lg transition font-medium">
                                <span x-show="!loading">Hitung Ongkir</span>
                                <span x-show="loading">Menghitung...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Shipping Info (Initially Hidden) -->
                    <div x-show="shippingCalculated" x-cloak class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Wilayah: <span
                                            x-text="shippingInfo.region"></span></p>
                                    <p class="text-sm text-blue-800 mt-1">Berat: <span
                                            x-text="shippingInfo.weight"></span> kg
                                        ({{ array_sum(array_column($cartItems, 'quantity')) }} item)</p>
                                    <p class="text-lg font-bold text-blue-900 mt-2">Ongkir: <span
                                            x-text="shippingInfo.formatted_ongkir"></span></p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="ongkir" x-model="shippingInfo.ongkir">
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
                                                {{ $item['kaos']->ukuran }}
                                            </p>
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
                                <span class="font-semibold"
                                    x-text="shippingCalculated ? shippingInfo.formatted_ongkir : 'Belum dihitung'"></span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-xl font-bold text-gray-900">
                                <span>Total</span>
                                <span class="text-indigo-600"
                                    x-text="formatCurrency({{ $subtotal }} + (shippingCalculated ? shippingInfo.ongkir : 0))"></span>
                            </div>
                        </div>

                        <!-- Payment Method Info -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <h4 class="text-sm font-semibold text-yellow-900 mb-2">Metode Pembayaran</h4>
                            <p class="text-xs text-yellow-800">Transfer Bank (Konfirmasi manual oleh kasir)</p>
                        </div>

                        <button type="submit" :disabled="!canSubmit()"
                            :class="canSubmit() ? 'bg-indigo-600 hover:bg-indigo-700 cursor-pointer' : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
                            class="w-full text-white py-3 rounded-lg font-semibold mb-3 transition">
                            <span x-show="canSubmit()">Buat Pesanan</span>
                            <span x-show="!canSubmit()">Hitung Ongkir Terlebih Dahulu</span>
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
        function checkoutData() {
            return {
                formData: {
                    nama_pembeli: '',
                    no_telp_pembeli: '',
                    wilayah: '',
                    alamat: ''
                },
                shippingInfo: {
                    ongkir: 0,
                    formatted_ongkir: 'Rp 0',
                    region: '',
                    weight: 0
                },
                shippingCalculated: false,
                loading: false,

                canCalculateShipping() {
                    return this.formData.nama_pembeli.trim() !== '' &&
                        this.formData.no_telp_pembeli.trim() !== '' &&
                        this.formData.wilayah !== '' &&
                        this.formData.alamat.trim() !== '';
                },

                canSubmit() {
                    return this.canCalculateShipping() && this.shippingCalculated;
                },

                resetShipping() {
                    this.shippingCalculated = false;
                    this.shippingInfo = {
                        ongkir: 0,
                        formatted_ongkir: 'Rp 0',
                        region: '',
                        weight: 0
                    };
                },

                async calculateShipping() {
                    if (!this.canCalculateShipping()) {
                        alert('Mohon lengkapi semua field terlebih dahulu!');
                        return;
                    }

                    this.loading = true;

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

                    // Calculate weight (3 items = 1 kg, round up)
                    const totalItems = {{ array_sum(array_column($cartItems, 'quantity')) }};
                    const totalWeight = Math.ceil(totalItems / 3);

                    // Get shipping rate
                    const rate = shippingRates[this.formData.wilayah] || 0;
                    const ongkir = rate * totalWeight;

                    // Simulate API delay
                    await new Promise(resolve => setTimeout(resolve, 500));

                    this.shippingInfo = {
                        ongkir: ongkir,
                        formatted_ongkir: this.formatCurrency(ongkir),
                        region: this.formData.wilayah,
                        weight: totalWeight
                    };

                    this.shippingCalculated = true;
                    this.loading = false;

                    // Scroll to shipping info
                    setTimeout(() => {
                        const shippingElement = document.querySelector('[x-show="shippingCalculated"]');
                        if (shippingElement) {
                            shippingElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 100);
                },

                formatCurrency(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
