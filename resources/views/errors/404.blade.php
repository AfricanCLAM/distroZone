<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 - Halaman Tidak Ditemukan | DistroZone</title>
    <script src="{{ asset('js/tailwind.js') }}"></script>
</head>

<body
    class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Error Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-12 text-center">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-white rounded-full mb-6 shadow-xl">
                    <svg class="w-20 h-20 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-white text-8xl font-bold mb-2">404</h1>
                <p class="text-white text-2xl font-semibold">Oops! Halaman Tidak Ditemukan</p>
            </div>

            <!-- Content Section -->
            <div class="px-8 py-10 text-center">
                <p class="text-gray-600 text-lg mb-8">
                    Maaf, halaman yang Anda cari tidak dapat ditemukan. Halaman mungkin telah dipindahkan atau tidak
                    pernah ada.
                </p>

                <!-- Suggestions -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-gray-900 font-semibold text-lg mb-4">Mungkin Anda mencari:</h3>
                    <div class="space-y-3">
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Dashboard Admin
                                </a>
                                <a href="{{ route('admin.kaos.index') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Data Kaos
                                </a>
                                <a href="{{ route('admin.laporan.index') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Laporan Keuangan
                                </a>
                            @elseif(Auth::user()->isKasirOnline())
                                <a href="{{ route('kasir.transaksi.index') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Transaksi Pending
                                </a>
                                <a href="{{ route('kasir.history') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Riwayat Transaksi
                                </a>
                            @elseif(Auth::user()->isKasirOffline())
                                <a href="{{ route('kasir-offline.dashboard') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Dashboard
                                </a>
                                <a href="{{ route('kasir-offline.history') }}"
                                    class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                    → Riwayat Transaksi
                                </a>
                            @endif
                        @else
                            <a href="{{ route('customer.catalog') }}"
                                class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                → Katalog Produk
                            </a>
                            <a href="{{ route('customer.cart') }}"
                                class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                → Keranjang Belanja
                            </a>
                            <a href="{{ route('login') }}"
                                class="block text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
                                → Login
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="history.back()"
                        class="inline-flex items-center justify-center px-6 py-3 border border-indigo-600 rounded-lg text-indigo-600 font-semibold hover:bg-indigo-50 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </button>

                    @auth
                        <a href="{{ route(Auth::user()->isAdmin() ? 'admin.dashboard' : (Auth::user()->isKasirOnline() || Auth::user()->isKasirOffline() ? 'kasir.dashboard' : 'customer.catalog')) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg text-white font-semibold hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('customer.catalog') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg text-white font-semibold hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Ke Beranda
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 text-center border-t border-gray-200">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <span class="text-2xl font-bold text-indigo-600">DISTROZONE</span>
                </div>
                <p class="text-gray-500 text-sm">
                    Butuh bantuan? <a href="mailto:support@distrozone.com"
                        class="text-indigo-600 hover:text-indigo-800 font-medium">Hubungi Kami</a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-8">
            <p class="text-white text-sm">
                Error Code: 404 | Page Not Found
            </p>
        </div>
    </div>

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div
            class="absolute top-0 left-0 w-96 h-96 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-3xl animate-blob">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute bottom-0 left-1/2 w-96 h-96 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-4000">
        </div>
    </div>

    <style>
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>
