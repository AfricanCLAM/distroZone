<x-app-layout>

    <main class="flex-1 w-full max-w-[1100px] mx-auto p-6 lg:p-12 flex flex-col gap-8 my-6">

        <!-- PAGE HEADER -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4
                   border-b-2 border-dashed border-retro-border/20 pb-6">

            <div>
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border mb-2">
                    Detail <span class="text-primary">Transaksi</span>
                </h1>
                <p class="font-mono text-sm font-bold text-retro-border/70">
                    #{{ $transaksi->no_transaksi }}
                </p>
            </div>

            <a href="{{ !$transaksi->isValidated() && !$transaksi->isRejected()
                        ? route('kasir.transaksi.index')
                        : route('kasir.history') }}"
               class="text-primary font-bold hover:underline flex items-center gap-1">
                ← Kembali
            </a>
        </header>

        <!-- STATUS -->
        <section>
            @if($transaksi->isPending())
                <span class="px-4 py-2 text-xs font-black uppercase
                             border-2 border-retro-border rounded
                             bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif($transaksi->isValidated())
                <span class="px-4 py-2 text-xs font-black uppercase
                             border-2 border-retro-border rounded
                             bg-green-100 text-green-800">
                    Selesai
                </span>
            @else
                <span class="px-4 py-2 text-xs font-black uppercase
                             border-2 border-retro-border rounded
                             bg-red-100 text-red-800">
                    Dibatalkan
                </span>
            @endif
        </section>

        <!-- INFO PEMBELI -->
        <section class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
            <h3 class="font-black uppercase mb-4">Informasi Pembeli</h3>

            <div class="grid md:grid-cols-2 gap-4 text-sm font-medium">
                <div>
                    <p class="text-xs uppercase text-retro-border/60">Nama</p>
                    {{ $transaksi->nama_pembeli }}
                </div>
                <div>
                    <p class="text-xs uppercase text-retro-border/60">No HP</p>
                    {{ $transaksi->no_telp_pembeli }}
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs uppercase text-retro-border/60">Alamat & Wilayah</p>
                    {{ $transaksi->alamat }} – {{ $transaksi->wilayah }}
                </div>
                <div>
                    <p class="text-xs uppercase text-retro-border/60">Waktu Pesan</p>
                    {{ $transaksi->waktu_transaksi->format('d M Y • H:i') }}
                </div>
                <div>
                    <p class="text-xs uppercase text-retro-border/60">Total Berat</p>
                    {{ $transaksi->total_berat }} kg
                </div>
            </div>
        </section>

        <!-- ITEM -->
        <section class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
            <h3 class="font-black uppercase mb-4">
                Item Pesanan ({{ $transaksi->items->count() }})
            </h3>

            <div class="flex flex-col gap-4">
                @foreach($transaksi->items as $item)
                    <div
                        class="flex flex-col md:flex-row justify-between gap-4
                               border-2 border-retro-border/20 rounded p-4">

                        <div>
                            <p class="font-bold">{{ $item->kaos->merek }}</p>
                            <p class="text-xs text-retro-border/60">
                                {{ $item->kaos->warna_kaos }} • {{ $item->kaos->ukuran }}
                            </p>
                            <p class="text-sm">
                                {{ $item->jumlah }} ×
                                Rp {{ number_format($item->kaos->harga_jual,0,',','.') }}
                            </p>

                            @if($transaksi->isPending())
                                @if($item->kaos->stok_kaos >= $item->jumlah)
                                    <span
                                        class="inline-block mt-2 px-2 py-1 text-xs font-bold
                                               border-2 border-retro-border rounded
                                               bg-green-100 text-green-800">
                                        Stok aman ({{ $item->kaos->stok_kaos }})
                                    </span>
                                @else
                                    <span
                                        class="inline-block mt-2 px-2 py-1 text-xs font-bold
                                               border-2 border-retro-border rounded
                                               bg-red-100 text-red-800">
                                        Stok kurang ({{ $item->kaos->stok_kaos }})
                                    </span>
                                @endif
                            @endif
                        </div>

                        <div class="text-right font-black text-lg">
                            Rp {{ number_format($item->subtotal,0,',','.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- RINGKASAN -->
        <section class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
            <h3 class="font-black uppercase mb-4">Ringkasan Pembayaran</h3>

            <div class="flex flex-col gap-2 font-bold">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkir</span>
                    <span>Rp {{ number_format($transaksi->ongkir,0,',','.') }}</span>
                </div>
                <div class="border-t-2 border-retro-border pt-2 flex justify-between text-lg">
                    <span>Total</span>
                    <span class="text-primary">
                        Rp {{ number_format($transaksi->grand_total,0,',','.') }}
                    </span>
                </div>
            </div>

            <div class="mt-4 text-xs font-bold uppercase text-retro-border/60">
                Metode: Bank Transfer
            </div>
        </section>

        <!-- AKSI -->
        @if($transaksi->isPending())
            @php
                $stokKurang = $transaksi->items->contains(
                    fn ($i) => $i->kaos->stok_kaos < $i->jumlah
                );
            @endphp

            <section class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
                <h3 class="font-black uppercase mb-4">Aksi Kasir</h3>

                <div class="flex flex-col md:flex-row gap-4">

                    @if(!$stokKurang)
                        <form method="POST"
                              action="{{ route('kasir.transaksi.confirm', $transaksi->id) }}"
                              class="flex-1">
                            @csrf
                            <button
                                class="w-full bg-green-500 text-white font-black uppercase
                                       border-2 border-retro-border rounded py-3
                                       shadow-retro-sm active:translate-y-[2px] active:shadow-none">
                                ACC Transaksi
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="flex-1 bg-gray-300 font-black uppercase
                                   border-2 border-gray-400 rounded py-3
                                   cursor-not-allowed">
                            Stok Tidak Cukup
                        </button>
                    @endif

                    <form method="POST"
                          action="{{ route('kasir.transaksi.cancel', $transaksi->id) }}"
                          class="flex-1">
                        @csrf
                        <button
                            class="w-full bg-red-500 text-white font-black uppercase
                                   border-2 border-retro-border rounded py-3
                                   shadow-retro-sm active:translate-y-[2px] active:shadow-none">
                            Tolak Transaksi
                        </button>
                    </form>

                </div>
            </section>

        @endif

    </main>
</x-app-layout>
