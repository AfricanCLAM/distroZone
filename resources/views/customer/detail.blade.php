@extends('layouts.customer')

@section('content')

    <div class="layout-container flex h-full grow flex-col px-4 md:px-10 lg:px-40 py-8">

        <!-- BREADCRUMB -->
        <div class="mb-6 flex flex-wrap gap-2 text-sm font-bold uppercase tracking-wider">
            <a href="{{ route('customer.catalog') }}" class="text-[#996b4d] hover:text-primary">Katalog</a>
            <span class="text-[#1b130e] font-black">/</span>
            <span class="text-[#1b130e]">{{ $kaos->merek }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- LEFT: IMAGE -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <div
                    class="w-full aspect-[4/5] md:aspect-square lg:aspect-[4/3] rounded-xl overflow-hidden border-2 border-retro-border shadow-retro relative bg-white group">

                    @if ($kaos->foto_kaos)
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                            style="background-image: url('{{ asset('storage/' . $kaos->foto_kaos) }}');">
                        </div>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold">
                            NO IMAGE
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT: PRODUCT DETAIL -->
            <div class="lg:col-span-5 flex flex-col gap-8">

                <!-- HEADER -->
                <div class="border-b-2 border-retro-border pb-6 border-dashed">
                    <h1
                        class="text-[#1b130e] text-4xl lg:text-5xl font-black uppercase leading-[0.9] tracking-tighter mb-4">
                        {{ $kaos->merek }}
                    </h1>

                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-bold text-[#1b130e]">
                            Rp {{ number_format($kaos->harga_jual, 0, ',', '.') }}
                        </p>

                        <span
                            class="px-3 py-1 text-xs font-black rounded border-2 border-retro-border
                                    {{ $kaos->stok_kaos > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $kaos->stok_kaos > 0 ? 'STOK ' . $kaos->stok_kaos : 'HABIS' }}
                        </span>
                    </div>
                </div>

                <!-- INFO -->
                <div class="space-y-2 text-sm font-bold text-[#5c4033]">
                    <p>Jenis : {{ $kaos->tipe }}</p>
                    <p>Warna : {{ $kaos->warna_kaos }}</p>
                    <p>Ukuran : {{ $kaos->ukuran }}</p>
                </div>

                <!-- CART FORM -->
                @if ($kaos->stok_kaos > 0)
                    <form action="{{ route('customer.cart.add', $kaos->id_kaos) }}" method="POST" class="flex flex-col gap-6">
                        @csrf

                        <div class="flex gap-4">

                            <!-- STEPPER -->
                            <div
                                class="flex h-14 w-32 items-stretch rounded-lg border-2 border-retro-border bg-white shadow-retro-sm">
                                <button type="button"
                                    class="flex w-10 items-center justify-center text-xl font-black hover:bg-cream-accent"
                                    onclick="decrementQty()">−</button>

                                <input id="quantity" name="quantity" type="number" value="1" min="1"
                                    max="{{ $kaos->stok_kaos }}"
                                    class="w-full text-center text-lg font-black focus:ring-0 border-none">

                                <button type="button"
                                    class="flex w-10 items-center justify-center text-xl font-black hover:bg-cream-accent"
                                    onclick="incrementQty()">+</button>
                            </div>

                            <!-- ADD TO CART -->
                            <button
                                class="flex-1 rounded-lg border-2 border-retro-border bg-primary px-6 text-base font-black uppercase tracking-wider text-white shadow-retro transition-all hover:bg-[#b04b0f] hover:translate-y-[2px] hover:shadow-retro-hover h-14 flex items-center justify-center gap-2"
                                type="submit">
                                <span class="material-symbols-outlined">shopping_bag</span>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <button disabled
                        class="h-14 w-full rounded-lg bg-gray-300 text-gray-500 font-black uppercase cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif

                <!-- SHIPPING INFO -->
                <div
                    class="flex items-start gap-4 p-4 bg-cream-accent rounded-lg border-2 border-dashed border-retro-border">
                    <span class="material-symbols-outlined text-primary text-3xl mt-1">local_shipping</span>
                    <div>
                        <h4 class="font-bold text-[#1b130e] text-sm uppercase mb-1">Pengiriman</h4>
                        <p class="text-sm text-[#5c4033] leading-snug">
                            Ongkir dihitung saat checkout,Setiap Daerah Memiliki Biaya Ongkir Yang Berbeda
                        </p>
                    </div>
                </div>

                <a href="{{ route('customer.catalog') }}"
                    class="text-sm font-bold uppercase tracking-wide text-primary hover:underline">
                    ← Kembali ke Katalog
                </a>

            </div>
        </div>

        <div class="mt-20 border-t-2 border-retro-border pt-12">
            <h3 class="text-2xl font-black uppercase mb-8 flex items-center gap-3">
                <span class="w-8 h-8 bg-[#1b130e] text-white flex items-center justify-center rounded text-sm">#</span>
                You Might Also Like
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Product Card  -->
                @foreach ($reccomendations as $reccomendation)
                    <div class="group flex flex-col gap-3">
                        <div
                            class="relative aspect-[3/4] w-full overflow-hidden rounded-lg border-2 border-retro-border bg-white shadow-retro transition-all group-hover:-translate-y-1 group-hover:shadow-[6px_6px_0px_0px_#1b130e]">
                            <div class="absolute inset-0 bg-cover bg-center" data-alt="White graphic tee with minimalist print"
                                style="background-image: url('{{ asset('storage/' . $reccomendation->foto_kaos) }}');">
                            </div>
                        </div>
                        <div>
                            <h4
                                class="font-bold text-[#1b130e] text-lg leading-tight group-hover:underline decoration-2 underline-offset-2">
                                {{ $reccomendation->merek }}</h4>
                            <p class="font-medium text-[#996b4d]">Rp {{ number_format($reccomendation->harga_jual, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach


    </main>

    <!-- JS QUANTITY (TETAP ADA) -->
    <script>
        const maxQty = {{ $kaos->stok_kaos }};

        function incrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) < maxQty) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>

@endsection
