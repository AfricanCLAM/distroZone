<x-app-layout>

    <!-- MAIN CONTENT -->
    <main class="flex-1 w-full max-w-[1280px] mx-auto p-6 lg:p-12 flex flex-col gap-8 my-6">

        <!-- PAGE HEADER -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4
                   border-b-2 border-dashed border-retro-border/20 pb-6">

            <div>
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border mb-2">
                    Dashboard
                    <span class="text-primary">
                        {{ Auth::user()->isKasirOnline() ? 'Kasir Online' : 'Kasir Offline' }}
                    </span>
                </h1>
                <p class="text-retro-border/70 font-medium text-lg">
                    Selamat datang, {{ Auth::user()->nama }}.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold uppercase
                           border-2 border-retro-border rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    {{ now()->translatedFormat('d F Y') }}
                </span>

                <span
                    class="px-3 py-1 text-xs font-bold uppercase
                           border-2 border-retro-border rounded-full
                           {{ Auth::user()->isKasirOnline() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucwords(Auth::user()->role) }}
                </span>
            </div>
        </header>

        <!-- STATS GRID -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @if(Auth::user()->isKasirOnline())
            <!-- TRANSAKSI PENDING -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded
                               flex items-center justify-center text-yellow-600 shadow-retro-sm">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Transaksi Pending
                </p>
                <p class="text-4xl font-black">{{ $pendingCount ?? 0 }}</p>
            </div>
            @endif

            <!-- TRANSAKSI HARI INI -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded
                               flex items-center justify-center text-green-600 shadow-retro-sm">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Transaksi Hari Ini
                </p>
                <p class="text-4xl font-black">{{ $todayCount ?? 0 }}</p>
            </div>

            <!-- TOTAL SELESAI -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded
                               flex items-center justify-center text-primary shadow-retro-sm">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Total Transaksi Selesai
                </p>
                <p class="text-4xl font-black">{{ $totalCompleted ?? 0 }}</p>
            </div>
        </section>

        <!-- MAIN SPLIT -->
        <section class="flex flex-col lg:flex-row gap-8">

            <!-- LEFT: INFO & CATATAN -->
            <div class="flex-1 flex flex-col gap-6">

                <div
                    class="bg-white border-2 border-retro-border rounded-lg shadow-retro p-6">
                    <h3 class="text-xl font-black uppercase mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined">info</span>
                        Informasi Penting
                    </h3>

                    <ul class="list-disc list-inside text-retro-border/80 font-medium space-y-2">
                        <li>Pastikan pembayaran diverifikasi sebelum konfirmasi</li>
                        <li>Struk akan otomatis dibuat setelah transaksi selesai</li>
                        @if(Auth::user()->isKasirOnline())
                            <li>Jam operasional online: 10:00 – 17:00</li>
                        @else
                            <li>Gunakan aplikasi desktop untuk transaksi offline</li>
                        @endif
                        <li>Hubungi admin jika terjadi kendala sistem</li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT: QUICK ACTION -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6">

                <div
                    class="bg-primary p-6 rounded-lg border-2 border-retro-border shadow-retro flex flex-col gap-4">

                    <div class="flex items-center gap-3 text-white mb-2">
                        <span class="material-symbols-outlined text-3xl">bolt</span>
                        <h3 class="text-xl font-black uppercase">Aksi Cepat</h3>
                    </div>

                    @if(Auth::user()->isKasirOnline())
                        <a href="{{ route('kasir.transaksi.index') }}"
                           class="w-full bg-background-light text-retro-border font-bold
                                  py-3 px-4 rounded border-2 border-retro-border
                                  shadow-retro-sm active:translate-y-[2px] active:shadow-none
                                  flex items-center justify-between group">
                            <span>Verifikasi Transaksi</span>
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition">
                                arrow_forward
                            </span>
                        </a>
                    @endif

                    <a href="{{ route(Auth::user()->isKasirOnline() ? 'kasir.history' : 'kasir-offline.history') }}"
                       class="w-full bg-background-light text-retro-border font-bold
                              py-3 px-4 rounded border-2 border-retro-border
                              shadow-retro-sm active:translate-y-[2px] active:shadow-none
                              flex items-center justify-between group">
                        <span>Riwayat Transaksi</span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition">
                            arrow_forward
                        </span>
                    </a>

                </div>
            </div>
        </section>

    </main>
</x-app-layout>
