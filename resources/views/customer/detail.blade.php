<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $kaos->merek }} - DistroZone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('customer.catalog') }}" class="text-2xl font-bold text-indigo-600">DISTROZONE</a>
                </div>
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('customer.catalog') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Katalog</a>
                    <a href="{{ route('customer.cart') }}" class="flex items-center text-gray-700 hover:text-indigo-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @php
                            $cart = Session::get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Product Detail -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('customer.catalog') }}" class="text-gray-700 hover:text-indigo-600">Katalog</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-gray-500">{{ $kaos->merek }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="flex items-center justify-center">
                    @if($kaos->foto_kaos)
                        <img src="{{ asset('storage/' . $kaos->foto_kaos) }}" alt="{{ $kaos->merek }}" class="w-full max-w-md rounded-lg shadow-lg">
                    @else
                        <div class="w-full max-w-md h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-32 w-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $kaos->merek }}</h1>

                    <div class="flex items-center space-x-4 mb-6">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full">{{ $kaos->ukuran }}</span>
                        <span class="text-gray-600">{{ $kaos->tipe }}</span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Warna:</h3>
                        <p class="text-lg text-gray-900">{{ $kaos->warna_kaos }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Harga:</h3>
                        <p class="text-4xl font-bold text-indigo-600">Rp {{ number_format($kaos->harga_jual, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Stok:</h3>
                        @if($kaos->stok_kaos > 0)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tersedia ({{ $kaos->stok_kaos }} pcs)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Stok Habis
                            </span>
                        @endif
                    </div>

                    <!-- Add to Cart Form -->
                    @if($kaos->stok_kaos > 0)
                        <form action="{{ route('customer.cart.add', $kaos->id_kaos) }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah:</label>
                                <div class="flex items-center space-x-3">
                                    <button type="button" onclick="decrementQty()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $kaos->stok_kaos }}"
                                        class="w-20 text-center px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <button type="button" onclick="incrementQty()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Max: {{ $kaos->stok_kaos }} pcs</p>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center text-lg font-semibold">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg cursor-not-allowed text-lg font-semibold">
                            Stok Habis
                        </button>
                    @endif

                    <a href="{{ route('customer.catalog') }}" class="block text-center mt-4 text-indigo-600 hover:text-indigo-800">
                        ← Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        const maxQty = {{ $kaos->stok_kaos }};

        function incrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) < maxQty) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
</body>
</html>
