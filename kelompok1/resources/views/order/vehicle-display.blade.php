<x-app-layout>
    <div class="bg-gray-50 min-h-screen">

        {{-- Header --}}
        <section class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-10">

                <nav class="text-sm text-gray-500 mb-5">
                    <a href="{{ route('home') }}" class="hover:text-red-600">
                        Beranda
                    </a>

                    <span class="mx-2">/</span>

                    <span class="text-gray-700 font-medium">
                        Detail Kendaraan
                    </span>
                </nav>

                <div class="grid lg:grid-cols-2 gap-10 items-start">

                    {{-- FOTO --}}
                    <div>

                        @if($product->image_url)
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->nama_motor }}"
                                class="w-full rounded-2xl shadow-lg object-contain h-[450px] bg-white"
                            />
                        @else
                            <img
                                src="https://placehold.co/700x500?text=Motor"
                                alt="{{ $product->nama_motor }}"
                                class="w-full rounded-2xl shadow-lg object-cover h-[450px]"
                            />
                        @endif

                    </div>

                    {{-- DETAIL --}}
                    <div>

                        <div class="flex items-center gap-3 mb-3">

                            @if($product->status == 'tersedia')

                                <span
                                    class="bg-green-100
                                           text-green-700
                                           px-4 py-1
                                           rounded-full
                                           text-sm
                                           font-semibold">

                                    Tersedia

                                </span>

                            @else

                                <span
                                    class="bg-red-100
                                           text-red-700
                                           px-4 py-1
                                           rounded-full
                                           text-sm
                                           font-semibold">

                                    Tidak Tersedia

                                </span>

                            @endif

                        </div>

                        <h1
                            class="text-4xl
                                   font-bold
                                   text-gray-800
                                   leading-tight">

                            {{ $product->nama_motor }}

                        </h1>

                        <div class="mt-5">

                            <h2
                                class="text-3xl
                                       font-bold
                                       text-black-600">

                                Rp {{ number_format($product->harga_per_hari,0,',','.') }}

                                <span
                                    class="text-lg
                                           font-normal
                                           text-gray-500">

                                    / hari

                                </span>

                            </h2>

                        </div>

                        <div class="mt-8">

                            <p class="text-gray-600 leading-8">

                                {{ $product->nama_motor }} adalah pilihan ideal untuk Anda yang mencari kendaraan praktis, lincah, dan handal untuk mobilitas sehari-hari. 
                                Mesin 115cc yang responsif dan mudah dikendalikan, sangat cocok untuk menjelajahi jalanan padat perkotaan atau perjalanan jarak dekat dengan efisiensi maksimal.

                            </p>

                            <div class="mt-10 border-t pt-8">

                                <h3 class="text-2xl font-semibold text-gray-800 mb-6">
                                    Perlengkapan
                                </h3>

                                <div class="grid md:grid-cols-3 gap-6 text-gray-600">

                                    <ul class="space-y-3 list-disc list-inside">
                                        <li>Bensin 1 Liter</li>
                                        <li>Helm SNI 2 Buah</li>
                                    </ul>

                                    <ul class="space-y-3 list-disc list-inside">
                                        <li>Jas Hujan 2 Buah</li>
                                        <li>STNK</li>
                                    </ul>

                                    <ul class="space-y-3 list-disc list-inside">
                                        <li>Tas Belanja 1 Buah</li>
                                        <li>Sarung Tangan 1 Buah</li>
                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>

                {{-- Informasi Kendaraan --}}
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4">

                <div class="grid lg:grid-cols-3 gap-8">

                    {{-- Spesifikasi --}}
                    <div class="lg:col-span-2">

                        <div class="bg-white rounded-2xl shadow p-8">

                            <h2 class="text-2xl font-bold mb-6">
                                Spesifikasi Kendaraan
                            </h2>

                            <div class="grid md:grid-cols-2 gap-6">

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Nama Kendaraan
                                    </p>

                                    <p class="font-semibold text-lg mt-2">
                                        {{ $product->nama_motor }}
                                    </p>
                                </div>

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Tipe Kendaraan
                                    </p>

                                    <p class="font-semibold text-lg mt-2">
                                        {{ $product->tipe }}
                                    </p>
                                </div>

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Plat Nomor
                                    </p>

                                    <p class="font-semibold text-lg mt-2">
                                        {{ $product->plat_nomor }}
                                    </p>
                                </div>

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Harga Sewa
                                    </p>

                                    <p class="font-semibold text-lg mt-2 text-black-600">
                                        Rp {{ number_format($product->harga_per_hari,0,',','.') }}/Hari
                                    </p>
                                </div>

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Kapasitas Tangki Bensin
                                    </p>

                                    <p class="font-semibold text-lg mt-2">
                                        5 Liter
                                    </p>
                                </div>

                                <div class="border rounded-xl p-5">
                                    <p class="text-gray-500 text-sm">
                                        Status
                                    </p>

                                    @if($product->status == 'tersedia')

                                        <span
                                            class="inline-flex
                                                   px-3
                                                   py-1
                                                   rounded-full
                                                   bg-green-100
                                                   text-green-700
                                                   font-semibold">

                                            Tersedia

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex
                                                   px-3
                                                   py-1
                                                   rounded-full
                                                   bg-red-100
                                                   text-red-700
                                                   font-semibold">

                                            Tidak Tersedia

                                        </span>

                                    @endif

                                </div>

                            </div>

                            <div class="mt-10">

                                <h3 class="text-xl font-bold mb-4">
                                    Deskripsi
                                </h3>

                                <p class="leading-8 text-gray-600">
                                    Motor dalam kondisi prima, rutin diservis, bersih, nyaman digunakan
                                    untuk perjalanan dalam maupun luar kota.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Booking Card --}}
                    <div>

                        <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-24">

                            <h2 class="text-2xl font-bold mb-6">
                                Ringkasan
                            </h2>

                            <div class="flex justify-between mb-4">
                                <span>Harga / Hari</span>

                                <span class="font-bold text-black-600">
                                    Rp {{ number_format($product->harga_per_hari,0,',','.') }}
                                </span>
                            </div>

                            <div class="flex justify-between mb-4">
                                <span>Stok</span>

                                <span class="font-semibold">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>

                            <hr class="my-6">

                            @if($product->status == 'tersedia')

                                <a
                                    href="{{ route('booking.checkout', $product->id) }}"
                                    class="block
                                           w-full
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           text-center
                                           py-4
                                           rounded-xl
                                           font-semibold
                                           transition">

                                    Booking Sekarang

                                </a>

                            @else

                                <button
                                    disabled
                                    class="w-full
                                           bg-gray-400
                                           text-white
                                           py-4
                                           rounded-xl
                                           cursor-not-allowed">

                                    Kendaraan Tidak Tersedia

                                </button>

                            @endif

                            <a
                                href="{{ route('kendaraan') }}"
                                class="block
                                       text-center
                                       mt-4
                                       border
                                       border-gray-300
                                       rounded-xl
                                       py-4
                                       hover:bg-gray-100">

                                ← Kembali

                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </section>

                {{-- Informasi Penyewaan --}}
        <section class="pb-14">
            <div class="max-w-7xl mx-auto px-4">

                <div class="bg-white rounded-2xl shadow p-8">

                    <h2 class="text-2xl font-bold mb-6">
                        Informasi Penyewaan
                    </h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div class="border rounded-xl p-5">
                            <p class="text-gray-500 text-sm">
                                Durasi Minimal
                            </p>

                            <p class="font-semibold mt-2">
                                1 Hari
                            </p>
                        </div>

                        <div class="border rounded-xl p-5">
                            <p class="text-gray-500 text-sm">
                                Pembayaran
                            </p>

                            <p class="font-semibold mt-2">
                                Mudah, Aman, dan Cepat
                            </p>
                        </div>

                        <div class="border rounded-xl p-5">
                            <p class="text-gray-500 text-sm">
                                Pengambilan
                            </p>

                            <p class="font-semibold mt-2">
                                Sesuai Jam Booking
                            </p>
                        </div>

                        <div class="border rounded-xl p-5">
                            <p class="text-gray-500 text-sm">
                                Pengembalian
                            </p>

                            <p class="font-semibold mt-2">
                                Tepat Waktu
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </div>
</x-app-layout>