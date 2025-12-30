@extends('layouts.customer')

@section('content')
    <main class="min-h-screen py-12">

        <!-- WRAPPER -->
        <div class="max-w-[90%] lg:max-w-[80%] mx-auto space-y-10">

            <!-- SUCCESS HERO -->
            <section class="bg-white border-2 border-black rounded-2xl shadow-retro-lg p-10 text-center">

                <div
                    class="mx-auto mb-6 size-24 rounded-full bg-green-200 border-2 border-black flex items-center justify-center shadow-retro">
                    <span class="material-symbols-outlined text-5xl text-green-800">
                        check_circle
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-3">
                    Pesanan Berhasil
                </h1>

                <p class="text-lg font-medium text-gray-700 mb-8">
                    Pesanan kamu berhasil dibuat dan sedang menunggu konfirmasi pembayaran
                </p>

                <!-- NO TRANSAKSI -->
                <div class="inline-block bg-cream-accent border-2 border-black rounded-xl px-8 py-4 shadow-retro">
                    <p class="text-xs font-bold uppercase text-gray-600 mb-1">
                        No Transaksi
                    </p>
                    <p class="text-2xl font-black tracking-widest">
                        {{ $transaksi->no_transaksi }}
                    </p>
                </div>
            </section>

            <!-- DETAIL PESANAN -->
            <section class="bg-white border-2 border-black rounded-2xl shadow-retro p-10 space-y-10">

                <h2 class="text-2xl font-black uppercase tracking-tight border-b-2 border-dashed border-black pb-4">
                    Detail Pesanan
                </h2>

                <!-- INFORMASI PEMBELI -->
                <div class="space-y-4">
                    <h3 class="font-black uppercase text-lg">
                        Informasi Pembeli
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-500">Nama</p>
                            <p class="font-medium">{{ $transaksi->nama_pembeli }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase text-gray-500">No. Telepon</p>
                            <p class="font-medium">{{ $transaksi->no_telp_pembeli }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs font-bold uppercase text-gray-500">Alamat Pengiriman</p>
                            <p class="font-medium">{{ $transaksi->alamat }}</p>
                        </div>
                    </div>
                </div>

                <!-- ITEM PESANAN -->
                <div class="space-y-6">
                    <h3 class="font-black uppercase text-lg">
                        Item Pesanan
                    </h3>

                    <div class="space-y-5">
                        @foreach($transaksi->items as $item)
                            <div class="flex items-center gap-5 border-b-2 border-dashed border-black/30 pb-4">

                                <!-- IMAGE -->
                                <div class="w-20 h-20 rounded-lg border-2 border-black bg-white overflow-hidden shrink-0">
                                    @if($item->kaos->foto_kaos)
                                        <img src="{{ asset('storage/' . $item->kaos->foto_kaos) }}" alt="{{ $item->kaos->merek }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400">
                                            NO IMAGE
                                        </div>
                                    @endif
                                </div>

                                <!-- INFO -->
                                <div class="flex-1">
                                    <p class="font-black uppercase leading-tight">
                                        {{ $item->kaos->merek }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->kaos->warna_kaos }} • {{ $item->kaos->ukuran }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Qty {{ $item->jumlah }} × Rp {{ number_format($item->kaos->harga_jual, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- SUBTOTAL -->
                                <div class="font-black whitespace-nowrap">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- RINGKASAN -->
                <div class="space-y-3 pt-6 border-t-2 border-black">

                    <div class="flex justify-between font-medium">
                        <span>Subtotal</span>
                        <span class="font-bold">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between font-medium">
                        <span>Ongkir ({{ $transaksi->total_berat }} kg)</span>
                        <span class="font-bold">
                            Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-xl font-black pt-4 border-t-2 border-dashed border-black">
                        <span>Total Pembayaran</span>
                        <span class="text-primary">
                            Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </section>

            <!-- NEXT STEP -->
            <section class="bg-cream-accent border-2 border-black rounded-2xl shadow-retro p-8">

                <h3 class="text-xl font-black uppercase mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">info</span>
                    Langkah Selanjutnya
                </h3>

                <ol class="list-decimal list-inside space-y-2 text-sm font-medium text-gray-800">
                    <li>Pesanan akan dikonfirmasi oleh kasir</li>
                    <li>Lakukan pembayaran via <strong>Bank Transfer</strong></li>
                    <li>Kirim bukti pembayaran ke WhatsApp <strong>081234567890</strong></li>
                    <li>Pesanan diproses setelah pembayaran dikonfirmasi</li>
                    <li>Barang dikirim ke alamat tujuan</li>
                </ol>
            </section>

            <!-- PAYMENT INFO -->
            <section class="bg-white border-2 border-black rounded-2xl shadow-retro p-8">

                <h3 class="text-xl font-black uppercase mb-6">
                    Informasi Pembayaran
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-cream-accent border-2 border-black rounded-xl p-5 shadow-retro-sm">
                        <p class="text-xs font-bold uppercase text-gray-600">Bank BCA</p>
                        <p class="text-xl font-black tracking-wider">1234567890</p>
                        <p class="text-sm font-medium">a.n. DistroZone</p>
                    </div>

                    <div class="bg-cream-accent border-2 border-black rounded-xl p-5 shadow-retro-sm">
                        <p class="text-xs font-bold uppercase text-gray-600">Bank Mandiri</p>
                        <p class="text-xl font-black tracking-wider">0987654321</p>
                        <p class="text-sm font-medium">a.n. DistroZone</p>
                    </div>
                </div>

                <p class="text-xs font-bold text-gray-700 mt-4">
                    ⚠️ Transfer sesuai nominal dan konfirmasi ke WhatsApp kami
                </p>
            </section>

            <!-- ACTION -->
            <div class="flex justify-center">
                <a href="{{ route('customer.catalog') }}"
                    class="inline-flex items-center gap-2 bg-primary text-white font-black uppercase px-10 py-4 rounded-xl border-2 border-black shadow-retro hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                    Kembali ke Katalog
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>

        </div>
    </main>

@endsection
