<x-app-layout>

    <!-- MAIN CONTENT -->
    <main class="flex-1 w-full max-w-[1280px] mx-auto p-6 lg:p-12 flex flex-col gap-8 my-6">

        <!-- PAGE HEADER -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b-2 border-dashed border-retro-border/20 pb-6">

            <div>
                <h1
                    class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border mb-2">
                    Dashboard <span class="text-primary">Overview</span>
                </h1>
                <p class="text-retro-border/70 font-medium text-lg">
                    Halo Admin, berikut adalah laporan penjualan hari ini.
                </p>
            </div>

            <div class="flex gap-2">
                <span
                    class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold uppercase
                           border-2 border-retro-border rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    {{ now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </header>

        <!-- STATS GRID -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- TOTAL KAOS -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded flex items-center justify-center text-primary shadow-retro-sm">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Total Kaos
                </p>
                <p class="text-4xl font-black">{{ $totalKaos }}</p>
            </div>

            <!-- TOTAL KARYAWAN -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded flex items-center justify-center text-primary shadow-retro-sm">
                        <span class="material-symbols-outlined">groups</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Total Karyawan
                </p>
                <p class="text-4xl font-black">{{ $totalKaryawan }}</p>
            </div>

            <!-- PEMASUKAN HARI INI -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded flex items-center justify-center text-primary shadow-retro-sm">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Pemasukan Hari Ini
                </p>
                <p class="text-3xl font-black">
                    Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}
                </p>
            </div>

            <!-- TRANSAKSI HARI INI -->
            <div class="bg-paper p-6 rounded-lg border-2 border-retro-border shadow-retro retro-card">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-10 bg-white border-2 border-retro-border rounded flex items-center justify-center text-primary shadow-retro-sm">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                </div>
                <p class="text-retro-border/60 font-bold text-sm uppercase mb-1">
                    Transaksi Hari Ini
                </p>
                <p class="text-4xl font-black">{{ $transaksiHariIni }}</p>
            </div>
        </section>

        <!-- MAIN SPLIT -->
        <section class="flex flex-col lg:flex-row gap-8">

            <!-- LEFT: RECENT TRANSACTIONS -->
            <div class="flex-1 flex flex-col gap-4">

                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black uppercase flex items-center gap-2">
                        <span class="material-symbols-outlined">list_alt</span>
                        Transaksi Terbaru
                    </h3>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="text-primary text-sm font-bold hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div
                    class="bg-white border-2 border-retro-border rounded-lg shadow-retro overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-retro-border text-white border-b-2 border-retro-border">
                                    <th class="p-4 text-xs font-bold uppercase">ID</th>
                                    <th class="p-4 text-xs font-bold uppercase">Pelanggan</th>
                                    <th class="p-4 text-xs font-bold uppercase">Item</th>
                                    <th class="p-4 text-xs font-bold uppercase text-right">Total</th>
                                    <th class="p-4 text-xs font-bold uppercase text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-retro-border/10">

                                @forelse ($transaksiTerbaru as $trx)
                                    <tr class="hover:bg-cream transition">
                                        <td class="p-4 font-mono font-bold text-sm">
                                            #{{ $trx->kode_transaksi }}
                                        </td>
                                        <td class="p-4 font-medium">
                                            {{ $trx->nama_pembeli }}
                                        </td>
                                        <td class="p-4 text-sm">
                                            {{ $trx->items_count }} Item
                                        </td>
                                        <td class="p-4 font-bold text-right">
                                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <span
                                                class="px-2 py-1 text-xs font-bold uppercase border-2 border-retro-border rounded
                                                @if($trx->status === 'success') bg-green-100 text-green-800
                                                @elseif($trx->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $trx->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="p-6 text-center text-retro-border/60 font-bold">
                                            Belum ada transaksi
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
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

                    <a href="{{ route('admin.kaos.create') }}"
                        class="w-full bg-background-light text-retro-border font-bold py-3 px-4 rounded
                               border-2 border-retro-border shadow-retro-sm
                               active:translate-y-[2px] active:shadow-none
                               flex items-center justify-between group">
                        <span>Upload Produk Baru</span>
                        <span
                            class="material-symbols-outlined group-hover:translate-x-1 transition">
                            arrow_forward
                        </span>
                    </a>

                    <a href="{{ route('admin.karyawan.index') }}"
                        class="w-full bg-background-light text-retro-border font-bold py-3 px-4 rounded
                               border-2 border-retro-border shadow-retro-sm
                               active:translate-y-[2px] active:shadow-none
                               flex items-center justify-between group">
                        <span>Kelola Karyawan</span>
                        <span
                            class="material-symbols-outlined group-hover:translate-x-1 transition">
                            arrow_forward
                        </span>
                    </a>

                </div>
            </div>
        </section>
    </main>
</x-app-layout>
