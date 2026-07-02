@extends('layouts.app') 

@section('content')
<div class="container mx-auto py-16 px-6">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Pesanan</h1>
        <p class="text-gray-600 mt-2">Semua riwayat dan detail pesanan motor Anda dalam satu tempat.</p>
    </div>

    <!-- Daftar Card -->
    <div class="grid gap-6">
        @forelse($orders as $order)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
            <!-- Gambar -->
            <div class="w-full md:w-48 h-32 bg-gray-50 rounded-2xl overflow-hidden">
                <img src="https://i.ibb.co.com/VYfhgqm4/image-44.png" alt="{{ $order->nama_motor }}" class="w-full h-full object-cover">
            </div>

            <!-- Detail -->
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
                    <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($order->tanggal_booking)->format('d-m-Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Status</p>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold 
                        {{ $order->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $order->status }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase">Harga</p>
                    <p class="font-bold text-gray-900">Rp{{ number_format($order->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Aksi -->
            <div class="w-full md:w-auto">
                <a href="#" class="block text-center bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition">Detail</a>
            </div>
        </div>
        @empty
        <div class="text-center py-20 bg-gray-50 rounded-3xl">
            <p class="text-gray-500">Belum ada data pesanan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection