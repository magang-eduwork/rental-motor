@extends('layouts.app')

@section('title', 'Home')

@push('styles')
    @vite('resources/css/pages/home.css')
@endpush

@section('content')
<section class="hero">
    <img
        src="{{ $heroImage }}"
        alt="Rental motor ED.RENT"
    />
    <div class="container hero-content">
        <div>
            <h1 class="hero-title">
                Rental Motor Cepat & Aman,<br />Mulai Rp75.000/hari
            </h1>
            <p class="hero-copy">
                Pilihan terlengkap, harga transparan, dan layanan 24
                jam. Siap menemani setiap petualangan Anda.
            </p>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                Mulai Petualangan Anda dalam 3 Langkah Mudah
            </h2>
            <p class="section-subtitle">
                Tidak perlu repot! Proses penyewaan motor tercepat,
                paling aman, dan transparan.
            </p>
        </div>

        <div class="grid grid-3">
            <article class="card">
                <div class="card-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect
                            x="4"
                            y="3"
                            width="16"
                            height="18"
                            rx="2"
                        ></rect>
                        <path d="M8 8h8M8 12h8M8 16h5"></path>
                    </svg>
                </div>
                <h3 class="card-title">Pilih & Booking</h3>
                <p class="card-text">
                    Pilih motor impian Anda dan tentukan tanggal
                    rental.
                </p>
            </article>

            <article class="card">
                <div class="card-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect
                            x="4"
                            y="3"
                            width="16"
                            height="18"
                            rx="2"
                        ></rect>
                        <path d="M8 8h8M8 12h8M8 16h5"></path>
                    </svg>
                </div>
                <h3 class="card-title">Konfirmasi & Pembayaran</h3>
                <p class="card-text">
                    Selesaikan pembayaran dan dapatkan konfirmasi
                    instan via email/WhatsApp.
                </p>
            </article>

            <article class="card">
                <div class="card-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect
                            x="4"
                            y="3"
                            width="16"
                            height="18"
                            rx="2"
                        ></rect>
                        <path d="M8 8h8M8 12h8M8 16h5"></path>
                    </svg>
                </div>
                <h3 class="card-title">Ambil / Diantar</h3>
                <p class="card-text">
                    Ambil motor di lokasi kami, atau konfirmasi melalui
                    whatsapp untuk diantar ke lokasi Anda.
                </p>
            </article>
        </div>
    </div>
</section>

<section id="motors">
    <div class="container">
        <div class="section-header section-header--motors">
            <h2 class="section-title">Pilihan Motor Terpopuler</h2>
            <a href="{{ route('kendaraan') }}" class="section-link">Lihat semua</a>
        </div>
        <p class="section-subtitle">
            Pilih kendaraan yang paling sesuai dengan gaya
            perjalanan dan budget Anda. Semua motor terawat, siap
            jalan!
        </p>

        <div class="grid grid-4 motors-grid">
            @foreach($products as $product)
            <article class="motor-card">
                <div class="motor-meta">
                    <p class="motor-name">{{ $product->nama_motor }}</p>
                    <p class="motor-type">{{ $product->tipe }}</p>
                </div>
                <div class="motor-image">
                    <img
                        src="{{ $product->image_url }}"
                        alt="{{ $product->nama_motor }}"
                    />
                </div>
                <div class="motor-info">
                    <span>{{ $product->plat_nomor }}</span>

                    @if($product->status === 'tersedia')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-600">
                            ● Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-600">
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
                <div class="motor-price">
                    <div>
                        <strong>Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }}</strong>
                        <span class="price-unit">/ hari</span>
                    </div>
                    @auth
                        <a href="{{ route('kendaraan') }}" class="book-button" style="display: inline-block; text-align: center; text-decoration: none;">
                            Booking
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="book-button" style="display: inline-block; text-align: center; text-decoration: none;">
                            Booking
                        </a>
                    @endauth
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                Syarat & Ketentuan Rental Motor
            </h2>
            <p class="section-subtitle">
                Transparansi adalah kunci. Pastikan Anda memenuhi
                beberapa persyaratan dasar sebelum melakukan
                pemesanan.
            </p>
        </div>

        <ol class="terms">
            <li>
                Lakukan pemesanan minimal
                <strong>1×24 jam</strong> sebelum waktu penggunaan.
                Setelah pesanan dikonfirmasi, penyewa wajib
                melakukan konfirmasi pengambilan motor melalui nomor
                whatsapp atau datang ke lokasi ED.RENT.
            </li>
            <li>
                Membawa <strong>2 kartu identitas</strong> (SIM A,
                KK, KTP, ID Kerja atau ID Pelajar)
            </li>
            <li>
                Menyertakan akun sosial media dan
                <strong>nomor whatsapp</strong> yang aktif.
            </li>
            <li>
                Pada saat serah terima kendaraan, pihak penyedia
                rental akan melakukan
                <strong>pengecekan keaslian data</strong> dan
                kondisi kendaraan.
            </li>
            <li>
                Pihak penyedia rental
                <strong>berhak membatalkan</strong> apabila data
                tidak sesuai dan syarat sewa tidak dapat dilengkapi.
            </li>
            <li>
                Apabila pembayaran telah selesai dan kendaraan yang
                dipesan tidak tersedia, penyewa
                <strong>berhak memilih kendaraan lain</strong> yang
                tersedia tanpa dikenakan biaya tambahan.
            </li>
        </ol>
    </div>
</section>
@endsection
