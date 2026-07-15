@extends('layouts.app')
@section('title', 'Daftar Kendaraan')

@push('styles')
    @vite('resources/css/pages/kendaraan.css')
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="k-container">
        <span class="breadcrumb-text">Desktop · Daftar Kendaraan</span>
    </div>
</div>

{{-- Page Header --}}
<div class="k-container page-header">
    <h1 class="page-title">Daftar Kendaraan</h1>
    <p class="page-subtitle">
        Pilih kendaraan yang paling sesuai dengan gaya perjalanan dan budget Anda.
        Semua motor terawat, siap jalan!
    </p>
</div>

{{-- Flash success --}}
@if(session('success'))
<div class="k-container">
    <div class="alert-success">
        <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
</div>
@endif

{{-- Filter Bar --}}
<div class="k-container">
    <form method="GET" action="{{ route('kendaraan') }}" class="filter-bar" id="filter-form">

        {{-- Tipe Kendaraan --}}
        <div class="filter-group">
            <label class="filter-label">Tipe kendaraan</label>
            <div class="filter-select-wrap">
                <select name="tipe" class="filter-select" onchange="document.getElementById('filter-form').submit()">
                    <option value="Semua" {{ (request('tipe', 'Semua') === 'Semua') ? 'selected' : '' }}>Semua</option>
                    @foreach($tipes as $t)
                        <option value="{{ $t }}" {{ request('tipe') === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
                <svg class="filter-select-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

        {{-- Tanggal & Jam Sewa --}}
        <div class="filter-group filter-group--date">
            <label class="filter-label">Tanggal &amp; jam sewa</label>
            <div class="filter-date-wrap">
                <svg class="filter-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="4" width="16" height="14" rx="2"/>
                    <path d="M2 8h16M6 2v4M14 2v4"/>
                </svg>
                <input
                    type="date"
                    name="tanggal_sewa"
                    id="tanggal_sewa"
                    class="filter-input filter-input--date"
                    value="{{ request('tanggal_sewa', date('Y-m-d', strtotime('+1 day'))) }}"
                    min="{{ date('Y-m-d') }}"
                >
                <div class="filter-divider"></div>
                <svg class="filter-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="10" cy="10" r="8"/>
                    <path d="M10 6v4l2.5 2.5"/>
                </svg>
                <input
                    type="time"
                    name="jam_sewa"
                    id="jam_sewa"
                    class="filter-input filter-input--time"
                    value="{{ request('jam_sewa', '08:00') }}"
                >
            </div>
        </div>

        {{-- Durasi Sewa --}}
        <div class="filter-group">
            <label class="filter-label">Durasi sewa</label>
            <div class="filter-select-wrap">
                <select name="durasi" id="durasi" class="filter-select">
                    @foreach([1,2,3,5,7,14,30] as $d)
                        <option value="{{ $d }}" {{ request('durasi', 1) == $d ? 'selected' : '' }}>
                            {{ $d }} hari
                        </option>
                    @endforeach
                </select>
                <svg class="filter-select-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

        {{-- Search --}}
        <div class="filter-group filter-group--search">
            <label class="filter-label">Cari kendaraan</label>
            <div class="filter-search-wrap">
                <input
                    type="text"
                    name="cari"
                    class="filter-input filter-input--search"
                    placeholder="Nama motor"
                    value="{{ request('cari') }}"
                >
                <button type="submit" class="filter-search-btn" aria-label="Cari">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="9" r="6"/>
                        <path d="M15 15l-3.5-3.5"/>
                    </svg>
                </button>
            </div>
        </div>

    </form>
</div>

{{-- Vehicle Grid --}}
<div class="k-container" id="motor-grid-section">
    @if($products->isEmpty())
        <div class="empty-state">
            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="32" cy="32" r="28"/>
                <path d="M20 32h24M32 20v24"/>
            </svg>
            <p>Tidak ada kendaraan yang ditemukan.</p>
            <a href="{{ route('kendaraan') }}" class="empty-reset">Tampilkan semua</a>
        </div>
    @else
        <div class="k-grid">
            @foreach($products as $product)
            <article class="k-card">
                {{-- Header --}}
                <div class="k-card-meta">
                    <p class="k-card-name">{{ $product->nama_motor }}</p>
                    <p class="k-card-type">{{ $product->tipe }}</p>
                </div>

                {{-- Gambar --}}
                <div class="k-card-img">
                    <img src="{{ $product->image_url }}" alt="{{ $product->nama_motor }}" loading="lazy">
                </div>

                {{-- Info plat & status --}}
                <div class="k-card-info">
                    <div class="k-card-plat">
                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="5" width="16" height="10" rx="2"/>
                            <path d="M6 10h8"/>
                        </svg>
                        <span>{{ $product->plat_nomor }}</span>
                    </div>
                    @if(in_array($product->id, $bookedProductIds))
                        <span class="k-card-status k-card-status--unavailable bg-red-100 text-red-700">
                            Sudah di-booking
                        </span>
                    @else
                        <span class="k-card-status {{ $product->status === 'tersedia' ? 'k-card-status--available' : 'k-card-status--unavailable' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    @endif
                </div>

                {{-- Harga & Booking --}}
                <div class="k-card-footer">
                    <div class="k-card-price">
                        <strong>Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }}</strong>
                        <span class="k-price-unit">/ hari</span>
                    </div>

                    {{-- Tombol Booking --}}
                    @if(in_array($product->id, $bookedProductIds))
                        <span class="k-book-btn k-book-btn--disabled" title="Sudah di-booking pada tanggal ini">Sudah di-booking</span>
                    @else
                        @auth
                            @if($product->status === 'tersedia')
                                {{-- Kita arahkan ke rute checkout dan mengirimkan parameter filter via URL --}}
                                <a href="{{ route('booking.checkout', $product->id) }}?tanggal_sewa={{ request('tanggal_sewa', date('Y-m-d', strtotime('+1 day'))) }}&jam_sewa={{ request('jam_sewa', '08:00') }}&durasi={{ request('durasi', 1) }}" 
                                class="k-book-btn">
                                    Booking
                                </a>
                            @else
                                <span class="k-book-btn k-book-btn--disabled" title="Tidak tersedia">Disewa</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="k-book-btn k-book-btn--guest">Login</a>
                        @endauth
                    @endif
                </div>
            </article>
            @endforeach
        </div>
    @endif
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

    @endsection

@push('scripts')
<script>
/**
 * Sinkronkan nilai filter (tanggal, jam, durasi) dari form utama
 * ke hidden fields di setiap form booking sebelum submit.
 */
function syncBookingForm(form) {
    const tanggal = document.getElementById('tanggal_sewa')?.value || '';
    const jam     = document.getElementById('jam_sewa')?.value     || '08:00';
    const durasi  = document.getElementById('durasi')?.value       || '1';

    form.querySelector('.inp-tanggal').value = tanggal;
    form.querySelector('.inp-jam').value     = jam;
    form.querySelector('.inp-durasi').value  = durasi;

    // Validasi dasar: pastikan tanggal dipilih
    if (!tanggal) {
        alert('Silakan pilih tanggal sewa terlebih dahulu.');
        return false;
    }
    return true;
}
</script>
@endpush
