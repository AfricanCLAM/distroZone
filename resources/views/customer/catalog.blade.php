<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DistroZone - Katalog Kaos</title>
            <script src="{{ asset('js/tailwind.js') }}"></script>
<script defer src="{{ asset('js/alpine.js') }}"></script>

</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">DISTROZONE</h1>
                </div>

                <!-- Navigation -->
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
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('kasir.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50">
                            Login
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-4xl font-bold mb-4">Selamat Datang di DistroZone</h2>
            <p class="text-xl opacity-90">Temukan kaos berkualitas dengan harga terbaik</p>
            <div class="mt-8">
                <p class="text-sm opacity-75">🕐 Buka Online: Setiap Hari 10:00 - 17:00</p>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Products Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-900">Katalog Produk</h3>
            <p class="text-gray-600 mt-1">Tersedia {{ $kaos->total() }} produk</p>
        </div>

        @if($kaos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($kaos as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Product Image -->
                        <a href="{{ route('customer.detail', $item->id_kaos) }}" class="block">
                            @if($item->foto_kaos)
                                <img src="{{ asset('storage/' . $item->foto_kaos) }}" alt="{{ $item->merek }}" class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>

                        <!-- Product Info -->
                        <div class="p-4">
                            <a href="{{ route('customer.detail', $item->id_kaos) }}" class="block">
                                <h4 class="text-lg font-semibold text-gray-900 mb-1 hover:text-indigo-600">{{ $item->merek }}</h4>
                            </a>

                            <div class="flex items-center space-x-2 mb-2">
                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded">{{ $item->ukuran }}</span>
                                <span class="text-sm text-gray-600">{{ $item->warna_kaos }}</span>
                            </div>

                            <p class="text-xs text-gray-500 mb-3">{{ $item->tipe }}</p>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>

                                @if($item->stok_kaos > 0)
                                    <span class="text-xs text-green-600 font-medium">Stok: {{ $item->stok_kaos }}</span>
                                @else
                                    <span class="text-xs text-red-600 font-medium">Habis</span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            @if($item->stok_kaos > 0)
                                <form action="{{ route('customer.cart.add', $item->id_kaos) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $kaos->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-xl text-gray-600">Belum ada produk tersedia</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h3 class="text-xl font-bold mb-2">DISTROZONE</h3>
                <p class="text-gray-400 text-sm">Distro kaos berkualitas dengan harga terbaik</p>
                <p class="text-gray-400 text-sm mt-2">© 2024 DistroZone. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
