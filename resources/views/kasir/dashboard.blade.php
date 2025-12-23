<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->isKasirOnline() ? 'Kasir Online Dashboard' : 'Kasir Offline Dashboard' }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-md p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                    <p class="text-indigo-100">{{ ucwords(Auth::user()->role) }}</p>
                    @if(Auth::user()->shift_start && Auth::user()->shift_end)
                        <p class="text-sm text-indigo-100 mt-2">
                            Shift: {{ Auth::user()->shift_start->format('H:i') }} -
                            {{ Auth::user()->shift_end->format('H:i') }}
                        </p>
                    @endif
                </div>
                <div class="hidden md:block">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->nama }}"
                            class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div
                            class="h-20 w-20 rounded-full bg-white flex items-center justify-center border-4 border-white shadow-lg">
                            <span
                                class="text-indigo-600 font-bold text-3xl">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @if(Auth::user()->isKasirOnline())
                <!-- Pending Transactions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Pending</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</p>
                        </div>
                    </div>
                    <a href="{{ route('kasir.transaksi.index') }}"
                        class="mt-4 block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Lihat Semua →
                    </a>
                </div>
            @endif

            <!-- Today's Transactions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todayCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Completed -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalCompleted ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if(Auth::user()->isKasirOnline())
                    <a href="{{ route('kasir.transaksi.index') }}"
                        class="flex items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                        <svg class="h-8 w-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium text-gray-900">Verifikasi Transaksi</span>
                    </a>
                @endif

                <a href="{{ route(Auth::user()->isKasirOnline() ? 'kasir.history' : 'kasir-offline.history') }}"
                    class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                    <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-gray-900">Lihat Riwayat Saya</span>
                </a>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Gunakan aplikasi desktop untuk transaksi offline</li>
                            <li>Verifikasi pembayaran sebelum mengkonfirmasi transaksi</li>
                            <li>Struk otomatis dibuat setelah konfirmasi</li>
                            <li>Jam operasional online: 10:00 - 17:00</li>
                            <li>Hubungi admin untuk masalah teknis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
