@extends('layouts.app') 

@section('content')
<div class="container mx-auto py-16 px-6" 
     x-data="{ open: false, selectedOrder: null }" 
     x-cloak>
    
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Pesanan</h1>
        <p class="text-gray-600 mt-2">Semua riwayat dan detail pesanan motor Anda dalam satu tempat.</p>
    </div>

    {{-- Daftar Pesanan --}}
    <div class="grid gap-6 mb-16">
        @forelse($orders as $order)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
            <div class="w-full md:w-48 h-32 bg-gray-50 rounded-2xl overflow-hidden">
                <img src="https://i.ibb.co.com/VYfhgqm4/image-44.png" alt="{{ $order->nama_motor }}" class="w-full h-full object-cover">
            </div>

            <div class="flex-1 grid grid-cols-2 md:grid-cols-5 gap-4 w-full">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Motor</p>
                    <p class="font-bold text-gray-900">{{ $order->nama_motor }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Kode Booking</p>
                    <p class="font-bold text-gray-900">{{ $order->kode_booking }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Tanggal</p>
                    <p class="font-bold text-gray-900">{{ $order->tanggal_booking->format('d-m-Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Status</p>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $order->status }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Harga</p>
                    <p class="font-bold text-gray-900">Rp{{ number_format($order->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="w-full md:w-auto">
                <button 
                    type="button"
                    @click="
                        fetch('/daftar-pesanan/{{ $order->id }}')
                            .then(response => {
                                if (!response.ok) throw new Error('Gagal mengambil data');
                                return response.json();
                            })
                            .then(data => {
                                selectedOrder = data;
                                open = true;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat memuat detail.');
                            });
                    "
                    class="w-full text-center bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition cursor-pointer">
                    Detail
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-20 bg-gray-50 rounded-3xl">
            <p class="text-gray-500">Belum ada data pesanan.</p>
        </div>
        @endforelse
    </div>

    {{-- Pilihan Motor Terpopuler --}}
    <div class="border-t pt-16">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Pilihan Motor Terpopuler</h2>
            <a href="{{ route('kendaraan') }}" class="text-indigo-600 font-bold hover:underline">Lihat semua</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <article class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="mb-3">
                    <p class="font-bold text-gray-900">{{ $product->nama_motor }}</p>
                    <p class="text-sm text-gray-500">{{ $product->tipe }}</p>
                </div>
                <div class="h-32 flex items-center justify-center mb-4">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->nama_motor }}" class="max-h-full object-contain">
                </div>
                <div class="flex justify-between items-center text-xs mb-4">
                    <span class="text-gray-500">{{ $product->plat_nomor }}</span>
                    <span class="font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ ucfirst($product->status) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <strong class="text-lg text-gray-900">Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }}</strong>
                        <span class="text-gray-400 text-xs">/hari</span>
                    </div>
                    <a href="{{ route('kendaraan') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-indigo-700 transition">
                        Booking
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>

    {{-- Terms Section --}}
    <section class="bg-gray-50 rounded-3xl p-8 md:p-12 mb-16">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Syarat & Ketentuan Rental Motor</h2>
            <p class="text-gray-600 mb-8">
                Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum melakukan pemesanan.
            </p>
            <ol class="list-decimal list-inside space-y-4 text-gray-700">
                <li>Lakukan pemesanan minimal <strong>1×24 jam</strong> sebelum waktu penggunaan. Setelah pesanan dikonfirmasi, penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor whatsapp atau datang ke lokasi ED.RENT.</li>
                <li>Membawa <strong>2 kartu identitas</strong> (SIM A, KK, KTP, ID Kerja atau ID Pelajar).</li>
                <li>Menyertakan akun sosial media dan <strong>nomor whatsapp</strong> yang aktif.</li>
                <li>Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan <strong>pengecekan keaslian data</strong> dan kondisi kendaraan.</li>
                <li>Pihak penyedia rental <strong>berhak membatalkan</strong> apabila data tidak sesuai dan syarat sewa tidak dapat dilengkapi.</li>
                <li>Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia, penyewa <strong>berhak memilih kendaraan lain</strong> yang tersedia tanpa dikenakan biaya tambahan.</li>
            </ol>
        </div>
    </section>

    @include('order.detailorder')
</div>
@endsection