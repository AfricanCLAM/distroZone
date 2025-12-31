<x-app-layout>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between py-8 my-6 gap-6 mb-8 border-b-2 border-dashed border-retro-border/20 pb-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border">
                Detail <span class="text-primary">Transaksi</span>
            </h1>
            <p class="text-[#6b584a] font-medium mt-1">
                Nomor Transaksi:
                <span class="font-mono font-bold">{{ $transaksi->no_transaksi }}</span>
            </p>
        </div>

        <a href="{{ route('admin.laporan.index') }}"
           class="flex items-center gap-2 font-bold uppercase text-sm border-b-2 border-transparent hover:border-primary transition">
            ← Kembali
        </a>
    </div>

    <!-- Status & Action -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            @if($transaksi->isPending())
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border-2 border-retro-border bg-yellow-100 font-bold uppercase text-xs shadow-retro-sm">
                    ⏳ Menunggu Verifikasi
                </span>
            @elseif($transaksi->isValidated())
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border-2 border-retro-border bg-green-100 font-bold uppercase text-xs shadow-retro-sm">
                    ✔ Selesai
                </span>
            @else
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border-2 border-retro-border bg-red-100 font-bold uppercase text-xs shadow-retro-sm">
                    ✖ Dibatalkan
                </span>
            @endif
        </div>

        @if($transaksi->isValidated() && $transaksi->struk)
            <a href="{{ route('transaksi.download-struk', $transaksi->id) }}"
               class="h-12 px-6 flex items-center gap-2 rounded-lg bg-primary text-white font-black uppercase border-2 border-retro-border shadow-retro hover:translate-y-[-2px] transition">
                <span class="material-symbols-outlined">download</span>
                Download Struk
            </a>
        @endif
    </div>

    <!-- Informasi Pembeli -->
    <div class="retro-card bg-white rounded-xl p-6 mb-6">
        <h3 class="text-xl font-black uppercase mb-4">Informasi Pembeli</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-[#6b584a] font-bold uppercase">Nama</p>
                <p class="font-medium">{{ $transaksi->nama_pembeli }}</p>
            </div>
            <div>
                <p class="text-[#6b584a] font-bold uppercase">No. Telepon</p>
                <p class="font-medium">{{ $transaksi->no_telp_pembeli }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-[#6b584a] font-bold uppercase">Alamat</p>
                <p class="font-medium">{{ $transaksi->alamat }} – {{ $transaksi->wilayah }}</p>
            </div>
            <div>
                <p class="text-[#6b584a] font-bold uppercase">Tanggal Pesanan</p>
                <p class="font-medium">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($transaksi->isValidated())
                <div>
                    <p class="text-[#6b584a] font-bold uppercase">Diverifikasi</p>
                    <p class="font-medium">{{ $transaksi->validated_at->format('d/m/Y H:i') }}</p>
                </div>
            @endif

            <div>
                <p class="text-[#6b584a] font-bold uppercase">Total Berat</p>
                <p class="font-medium">{{ $transaksi->total_berat }} kg</p>
            </div>

            @if($transaksi->kasir)
                <div>
                    <p class="text-[#6b584a] font-bold uppercase">Diproses Oleh</p>
                    <p class="font-medium">{{ $transaksi->kasir->nama }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Item Pesanan -->
    <div class="retro-card bg-white rounded-xl p-6 mb-6">
        <h3 class="text-xl font-black uppercase mb-4">Item Pesanan</h3>

        <div class="space-y-4">
            @foreach($transaksi->transaksiItems as $item)
                <div class="flex items-center justify-between gap-4 border-b border-dashed border-retro-border/30 pb-4 last:border-none">
                    <div class="flex items-center gap-4">
                        @if($item->kaos->foto_kaos)
                            <img src="{{ asset('storage/'.$item->kaos->foto_kaos) }}"
                                 class="w-20 h-20 rounded-lg border-2 border-retro-border object-cover">
                        @else
                            <div class="w-20 h-20 rounded-lg border-2 border-retro-border bg-gray-200 flex items-center justify-center">
                                <span class="material-symbols-outlined text-gray-400">image</span>
                            </div>
                        @endif

                        <div>
                            <p class="font-bold">{{ $item->kaos->merek }}</p>
                            <p class="text-sm text-[#6b584a]">
                                {{ $item->kaos->warna_kaos }} • {{ $item->kaos->ukuran }}
                            </p>
                            <p class="text-sm mt-1">
                                {{ $item->qty }} × Rp {{ number_format($item->harga,0,',','.') }}
                            </p>
                        </div>
                    </div>

                    <div class="font-black text-lg">
                        Rp {{ number_format($item->subtotal,0,',','.') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Ringkasan Pembayaran -->
    <div class="retro-card bg-white rounded-xl p-6 mb-6">
        <h3 class="text-xl font-black uppercase mb-4">Ringkasan Pembayaran</h3>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span class="font-bold">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Ongkir</span>
                <span class="font-bold">Rp {{ number_format($transaksi->ongkir,0,',','.') }}</span>
            </div>

            <div class="border-t-2 border-dashed border-retro-border/30 pt-4 flex justify-between text-lg font-black">
                <span>Total</span>
                <span class="text-primary">
                    Rp {{ number_format($transaksi->pemasukan,0,',','.') }}
                </span>
            </div>

            <div class="mt-4 bg-[#f3ece7] border-2 border-retro-border rounded-lg p-3 text-sm font-bold">
                Metode Pembayaran: {{ $transaksi->metode_pembayaran }}
            </div>
        </div>
    </div>

</x-app-layout>
