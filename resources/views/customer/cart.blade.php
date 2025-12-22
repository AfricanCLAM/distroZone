<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja - DistroZone</title>
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
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('customer.catalog') }}"
                        class="text-gray-700 hover:text-indigo-600 font-medium">Katalog</a>
                    <a href="{{ route('customer.cart') }}" class="text-indigo-600 font-medium">Keranjang</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Cart Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg shadow-md p-6 flex items-center space-x-4">
                            <!-- Product Image -->
                            @if($item['kaos']->foto_kaos)
                                <img src="{{ asset('storage/' . $item['kaos']->foto_kaos) }}" alt="{{ $item['kaos']->merek }}"
                                    class="w-24 h-24 object-cover rounded-lg">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item['kaos']->merek }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['kaos']->warna_kaos }} - {{ $item['kaos']->ukuran }}
                                </p>
                                <p class="text-lg font-bold text-indigo-600 mt-2">Rp
                                    {{ number_format($item['kaos']->harga_jual, 0, ',', '.') }}</p>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex flex-col items-center space-y-2">
                                <form action="{{ route('customer.cart.update', $item['kaos']->id_kaos) }}" method="POST"
                                    class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" onclick="updateQty(this, -1)"
                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        max="{{ $item['kaos']->stok_kaos }}"
                                        class="w-16 text-center border border-gray-300 rounded" onchange="this.form.submit()">
                                    <button type="button" onclick="updateQty(this, 1)"
                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                </form>

                                <form action="{{ route('customer.cart.remove', $item['kaos']->id_kaos) }}" method="POST"
                                    onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Subtotal</p>
                                <p class="text-xl font-bold text-gray-900">Rp
                                    {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ array_sum(array_column($cartItems, 'quantity')) }} item)</span>
                                <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span class="text-indigo-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Ongkir akan dihitung saat checkout</p>
                        </div>

                        <a href="{{ route('customer.checkout') }}"
                            class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                            Lanjut ke Checkout
                        </a>

                        <a href="{{ route('customer.catalog') }}"
                            class="block text-center mt-4 text-indigo-600 hover:text-indigo-800">
                            ← Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-600 mb-6">Belum ada produk di keranjang Anda</p>
                <a href="{{ route('customer.catalog') }}"
                    class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </main>

    <script>
        function updateQty(btn, change) {
            const input = btn.parentElement.querySelector('input[name="quantity"]');
            const newVal = parseInt(input.value) + change;
            const max = parseInt(input.max);

            if (newVal >= 1 && newVal <= max) {
                input.value = newVal;
                input.form.submit();
            }
        }
    </script>
</body>

</html>
