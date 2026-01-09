<x-app-layout>

    <main class="flex-1 w-full max-w-[1280px] mx-auto p-6 lg:p-12 flex flex-col gap-8 my-6">

        <!-- PAGE HEADER -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4
                   border-b-2 border-dashed border-retro-border/20 pb-6">

            <div>
                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border mb-2">
                    Riwayat <span class="text-primary">Transaksi</span>
                </h1>
                <p class="text-retro-border/70 font-medium">
                    Semua transaksi yang telah diproses
                </p>
            </div>
        </header>

        @if($transaksis->count() > 0)

            <!-- TABLE -->
            <section
                class="bg-white border-2 border-retro-border rounded-lg shadow-retro overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-retro-border text-white">
                                <th class="p-4 text-xs font-black uppercase">No</th>
                                <th class="p-4 text-xs font-black uppercase">Tanggal</th>
                                <th class="p-4 text-xs font-black uppercase">Item</th>
                                <th class="p-4 text-xs font-black uppercase text-right">Total</th>
                                <th class="p-4 text-xs font-black uppercase text-center">Status</th>
                                <th class="p-4 text-xs font-black uppercase text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y-2 divide-retro-border/10">
                            @foreach($transaksis as $trx)
                                <tr class="hover:bg-cream transition">
                                    <td class="p-4 font-mono font-bold">
                                        #{{ $trx->no_transaksi }}
                                    </td>

                                    <td class="p-4">
                                        <p class="font-medium">
                                            {{ $trx->created_at->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-retro-border/60">
                                            {{ $trx->created_at->format('H:i') }}
                                        </p>
                                    </td>

                                    <td class="p-4">
                                        <p class="font-medium">
                                            {{ $trx->transaksiItems->count() }} item
                                        </p>
                                        <p class="text-xs text-retro-border/60">
                                            {{ $trx->transaksiItems->sum('qty') }} pcs
                                        </p>
                                    </td>

                                    <td class="p-4 text-right font-bold">
                                        Rp {{ number_format($trx->pemasukan,0,',','.') }}
                                        <p class="text-xs text-retro-border/60">
                                            + Rp {{ number_format($trx->ongkir,0,',','.') }}
                                        </p>
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($trx->isValidated())
                                            <span
                                                class="px-2 py-1 text-xs font-black uppercase
                                                       border-2 border-retro-border rounded
                                                       bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @elseif($trx->isPending())
                                            <span
                                                class="px-2 py-1 text-xs font-black uppercase
                                                       border-2 border-retro-border rounded
                                                       bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-black uppercase
                                                       border-2 border-retro-border rounded
                                                       bg-red-100 text-red-800">
                                                Batal
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-3">

                                            <a href="{{ route('kasir.transaksi.show', $trx->id) }}"
                                               class="text-primary font-bold hover:underline">
                                                Detail
                                            </a>

                                            @if($trx->isValidated() && $trx->struk)
                                                <a href="{{ route('transaksi.download-struk', $trx->id) }}"
                                                   class="text-green-600 font-bold hover:underline">
                                                    Struk
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="p-4 border-t-2 border-retro-border/20">
                    {{ $transaksis->links() }}
                </div>
            </section>

            @php
                $validated = $transaksis->filter(fn($t) => $t->isValidated());
            @endphp

            <!-- SUMMARY -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
                    <p class="text-xs font-bold uppercase text-retro-border/60 mb-1">
                        Total Transaksi
                    </p>
                    <p class="text-4xl font-black">
                        {{ $transaksis->total() }}
                    </p>
                </div>

                <div class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
                    <p class="text-xs font-bold uppercase text-retro-border/60 mb-1">
                        Item Terjual
                    </p>
                    <p class="text-4xl font-black">
                        {{ $validated->sum(fn($t) => $t->items->sum('jumlah')) }}
                    </p>
                </div>

                <div class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-6">
                    <p class="text-xs font-bold uppercase text-retro-border/60 mb-1">
                        Total Penjualan
                    </p>
                    <p class="text-3xl font-black">
                        Rp {{ number_format($validated->sum('grand_total'),0,',','.') }}
                    </p>
                </div>

            </section>

        @else

            <!-- EMPTY STATE -->
            <section
                class="bg-paper border-2 border-retro-border rounded-lg shadow-retro p-12 text-center">

                <p class="text-2xl font-black mb-2">
                    Belum Ada Transaksi
                </p>
                <p class="text-retro-border/60 mb-6">
                    Anda belum memproses transaksi apapun
                </p>

                @if(Auth::user()->isKasirOnline())
                    <a href="{{ route('kasir.transaksi.index') }}"
                       class="inline-flex items-center px-6 py-3
                              bg-primary text-white font-black uppercase
                              border-2 border-retro-border rounded
                              shadow-retro-sm">
                        Lihat Pending
                    </a>
                @else
                    <a href="{{ route('kasir-offline.dashboard') }}"
                       class="inline-flex items-center px-6 py-3
                              bg-primary text-white font-black uppercase
                              border-2 border-retro-border rounded
                              shadow-retro-sm">
                        Ke Dashboard
                    </a>
                @endif

            </section>

        @endif

    </main>
</x-app-layout>
