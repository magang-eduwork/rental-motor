@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
</div>

{{-- Wrapper: 2 section berdampingan pakai flexbox --}}
<div style="display: flex; gap: 1.5rem; align-items: stretch; min-height: 0;">

    {{-- ===== SECTION KIRI: Top Orderan + Jumlah Kendaraan + Pendapatan ===== --}}
    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 1.5rem;">

        {{-- Card: 5 Top Orderan Rental --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-base font-bold text-gray-800 mb-4">5 Top Orderan Rental</h3>
            <div class="flex flex-col sm:flex-row items-center justify-around gap-6">
                {{-- Donut Chart --}}
                <div class="relative flex items-center justify-center w-44 h-44 rounded-full border-[16px] border-blue-600 border-t-cyan-400 border-r-blue-900">
                    <div class="text-center">
                        <span class="block text-3xl font-extrabold text-gray-800">{{ $totalSemuaOrder ?? 0 }}</span>
                        <span class="text-xs text-gray-400">Orderan</span>
                    </div>
                </div>
                {{-- Legend --}}
                <div class="w-full sm:w-1/2 space-y-2">
                    @php
                        $colors = ['bg-blue-900', 'bg-blue-600', 'bg-blue-400', 'bg-cyan-400', 'bg-blue-200'];
                    @endphp
                    @forelse($topOrderan ?? [] as $index => $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-600">
                                <span class="w-3 h-3 rounded-full {{ $colors[$index % count($colors)] }} mr-2"></span>
                                {{ $item['nama_motor'] }}
                            </span>
                            <span class="font-semibold text-gray-800">{{ $item['total'] }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 italic text-center">Belum ada data orderan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Row: Jumlah Kendaraan & Pendapatan berdampingan --}}
        <div style="display: flex; gap: 1.5rem;">

            {{-- Card: Jumlah Kendaraan --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm" style="flex: 1; min-width: 0;">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-base font-bold text-gray-800 flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-2"></span>
                        Jumlah Kendaraan
                    </h3>
                    <span class="text-xl font-bold text-blue-600">{{ $totalKendaraan ?? 0 }}</span>
                </div>

                {{-- Info Tersedia & Disewa --}}
                <div class="border-t pt-3 space-y-3 mb-5">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Tersedia</span>
                        <span class="font-semibold text-gray-800">{{ $kendaraanTersedia ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Sedang disewa</span>
                        <span class="font-semibold text-gray-800">{{ $kendaraanDisewa ?? 0 }}</span>
                    </div>
                </div>

                {{-- Diagram per Tipe Kendaraan (Vertical Bar Chart) --}}
                <div class="border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Kendaraan per Tipe</p>
                    <div style="position: relative; height: 160px; width: 100%;">
                        <canvas id="chartKendaraanTipe"></canvas>
                    </div>
                </div>
            </div>

            @php
                $tipeLabels = $kendaraanPerTipe->pluck('tipe')->toArray();
                $tipeData   = $kendaraanPerTipe->pluck('total')->toArray();
                $tipeBarColors = ['#1e3a8a','#38bdf8','#1e3a8a','#93c5fd','#0e7490','#bfdbfe'];
            @endphp

            {{-- Card: Pendapatan --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm" style="flex: 1; min-width: 0;">
                <form action="" method="GET" id="income-filter-form">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center mb-6">
                        <span class="w-3 h-3 rounded-full bg-blue-400 mr-2"></span> Pendapatan
                    </h3>
                    <div class="grid grid-cols-3 gap-3 items-start pb-6 mb-4 border-b border-gray-100">
                        {{-- Tipe Kendaraan --}}
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Tipe Kendaraan</label>
                            <select name="tipe_kendaraan"
                                    onchange="document.getElementById('income-filter-form').submit()"
                                    class="w-full text-sm text-gray-600 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                                <option value="Semua" {{ request('tipe_kendaraan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                @foreach($tipeKendaraanOptions ?? [] as $tipe)
                                    <option value="{{ $tipe }}" {{ request('tipe_kendaraan') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        {{-- Awal --}}
                        <div class="relative border-l border-gray-200 pl-3">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Awal</label>
                            <input type="date" name="tanggal_awal"
                                   value="{{ request('tanggal_awal') }}"
                                   onchange="document.getElementById('income-filter-form').submit()"
                                   class="w-full text-sm text-gray-600 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        {{-- Akhir --}}
                        <div class="relative border-l border-gray-200 pl-3">
                            <label class="block text-sm font-bold text-gray-900 mb-1">Akhir</label>
                            <input type="date" name="tanggal_akhir"
                                   value="{{ request('tanggal_akhir') }}"
                                   onchange="document.getElementById('income-filter-form').submit()"
                                   class="w-full text-sm text-gray-600 bg-transparent border-none p-0 pr-6 focus:ring-0 cursor-pointer appearance-none font-medium">
                            <div class="absolute inset-y-0 right-1 top-6 flex items-center pointer-events-none text-gray-800">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-3xl font-bold text-gray-950">Total Pendapatan</p>
                        <p class="text-l text-gray-400 mt-0.5">Seluruh pendapatan rental</p>
                    </div>
                    <span class="text-3xl font-black text-gray-900 tracking-tight">
                        Rp{{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                <div style="margin-top: 1.5rem;">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <div>
                            <p class="text-xl font-semibold text-gray-700">Jumlah Bookingan</p>
                            <p class="text-l text-gray-400">Total seluruh booking yang sudah lunas</p>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $jumlahBookingan ?? 0 }}</span>
                    </div>
                </div>
            </div>

        </div>{{-- end row jumlah + pendapatan --}}

    </div>{{-- end section kiri --}}

    {{-- ===== SECTION KANAN: Pesanan Terakhir ===== --}}
    <div style="width: 700px; flex-shrink: 0; display: flex; flex-direction: column;">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col" style="flex: 1; overflow: hidden;">
            <div class="flex justify-between items-center mb-4" style="flex-shrink: 0;">
                <h1 class="text-3xl font-bold text-gray-800">Pesanan Terakhir</h1>
                <a href="{{ route('admin.pesanan.index') }}" class="text-l text-blue-600 font-semibold hover:underline">Lihat semua</a>
            </div>
            {{-- List Pesanan --}}
            <div style="overflow-y: auto; flex: 1;">
                @forelse($pesananTerakhir ?? [] as $order)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition-all border-b border-gray-50 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 overflow-hidden">
                            @if($order->product && $order->product->image_url)
                                <img src="{{ $order->product->image_url }}" alt="{{ $order->product->nama_motor }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-motorcycle text-xl"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $order->product->nama_motor ?? $order->nama_motor ?? 'Kendaraan' }}</p>
                            <p class="text-xs text-blue-500 font-medium">{{ $order->product->tipe ?? 'Matic' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400">{{ $order->created_at ? $order->created_at->translatedFormat('d M Y') : '' }}</p>
                        <p class="text-sm font-bold text-gray-800">Rp{{ number_format($order->harga ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-400 italic">Belum ada pesanan terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>{{-- end section kanan --}}

</div>{{-- end wrapper flex --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chartKendaraanTipe').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($tipeLabels) !!},
                datasets: [{
                    data: {!! json_encode($tipeData) !!},
                    backgroundColor: [
                        '#1e3a8a',
                        '#38bdf8',
                        '#2563eb',
                        '#93c5fd',
                        '#06b6d4',
                        '#bfdbfe'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection