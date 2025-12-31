<x-app-layout>
      <!-- Page Heading & Actions -->
    <div
        class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-8 my-6 py-8  pb-8 border-b-2 border-dashed border-retro-border/20">
        <div class="flex flex-col gap-2">
            <h1
                class="text-retro-border text-4xl md:text-5xl font-black leading-none tracking-tighter uppercase">
                Laporan <span class="text-primary">Penjualan</span>
            </h1>
            <p class="text-[#6b584a] font-medium">
                Kelola data kasir online & offline
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- FILTER PANEL -->
        <div
            class="bg-white border-2 border-black shadow-retro-lg rounded-xl p-6">
            <h3 class="font-black uppercase mb-4">Filter Laporan</h3>

            <form method="GET" action="{{ route('admin.laporan.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full border-2 border-black rounded-lg px-3 py-2 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full border-2 border-black rounded-lg px-3 py-2 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Metode</label>
                    <select name="metode_pembayaran"
                        class="w-full border-2 border-black rounded-lg px-3 py-2 focus:outline-none">
                        <option value="">Semua</option>
                        <option value="Bank Transfer" @selected(request('metode_pembayaran')==='Bank Transfer')>
                            Bank Transfer
                        </option>
                        <option value="Tunai" @selected(request('metode_pembayaran')==='Tunai')>
                            Tunai
                        </option>
                        <option value="QRIS" @selected(request('metode_pembayaran')==='QRIS')>
                            QRIS
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Kasir</label>
                    <select name="id_kasir"
                        class="w-full border-2 border-black rounded-lg px-3 py-2 focus:outline-none">
                        <option value="">Semua</option>
                        @foreach($kasirs as $kasir)
                            <option value="{{ $kasir->id }}" @selected(request('id_kasir')==$kasir->id)>
                                {{ $kasir->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full bg-primary text-white border-2 border-black rounded-lg py-2 font-black shadow-retro-sm active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-green-300 border-2 border-black shadow-retro-lg rounded-xl p-6">
                <p class="text-xs font-bold uppercase">Total Pemasukan</p>
                <p class="text-3xl font-black mt-2">
                    Rp {{ number_format($totalPemasukan,0,',','.') }}
                </p>
            </div>

            <div class="bg-blue-300 border-2 border-black shadow-retro-lg rounded-xl p-6">
                <p class="text-xs font-bold uppercase">Total Transaksi</p>
                <p class="text-3xl font-black mt-2">
                    {{ $totalTransaksi }}
                </p>
            </div>

            <div class="bg-purple-300 border-2 border-black shadow-retro-lg rounded-xl p-6">
                <p class="text-xs font-bold uppercase">Total Ongkir</p>
                <p class="text-3xl font-black mt-2">
                    Rp {{ number_format($totalOngkir,0,',','.') }}
                </p>
            </div>

        </div>

      <!-- TABLE -->
<div
    class="flex flex-col overflow-hidden rounded-xl
           border-2 border-retro-border
           bg-white shadow-retro">

    <div class="overflow-x-auto">
        <table class="w-full min-w-[1100px] border-collapse">
            <thead>
                <tr class="bg-retro-cream border-b-2 border-retro-border">
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">No</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Kasir</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Pembeli</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Total</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Ongkir</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Grand</th>
                    <th class="px-6 py-4 text-center text-sm font-black uppercase">Metode</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y-2 divide-dashed divide-retro-border/20">
                @forelse($transaksis as $transaksi)
                    <tr class="hover:bg-[#fffdf5] transition-colors">

                        <!-- No -->
                        <td class="px-6 py-4">
                            <span
                                class="inline-block rounded
                                       bg-[#f3ece7]
                                       px-2 py-1 text-xs font-bold
                                       border border-retro-border/30">
                                {{ str_pad($transaksi->no_transaksi,6,'0',STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <!-- Tanggal -->
                        <td class="px-6 py-4 font-medium">
                            {{ $transaksi->validated_at->format('d/m/Y H:i') }}
                        </td>

                        <!-- Kasir -->
                        <td class="px-6 py-4 font-medium">
                            {{ $transaksi->kasir->nama ?? '-' }}
                        </td>

                        <!-- Pembeli -->
                        <td class="px-6 py-4">
                            <div class="font-bold">
                                {{ $transaksi->nama_pembeli ?? 'Offline' }}
                            </div>
                            <div class="text-xs text-[#6b584a]">
                                {{ $transaksi->no_telp_pembeli }}
                            </div>
                        </td>

                        <!-- Total -->
                        <td class="px-6 py-4 text-right font-medium">
                            Rp {{ number_format($transaksi->total_harga,0,',','.') }}
                        </td>

                        <!-- Ongkir -->
                        <td class="px-6 py-4 text-right font-medium">
                            Rp {{ number_format($transaksi->ongkir,0,',','.') }}
                        </td>

                        <!-- Grand -->
                        <td class="px-6 py-4 text-right font-black text-green-700">
                            Rp {{ number_format($transaksi->pemasukan,0,',','.') }}
                        </td>

                        <!-- Metode -->
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1
                                       text-xs font-bold uppercase
                                       border-2 border-retro-border
                                       shadow-[2px_2px_0px_0px_#1b130e]
                                       {{ $transaksi->metode_pembayaran === 'Tunai'
                                            ? 'bg-green-100 text-green-800'
                                            : ($transaksi->metode_pembayaran === 'QRIS'
                                                ? 'bg-purple-100 text-purple-800'
                                                : 'bg-blue-100 text-blue-800') }}">
                                {{ $transaksi->metode_pembayaran }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.laporan.transaksi.detail',$transaksi->id) }}"
                                class="inline-flex items-center justify-center
                                       size-9 rounded
                                       border-2 border-retro-border
                                       hover:bg-yellow-100
                                       shadow-retro-sm
                                       active:translate-y-[1px]
                                       transition-all">
                                <span class="material-symbols-outlined text-[18px]">
                                    visibility
                                </span>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9"
                            class="px-6 py-12 text-center text-[#6b584a] font-medium">
                            Tidak ada data transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div
        class="border-t-2 border-retro-border bg-retro-cream
               px-6 py-4 flex justify-between items-center">
        <span class="text-sm font-bold text-[#6b584a]">
            Menampilkan {{ $transaksis->count() }} dari {{ $transaksis->total() }} data
        </span>
        {{ $transaksis->links() }}
    </div>
</div>


    </div>
</x-app-layout>
