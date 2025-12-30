@extends('layouts.customer')

@section('content')

    <!-- HEADER -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-8 mt-8">
        <h3 class="text-2xl font-black uppercase">Katalog Produk</h3>
    </div>

    <!-- MAIN CONTENT LAYOUT -->
    <div class="flex-grow w-full max-w-[1440px] mx-auto px-4 sm:px-8 py-8 flex gap-8">

        <!-- SIDEBAR FILTER -->
        <aside class="hidden lg:flex flex-col w-64 shrink-0 gap-6">
    <form method="GET" action="{{ route('customer.catalog') }}"
        class="border-2 border-retro-border bg-white rounded-lg shadow-retro p-5">

        <div class="flex items-center gap-2 mb-6 border-b-2 border-retro-border pb-3">
            <span class="material-symbols-outlined">filter_list</span>
            <h3 class="font-black text-lg uppercase">Saring Produk</h3>
        </div>

        {{-- KATEGORI / TIPE --}}
        <div class="mb-6">
            <h4 class="font-bold mb-3">KATEGORI</h4>
            <ul class="space-y-2">
                @foreach (['Lengan Panjang', 'Lengan Pendek'] as $tipe)
                    <li>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="tipe[]"
                                value="{{ $tipe }}"
                                @checked(in_array($tipe, request('tipe', [])))
                                class="h-5 w-5 rounded border-2 border-retro-border">
                            <span class="font-medium">{{ $tipe }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- UKURAN --}}
        <div class="mb-6">
            <h4 class="font-bold mb-3">UKURAN</h4>
            <div class="grid grid-cols-4 gap-2">
                @foreach (['S', 'M', 'L', 'XL'] as $size)
                    <label>
                        <input type="checkbox" name="size[]"
                            value="{{ $size }}"
                            class="hidden peer"
                            @checked(in_array($size, request('size', [])))>
                        <div
                            class="h-10 flex items-center justify-center border-2 border-retro-border rounded
                                   bg-cream-accent font-bold cursor-pointer
                                   peer-checked:bg-retro-border peer-checked:text-white">
                            {{ $size }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="mb-6">
            <input type="text" name="q"
                value="{{ request('q') }}"
                placeholder="Search products..."
                class="w-full border-2 border-retro-border rounded px-3 py-2">
        </div>

        <button
            class="w-full bg-retro-border text-white font-bold py-3 rounded shadow-retro-sm hover:bg-primary">
            TERAPKAN
        </button>
    </form>
</aside>


        <!-- PRODUCT GRID -->
        <div class="flex-1">

            @if ($kaos->count())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

                    @foreach ($kaos as $item)
                        <article
                            class="group flex flex-col border-2 border-retro-border bg-white rounded-lg shadow-retro hover:shadow-retro-hover hover:-translate-y-1 transition-all duration-200">
                            <a href="{{ route('customer.detail', $item->id_kaos) }}">

                                <div
                                    class="relative aspect-[4/5] w-full overflow-hidden rounded-t-[6px] border-b-2 border-retro-border bg-gray-100 group">
                                    <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        src="{{ asset('storage/' . $item->foto_kaos) }}" />
                                </div>
                            </a>

                            <div class="p-4 flex flex-col gap-2 flex-grow">
                                <div class="flex justify-between items-start">
                                    <h3
                                        class="font-bold text-lg leading-tight text-retro-border line-clamp-2 group-hover:text-primary transition-colors">
                                        {{ $item->merek }}
                                    </h3>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">{{ $item->warna_kaos }} - {{ $item->tipe }}</p>
                                <div
                                    class="mt-auto pt-3 flex items-center justify-between border-t-2 border-dashed border-gray-200">
                                    <p class="text-primary font-black text-xl">
                                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    </p>
                                </div>
                                @if($item->stok_kaos > 0)
                                    <form action="{{ route('customer.cart.add', $item->id_kaos) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button
                                            class="mt-3 w-full bg-retro-border text-white font-bold py-2.5 px-4 border-2 border-retro-border rounded shadow-retro-sm active:translate-x-[2px] active:translate-y-[2px] active:shadow-none hover:bg-primary transition-all flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-xl">add_shopping_cart</span>
                                            KERANJANG
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="mt-3 w-full bg-retro-border text-white font-bold py-2.5 px-4 border-2 border-retro-border rounded shadow-retro-sm active:translate-x-[2px] active:translate-y-[2px] active:shadow-none hover:bg-primary transition-all flex items-center justify-center gap-2">
                                        STOK HABIS!
                                    </button>
                                @endif
                            </div>
                        </article>
                    @endforeach

                </div>

                <!-- PAGINATION -->
                <div class="flex justify-center pb-8">
                    {{ $kaos->links() }}
                </div>

            @else
                <div class="text-center py-20 text-gray-500 font-bold">
                    Produk belum tersedia
                </div>
            @endif

        </div>
    </main>

@endsection
