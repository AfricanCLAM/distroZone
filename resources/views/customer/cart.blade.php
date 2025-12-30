@extends('layouts.customer')

@section('content')
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-8 py-10">

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm font-bold mb-6">
            <a href="{{ route('customer.catalog') }}" class="text-text-muted hover:text-primary hover:underline">Katalog</a>
            <span class="text-text-muted">/</span>
            <span class="text-text-main">Keranjang</span>
        </div>

        <!-- Title -->
        <div class="mb-10 border-b-2 border-dashed border-retro-border/20 pb-6">
            <h1 class="text-4xl font-black uppercase text-text-main mb-2">
                Keranjang Belanja
            </h1>
            <p class="text-text-muted font-medium text-lg">
                Cek kembali item sebelum checkout
            </p>
        </div>

        @if(count($cartItems) > 0)
            <div class="flex flex-col lg:flex-row gap-10 items-start">

                <!-- LEFT : CART ITEMS -->
                <div class="flex-1 w-full flex flex-col gap-6">

                    @foreach($cartItems as $item)
                        <div
                            class="group flex flex-col sm:flex-row gap-6 p-5 bg-retro-cream border-2 border-retro-border rounded-lg shadow-retro-sm hover:shadow-retro transition-all">

                            <!-- Image -->
                            <div class="shrink-0">
                                <div
                                    class="w-full sm:w-32 aspect-square rounded border-2 border-retro-border bg-white overflow-hidden">
                                    @if($item['kaos']->foto_kaos)
                                        <img src="{{ asset('storage/' . $item['kaos']->foto_kaos) }}" alt="{{ $item['kaos']->merek }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="flex flex-col flex-1 justify-between gap-4">
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <h3 class="text-xl font-black uppercase text-text-main leading-tight">
                                            {{ $item['kaos']->merek }}
                                        </h3>
                                        <p class="text-sm font-medium text-text-muted">
                                            {{ $item['kaos']->warna_kaos }} | {{ $item['kaos']->ukuran }}
                                        </p>
                                        <p class="text-sm font-medium text-text-muted">
                                            {{ $item['kaos']->harga_jual }}
                                        </p>
                                    </div>

                                    <!-- Delete -->
                                    <form action="{{ route('customer.cart.remove', $item['kaos']->id_kaos) }}" method="POST"
                                        onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-text-muted hover:text-red-600 transition-colors">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Bottom -->
                                <div class="flex justify-between items-end flex-wrap gap-4">

                                    <!-- Quantity -->
                                    <form action="{{ route('customer.cart.update', $item['kaos']->id_kaos) }}" method="POST"
                                        class="flex items-center border-2 border-retro-border rounded bg-white h-10">
                                        @csrf
                                        @method('PATCH')

                                        <button type="button" onclick="updateQty(this, -1)"
                                            class="px-3 h-full font-black border-r border-retro-border/20 hover:bg-gray-100">
                                            -
                                        </button>

                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            max="{{ $item['kaos']->stok_kaos }}"
                                            class="w-14 text-center font-black text-text-main border-none focus:ring-0 p-0"
                                            onchange="this.form.submit()">

                                        <button type="button" onclick="updateQty(this, 1)"
                                            class="px-3 h-full font-black border-l border-retro-border/20 hover:bg-gray-100">
                                            +
                                        </button>
                                    </form>

                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-xs text-text-muted font-bold">Subtotal</p>
                                        <p class="text-xl font-black text-primary">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Continue Shopping -->
                    <a href="{{ route('customer.catalog') }}"
                        class="flex items-center gap-2 font-bold text-text-main hover:text-primary transition group w-fit mt-2">
                        <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">
                            arrow_back
                        </span>
                        Lanjut Belanja
                    </a>
                </div>

                <!-- RIGHT : SUMMARY -->
                <div class="w-full lg:w-[400px] shrink-0">
                    <div class="bg-white border-2 border-retro-border rounded-xl p-6 shadow-retro sticky top-28">

                        <h2 class="text-2xl font-black uppercase text-text-main mb-6 pb-4 border-b-2 border-retro-border/10">
                            Ringkasan
                        </h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between font-medium text-text-muted">
                                <span>
                                    Subtotal ({{ array_sum(array_column($cartItems, 'quantity')) }} item)
                                </span>
                                <span class="font-black text-text-main">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-retro-border/10 pt-4 mb-6">
                            <div class="flex justify-between items-end">
                                <span class="text-lg font-bold text-text-main">Total</span>
                                <span class="text-3xl font-black text-text-main">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-xs text-text-muted mt-1">
                                Ongkir dihitung saat checkout
                            </p>
                        </div>

                        <a href="{{ route('customer.checkout') }}"
                            class="w-full flex items-center justify-center gap-3 bg-primary text-white font-black text-lg py-4 rounded-lg border-2 border-retro-border shadow-retro hover:shadow-retro-hover hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                            Lanjut ke Checkout
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        <div class="mt-6 flex items-center justify-center gap-4 text-text-muted/50">
                            <span class="material-symbols-outlined text-3xl">lock</span>
                            <span class="material-symbols-outlined text-3xl">verified_user</span>
                            <span class="material-symbols-outlined text-3xl">local_shipping</span>
                        </div>
                        <p class="text-center text-xs text-text-muted mt-2 font-medium">Transaksi aman &amp; terenkripsi.</p>
                    </div>
                </div>

            </div>
            </div>
            </div>
        @else
            <!-- EMPTY CART -->
            <div class="bg-white border-2 border-retro-border rounded-xl p-12 text-center shadow-retro">
                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">
                    shopping_cart
                </span>
                <h2 class="text-2xl font-black text-text-main mb-2">
                    Keranjang Kosong
                </h2>
                <p class="text-text-muted mb-6">
                    Belum ada produk di keranjang
                </p>
                <a href="{{ route('customer.catalog') }}"
                    class="inline-block bg-primary text-white font-black px-6 py-3 rounded-lg border-2 border-retro-border shadow-retro hover:shadow-retro-hover transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </main>

    <script>
        function updateQty(btn, change) {
            const input = btn.parentElement.querySelector('input[name="quantity"]');
            const newVal = parseInt(input.value) + change;
            const max = parseInt(input.max);

            if (newVal >= 1 && newVal <= max) {
                input.value = newVal;
                input.form.submit();
            }
        }
    </script>

@endsection
