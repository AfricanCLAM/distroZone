@extends('layouts.customer')

@section('content')
    <div class="min-h-screen py-10">

        <!-- WRAPPER dengan margin 5% kiri kanan -->
        <div class="max-w-[90%] mx-auto">

            <!-- PAGE TITLE -->
            <div class="mb-10">
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter">
                    Checkout Pengiriman
                </h1>
                <div class="h-1 w-28 bg-primary mt-2 border-2 border-black rounded-full"></div>
            </div>

            <form action="{{ route('customer.checkout.place') }}" x-data="checkoutData()" method="POST" id="checkoutForm">
                @csrf

                <div class="flex flex-col lg:flex-row gap-10 items-start">

                    <!-- LEFT 70% -->
                    <div class="w-full lg:w-[70%] space-y-10">

                        <!-- INFORMASI PEMBELI -->
                        <section class="bg-white border-2 border-black rounded-xl p-8 shadow-retro">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="size-8 rounded-full bg-black text-white flex items-center justify-center font-bold border-2 border-black">
                                    1
                                </div>
                                <h2 class="text-2xl font-black uppercase tracking-tight">
                                    Informasi Pembeli
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold uppercase mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="nama_pembeli" required x-model="formData.nama_pembeli"
                                        value="{{ old('nama_pembeli') }}"
                                        class="w-full h-12 px-4 border-2 border-black rounded-lg bg-cream-accent focus:ring-0 focus:border-primary shadow-retro-sm">
                                    @error('nama_pembeli')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold uppercase mb-2">
                                        No. Telepon
                                    </label>
                                    <input type="text" name="no_telp_pembeli" required x-model="formData.no_telp_pembeli"
                                        value="{{ old('no_telp_pembeli') }}"
                                        class="w-full h-12 px-4 border-2 border-black rounded-lg bg-cream-accent focus:ring-0 focus:border-primary shadow-retro-sm">
                                    @error('no_telp_pembeli')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold uppercase mb-2">
                                        Wilayah
                                    </label>
                                    <select name="wilayah" required x-model="formData.wilayah" @change="resetShipping()"
                                        class="w-full h-12 px-4 border-2 border-black rounded-lg bg-cream-accent focus:ring-0 focus:border-primary shadow-retro-sm cursor-pointer">
                                        <option value="">-- Pilih Wilayah --</option>
                                        <option value="Jakarta">Jakarta</option>
                                        <option value="Depok">Depok</option>
                                        <option value="Bekasi">Bekasi</option>
                                        <option value="Tangerang">Tangerang</option>
                                        <option value="Bogor">Bogor</option>
                                        <option value="Jawa Barat">Jawa Barat</option>
                                        <option value="Jawa Tengah">Jawa Tengah</option>
                                        <option value="Jawa Timur">Jawa Timur</option>
                                    </select>
                                    @error('wilayah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold uppercase mb-2">
                                        Alamat Lengkap
                                    </label>
                                    <textarea name="alamat" rows="4" required x-model="formData.alamat"
                                        class="w-full p-4 border-2 border-black rounded-lg bg-cream-accent focus:ring-0 focus:border-primary shadow-retro-sm resize-none">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="ongkir" x-model="shippingInfo.ongkir">
                            <button type="button" @click="calculateShipping()" :disabled="!canCalculateShipping()"
                                class="mt-6 w-full h-14 bg-primary text-white border-2 border-black rounded-lg font-black uppercase shadow-retro hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all disabled:bg-gray-300 disabled:text-gray-500">
                                <span x-show="!loading">Hitung Ongkir</span>
                                <span x-show="loading">Menghitung...</span>
                            </button>
                        </section>

                        <!-- ITEM PESANAN -->
                        <section class="bg-white border-2 border-black rounded-xl p-8 shadow-retro">
                            <h3 class="font-black uppercase mb-6">
                                Item Pesanan ({{ count($cartItems) }})
                            </h3>

                            <div class="space-y-5">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-5 items-center border-b-2 border-dashed pb-4">

                                        <!-- IMAGE -->
                                        <div
                                            class="w-20 h-20 rounded-lg overflow-hidden border-2 border-black bg-white shrink-0">
                                            @if($item['kaos']->foto_kaos)
                                                <img src="{{ asset('storage/' . $item['kaos']->foto_kaos) }}"
                                                    alt="{{ $item['kaos']->merek }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">
                                                    NO IMAGE
                                                </div>
                                            @endif
                                        </div>

                                        <!-- INFO -->
                                        <div class="flex-1">
                                            <p class="font-black uppercase leading-tight">
                                                {{ $item['kaos']->merek }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ $item['kaos']->warna_kaos }} • {{ $item['kaos']->ukuran }} • Qty
                                                {{ $item['quantity'] }}
                                            </p>
                                        </div>

                                        <!-- PRICE -->
                                        <div class="font-black text-right whitespace-nowrap">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <!-- RIGHT 20% -->
                    <div class="w-full lg:w-[20%] sticky top-24">
                        <div class="bg-white border-2 border-black rounded-xl p-6 shadow-retro-lg">
                            <h3 class="font-black uppercase mb-4">
                                Ringkasan
                            </h3>

                            <div class="space-y-2 text-sm font-medium">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span class="font-bold">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span>Ongkir</span>
                                    <span
                                        x-text="shippingCalculated ? shippingInfo.formatted_ongkir : 'Belum dihitung'"></span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t-2 border-black flex justify-between text-xl font-black">
                                <span>Total</span>
                                <span class="text-primary"
                                    x-text="formatCurrency({{ $subtotal }} + (shippingCalculated ? shippingInfo.ongkir : 0))">
                                </span>
                            </div>

                            <button form="checkoutForm" type="submit" :disabled="!canSubmit()"
                                class="mt-6 w-full h-14 bg-primary text-white border-2 border-black rounded-lg font-black uppercase shadow-retro hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all disabled:bg-gray-300 disabled:text-gray-500">
                                <span x-show="canSubmit()">Buat Pesanan</span>
                                <span x-show="!canSubmit()">Hitung Ongkir Dulu</span>
                            </button>
                        </div>

                        <!-- Need Help? -->
                        <div
                            class="bg-retro-cream border-2 border-retro-border rounded-lg p-4 flex items-center justify-between mt-6">
                            <div>
                                <p class="font-bold text-sm uppercase">Butuh Bantuan?</p>
                                <p class="text-xs text-[#996b4d]">Hubungi CS kami di WhatsApp</p>
                            </div>
                            <a href="https://wa.me/6287753966298"
                                class="size-8 rounded-full bg-white border-2 border-retro-border flex items-center justify-center text-green-600 hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-lg">chat</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


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
@endsection
