@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri & Tengah (Statistik) -->
    <div class="xl:col-span-2 space-y-6">
        
        <!-- Row 1: 5 Top Orderan Rental -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-base font-bold text-gray-800 mb-4">5 Top Orderan Rental</h3>
            <div class="flex flex-col sm:flex-row items-center justify-around gap-6">
                <!-- Donut Chart Mockup -->
                <div class="relative flex items-center justify-center w-44 h-44 rounded-full border-[16px] border-blue-600 border-t-cyan-400 border-r-blue-900">
                    <div class="text-center">
                        <span class="block text-3xl font-extrabold text-gray-800">620</span>
                        <span class="text-xs text-gray-400">Orderan</span>
                    </div>
                </div>
                <!-- Keterangan Data -->
                <div class="w-full sm:w-1/2 space-y-2">
                    <div class="flex justify-between items-center text-sm"><span class="flex items-center text-gray-600"><span class="w-3 h-3 rounded-full bg-blue-900 mr-2"></span> Genio</span> <span class="font-semibold text-gray-800">300</span></div>
                    <div class="flex justify-between items-center text-sm"><span class="flex items-center text-gray-600"><span class="w-3 h-3 rounded-full bg-blue-600 mr-2"></span> Supra X 125 FI</span> <span class="font-semibold text-gray-800">150</span></div>
                    <div class="flex justify-between items-center text-sm"><span class="flex items-center text-gray-600"><span class="w-3 h-3 rounded-full bg-blue-400 mr-2"></span> X-Ride 125</span> <span class="font-semibold text-gray-800">130</span></div>
                    <div class="flex justify-between items-center text-sm"><span class="flex items-center text-gray-600"><span class="w-3 h-3 rounded-full bg-cyan-400 mr-2"></span> XMAX 250</span> <span class="font-semibold text-gray-800">81</span></div>
                    <div class="flex justify-between items-center text-sm"><span class="flex items-center text-gray-600"><span class="w-3 h-3 rounded-full bg-blue-200 mr-2"></span> Fino 125</span> <span class="font-semibold text-gray-800">59</span></div>
                </div>
            </div>
        </div>

        <!-- Row 2: Dua Card Berjejer (Jumlah Kendaraan & Pendapatan) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Jumlah Kendaraan -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-base font-bold text-gray-800 flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-2"></span> Jumlah Kendaraan</h3>
                    <span class="text-xl font-bold text-blue-600">30</span>
                </div>
                <div class="border-t pt-3 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600"><span>Tersedia</span><span class="font-semibold text-gray-800">10</span></div>
                    <div class="flex justify-between text-sm text-gray-600"><span>Jumlah bookingan</span><span class="font-semibold text-gray-800">10</span></div>
                    <div class="flex justify-between text-sm text-gray-600"><span>Sedang disewa</span><span class="font-semibold text-gray-800">10</span></div>
                </div>
            </div>

            <!-- Card Pendapatan -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <form action="" method="GET" id="income-filter-form">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center mb-6">
                        <span class="w-3 h-3 rounded-full bg-blue-400 mr-2"></span> Pendapatan
                    </h3>
                    
                    <div class="grid grid-cols-3 gap-3 items-start pb-6 mb-4 border-b border-gray-100">
                        <!-- Tipe Kendaraan -->
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Tipe Kendaraan</label>
                            <select name="tipe_kendaraan" 
                                    onchange="document.getElementById('income-filter-form').submit()"
                                    class="w-full text-sm text-gray-400 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                                <option value="Semua" {{ request('tipe_kendaraan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                <option value="Matic" {{ request('tipe_kendaraan') == 'Matic' ? 'selected' : '' }}>Matic</option>
                                <option value="Bebek" {{ request('tipe_kendaraan') == 'Bebek' ? 'selected' : '' }}>Motor Bebek</option>
                            </select>
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Kalender Awal -->
                        <div class="relative border-l border-gray-200 pl-3">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Awal</label>
                            <input type="date" name="tanggal_awal" 
                                   value="{{ request('tanggal_awal', '2022-07-21') }}"
                                   onchange="document.getElementById('income-filter-form').submit()"
                                   class="w-full text-sm text-gray-400 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Kalender Akhir -->
                        <div class="relative border-l border-gray-200 pl-3">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Akhir</label>
                            <input type="date" name="tanggal_akhir" 
                                   value="{{ request('tanggal_akhir', '2022-07-21') }}"
                                   onchange="document.getElementById('income-filter-form').submit()"
                                   class="w-full text-sm text-gray-400 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-2xl font-bold text-gray-950">Total Pendapatan</p>
                        <p class="text-xs text-gray-400 mt-0.5">Seluruh pendapatan rental</p>
                    </div>
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        Rp{{ number_format($totalPendapatan ?? 100000000, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Kolom Kanan (Pesanan Terakhir) -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-base font-bold text-gray-800">Pesanan Terakhir</h3>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat semua</a>
        </div>
        
        <!-- List Pesanan -->
        <div class="space-y-4 max-h-[520px] overflow-y-auto pr-1">
            @forelse($pesananTerakhir ?? [] as $order)
            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition-all border-b border-gray-50 pb-3">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-motorcycle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $order->nama_motor ?? 'Genio' }}</p>
                        <p class="text-xs text-blue-500 font-medium">{{ $order->tipe_kendaraan ?? 'Matic' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($order->created_at ?? now())->translatedFormat('d M Y') }}</p>
                    <p class="text-sm font-bold text-gray-800">Rp{{ number_format($order->harga ?? 75000, 0, ',', '.') }}</p>
                </div>
            </div>
            @empty
                <!-- Fallback Mockup Data jika controller belum mengirim variabel dinamis -->
                @for ($i = 0; $i < 8; $i++)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition-all border-b border-gray-50 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-motorcycle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Genio</p>
                            <p class="text-xs text-blue-500 font-medium">Matic</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400">24 Des 2025</p>
                        <p class="text-sm font-bold text-gray-800">Rp75.000</p>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </div>

</div>
@endsection