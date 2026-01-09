@extends('layouts.customer')

@section('content')
    <!-- Main Content Wrapper to offset fixed header -->
    <main class=" min-h-screen flex flex-col">
        <!-- Hero Section -->
        <section class="relative w-full bg-background-light border-b-2 border-black">
            <div class="max-w-[1440px] mx-auto px-4 md:px-10 py-12 md:py-20 lg:py-24">
                <div class="flex flex-col-reverse lg:flex-row gap-10 lg:gap-20 items-center">
                    <!-- Text Content -->
                    <div class="flex-1 flex flex-col items-start gap-6 z-10">
                        <div
                            class="inline-block px-3 py-1 bg-primary text-white text-xs font-bold uppercase tracking-wider border-2 border-black shadow-retro-sm rounded">
                            Edisi Terbatas 2025
                        </div>
                        <h1
                            class="text-5xl md:text-6xl lg:text-7xl font-black leading-[0.95] tracking-tight uppercase text-background-dark">
                            Gaya Jalanan <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-400">Masa
                                Kini</span>
                        </h1>
                        <p class="text-lg md:text-xl font-medium text-background-dark/80 max-w-md leading-relaxed">
                            Koleksi kaos distro premium dengan sentuhan retro. Tampil beda dengan desain yang berani dan
                            bahan berkualitas tinggi.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 mt-4 w-full sm:w-auto">
                            <a href="{{ route('customer.catalog') }}"
                                class="h-14 px-8 bg-primary text-white font-black uppercase tracking-wider rounded-lg border-2 border-black shadow-retro hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none transition-all duration-150 flex items-center justify-center gap-2">
                                Belanja Sekarang
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    <!-- Hero Image -->
                    <div class="flex-1 w-full max-w-[600px] relative">
                        <!-- Decorative Elements -->
                        <div
                            class="absolute -top-6 -right-6 size-24 bg-primary rounded-full border-2 border-black hidden md:flex items-center justify-center z-20 shadow-retro">
                            <span class="text-white font-black text-xl rotate-12">-20%</span>
                        </div>
                        <div class="w-full aspect-[4/5] md:aspect-square bg-cover bg-center rounded-lg border-2 border-black shadow-retro-lg relative overflow-hidden"
                            data-alt="Pria muda bergaya memakai kaos streetwear di depan tembok bata"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDZJY--0Ionb_Ljnm-FbooqWwFNwlXwHVoBDRr5bYJ-nYzkre45vFKKiyXikJGLENN89Fx2kY76BRpUiFEauuMHZ6-CbX5AvNnS4bBhTptLk8vm1n1taWfVEkQdtgrsavmDKPkX0TSrZNLn7W6laoSUQUyhC39AT7QidwNJhBz-VbsY5wLr-k6snt9wGsr4OgjuE2Uu6E_KUHWOCYVWmUoWrggLSQPfwnlMYuCsXS3TPuSncF4RYjGfUla_HiHpz3RhRf0-TLON6OGu');">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Marquee / Ticker -->
        <div class="w-full bg-primary border-b-2 border-black overflow-hidden py-3">
            <div class="flex whitespace-nowrap">
                <div
                    class="flex gap-8 items-center text-white font-black uppercase tracking-widest text-sm md:text-base animate-marquee">
                    <span>★</span>
                    <span>STYLE PALING TRENDY</span>
                    <span>★</span>
                    <span>BAHAN PREMIUM</span>
                    <span>★</span>
                    <span>DESAIN EKSKLUSIF</span>
                    <span>★</span>
                    <span>ONGKIR MURAH</span>
                    <span>★</span>

                    <!-- DUPLIKASI KONTEN -->
                    <span>STYLE PALING TRENDY</span>
                    <span>★</span>
                    <span>BAHAN PREMIUM</span>
                    <span>★</span>
                    <span>DESAIN EKSKLUSIF</span>
                    <span>★</span>
                    <span>ONGKIR MURAH</span>
                    <span>★</span>
                </div>
            </div>
        </div>

        <!-- Featured Products Section -->
        <section class="w-full bg-background-light py-16 px-4 md:px-10">
            <div class="max-w-[1440px] mx-auto flex flex-col gap-10">
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row justify-between items-end gap-4 border-b-2 border-black/10 pb-6">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black uppercase text-background-dark tracking-tight mb-2">
                            Produk Unggulan</h2>
                        <p class="text-background-dark/70 font-medium">Pilihan terbaik minggu ini untuk gaya maksimal.
                        </p>
                    </div>
                    <a class="text-primary font-bold uppercase tracking-wide flex items-center gap-1 hover:gap-2 transition-all"
                        href="{{ route('customer.catalog') }}">
                        Lihat Semua <span class="material-symbols-outlined text-lg">arrow_right_alt</span>
                    </a>
                </div>
                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card Kaos -->
                    @foreach ($kaos as $item)
                        <div
                            class="group flex flex-col bg-cream-accent rounded-lg border-2 border-black shadow-retro hover:shadow-retro-lg transition-all duration-300 h-full">
                            <div
                                class="aspect-square w-full p-4 border-b-2 border-black bg-white rounded-t-lg overflow-hidden relative">
                                <div class="w-full h-full bg-contain bg-center bg-no-repeat transition-transform duration-500 group-hover:scale-110"
                                    style="background-image: url({{ asset('storage/' . $item->foto_kaos) }});">
                                </div>
                                @if ($item->stok_kaos > 0)
                                    <form action="{{ route('customer.cart.add', $item->id_kaos) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1" />
                                        <button
                                            class="absolute bottom-3 right-3 size-10 bg-primary text-white rounded-full border-2 border-black flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-retro-sm hover:scale-105">
                                            <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="absolute bottom-3 right-3 size-10 bg-primary text-white rounded-full border-2 border-black flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-retro-sm hover:scale-105">
                                        <span class="text-gray-500">Stok Habis!</span>
                                    </button>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-1 justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-bold text-background-dark leading-tight uppercase">
                                        {{ $item->merek }}
                                    </h3>
                                    <p class="text-sm text-background-dark/60 font-medium mt-1">{{ $item->warna_kaos }}</p>
                                </div>
                                <div
                                    class="flex items-center justify-between mt-2 pt-3 border-t-2 border-black/5 border-dashed">
                                    <span class="text-lg font-black text-primary">Rp
                                        {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>
    @endsection
