<x-app-layout>

    <main class="flex-1 w-full max-w-[1280px] mx-auto p-6 lg:p-12 flex flex-col gap-8 my-6">

        <!-- PAGE HEADER -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b-2 border-dashed border-retro-border/20 pb-6">

            <div>
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border mb-2">
                    Transaksi <span class="text-primary">Pending</span>
                </h1>
                <p class="text-retro-border/70 font-medium text-lg">
                    Menunggu verifikasi pembayaran dari pelanggan
                </p>
            </div>

            <span
                class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold uppercase
                       border-2 border-retro-border rounded-full flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </header>

        @if($transaksis->count())

            <!-- ALERT -->
            <div
                class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-4 font-bold text-yellow-800">
                ⚠️ Ada {{ $transaksis->count() }} transaksi menunggu verifikasi
            </div>

            <!-- LIST TRANSAKSI -->
            <section class="flex flex-col gap-6">

                @foreach($transaksis as $transaksi)

                    <article
                        class="bg-paper border-2 border-retro-border rounded-lg shadow-retro overflow-hidden">

                        <!-- CARD HEADER -->
                        <div
                            class="flex flex-col md:flex-row justify-between gap-4 p-6 bg-cream border-b-2 border-retro-border">

                            <div>
                                <p class="font-mono font-bold text-sm text-retro-border">
                                    #{{ $transaksi->no_transaksi }}
                                </p>
                                <p class="text-sm text-retro-border/70">
                                    {{ $transaksi->waktu_transaksi->format('d M Y • H:i') }}
                                </p>
                            </div>

                            <span
                                class="px-3 py-1 text-xs font-black uppercase
                                       border-2 border-retro-border rounded
                                       bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </div>

                        <!-- PEMBELI -->
                        <div class="p-6 border-b-2 border-retro-border/20">
                            <h4 class="font-black uppercase mb-3">Pembeli</h4>
                            <div class="grid md:grid-cols-3 gap-4 text-sm font-medium">
                                <div>
                                    <p class="text-retro-border/60 text-xs uppercase">Nama</p>
                                    {{ $transaksi->nama_pembeli }}
                                </div>
                                <div>
                                    <p class="text-retro-border/60 text-xs uppercase">No HP</p>
                                    {{ $transaksi->no_telp_pembeli }}
                                </div>
                                <div>
                                    <p class="text-retro-border/60 text-xs uppercase">Alamat</p>
                                    {{ Str::limit($transaksi->alamat, 60) }}
                                </div>
                            </div>
                        </div>

                        <!-- ITEMS -->
                        <div class="p-6 border-b-2 border-retro-border/20">
                            <h4 class="font-black uppercase mb-4">
                                Item ({{ $transaksi->items->count() }})
                            </h4>

                            <div class="flex flex-col gap-3">
                                @foreach($transaksi->items as $item)
                                    <div
                                        class="flex justify-between items-center border-2 border-retro-border/20 rounded p-3">

                                        <div>
                                            <p class="font-bold">
                                                {{ $item->kaos->merek }}
                                            </p>
                                            <p class="text-xs text-retro-border/60">
                                                {{ $item->kaos->warna_kaos }} • {{ $item->kaos->ukuran }}
                                            </p>
                                            <p class="text-xs">
                                                Qty {{ $item->jumlah }} ×
                                                Rp {{ number_format($item->kaos->harga_jual,0,',','.') }}
                                            </p>
                                        </div>

                                        <div class="text-right">
                                            <p class="font-black">
                                                Rp {{ number_format($item->subtotal,0,',','.') }}
                                            </p>

                                            @if($item->kaos->stok_kaos < $item->jumlah)
                                                <p class="text-xs font-bold text-red-600">
                                                    Stok kurang
                                                </p>
                                            @else
                                                <p class="text-xs font-bold text-green-600">
                                                    Stok aman
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- TOTAL -->
                        <div class="p-6 bg-cream border-b-2 border-retro-border">
                            <div class="flex justify-between text-sm font-bold">
                                <span>Total</span>
                                <span class="text-primary text-lg">
                                    Rp {{ number_format($transaksi->grand_total,0,',','.') }}
                                </span>
                            </div>
                        </div>

                        <!-- ACTIONS -->
                        <div class="p-6 flex flex-col md:flex-row gap-3">

                            <a href="{{ route('kasir.transaksi.show', $transaksi->id) }}"
                               class="flex-1 bg-white border-2 border-retro-border shadow-retro-sm
                                      font-bold py-3 rounded text-center">
                                Detail
                            </a>

                            @php
                                $stokKurang = $transaksi->items->contains(fn($i) => $i->kaos->stok_kaos < $i->jumlah);
                            @endphp

                            @if($stokKurang)
                                <button disabled
                                    class="flex-1 bg-gray-300 border-2 border-gray-400
                                           font-bold py-3 rounded cursor-not-allowed">
                                    Stok Tidak Cukup
                                </button>
                            @else
                                <form method="POST"
                                      action="{{ route('kasir.transaksi.confirm', $transaksi->id) }}"
                                      class="flex-1">
                                    @csrf
                                    <button
                                        class="w-full bg-green-500 text-white border-2 border-retro-border
                                               shadow-retro-sm font-bold py-3 rounded
                                               active:translate-y-[2px] active:shadow-none">
                                        ACC Transaksi
                                    </button>
                                </form>
                            @endif

                            <form method="POST"
                                  action="{{ route('kasir.transaksi.cancel', $transaksi->id) }}"
                                  class="flex-1">
                                @csrf
                                <button
                                    class="w-full bg-red-500 text-white border-2 border-retro-border
                                           shadow-retro-sm font-bold py-3 rounded
                                           active:translate-y-[2px] active:shadow-none">
                                    Tolak
                                </button>
                            </form>

                        </div>
                    </article>

                @endforeach
            </section>

        @else
            <!-- EMPTY -->
            <div
                class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-12 text-center">
                <h3 class="text-2xl font-black uppercase mb-2">
                    Tidak Ada Transaksi Pending
                </h3>
                <p class="text-retro-border/60 font-medium">
                    Semua transaksi sudah diverifikasi
                </p>
            </div>
        @endif

    </main>
</x-app-layout>
