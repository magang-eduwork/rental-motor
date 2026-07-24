<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ED.RENT — Deskripsi Kendaraan</title>
    <style>
        :root {
            color-scheme: light;
            --background: #f5f7fb;
            --card: #ffffff;
            --foreground: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-foreground: #ffffff;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--foreground);
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }
        img { display: block; width: 100%; height: auto; }

        .page { min-height: 100vh; background: #f5f7fb; }
        .header {
            border-bottom: 1px solid var(--border);
            background: var(--card);
        }
        .header-inner, .main, .footer-inner, .footer-bottom {
            margin: 0 auto;
            max-width: 1200px;
            padding: 0 24px;
        }
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            padding-bottom: 16px;
        }
        .brand { font-size: 1.125rem; font-weight: 700; color: var(--primary); letter-spacing: 0.02em; }
        .nav { display: flex; gap: 32px; font-size: 0.95rem; color: var(--foreground); }
        .nav a:hover { color: var(--primary); }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 999px;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .dot { width: 8px; height: 8px; border-radius: 999px; background: #10b981; }
        .btn {
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            background: var(--primary);
            color: var(--primary-foreground);
            font-weight: 600;
            cursor: pointer;
        }
        .btn:hover { opacity: 0.95; }

        .main { padding-top: 32px; padding-bottom: 32px; }
        .detail-card {
            display: grid;
            grid-template-columns: minmax(0, 340px) 1fr;
            gap: 24px;
            padding: 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
        }
        .image-box {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 12px;
            background: #f3f4f6;
            aspect-ratio: 1 / 1;
        }
        .image-box img { object-fit: cover; height: 100%; }
        .detail-list {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 8px 12px;
            font-size: 0.95rem;
            color: var(--muted);
        }
        .detail-list strong { color: var(--foreground); }
        .title-wrap h1 { margin: 0; font-size: 1.75rem; }
        .availability { display: inline-flex; align-items: center; gap: 8px; margin-top: 8px; color: #10b981; font-weight: 600; }
        .desc { margin-top: 12px; color: var(--muted); font-size: 0.95rem; }
        .perlengkapan { margin-top: 24px; }
        .perlengkapan h3 { margin: 0 0 12px; font-size: 1rem; }
        .perk-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 12px;
            margin: 0;
            padding: 0;
            list-style: none;
            color: var(--muted);
            font-size: 0.95rem;
        }
        .perk-list li { display: flex; align-items: center; gap: 8px; }
        .perk-list span { display: inline-block; width: 6px; height: 6px; border-radius: 999px; background: var(--primary); }
        .price-box {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .price { font-size: 1.25rem; font-weight: 700; }
        .price small { color: var(--muted); font-weight: 400; }

        .recommendations { margin-top: 40px; }
        .recommendations h2 { margin: 0; font-size: 1.125rem; }
        .recommendations p { margin: 8px 0 0; color: var(--muted); font-size: 0.95rem; }
        .cards {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .card {
            display: flex;
            flex-direction: column;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--card);
        }
        .card-title { font-size: 0.95rem; font-weight: 700; }
        .card-type { font-size: 0.8rem; color: var(--muted); }
        .card-image { margin: 10px 0; border-radius: 10px; overflow: hidden; background: #f3f4f6; aspect-ratio: 4 / 3; }
        .card-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--muted); margin-bottom: 12px; }
        .card-meta .status { color: #10b981; font-weight: 600; }
        .card-footer { display: flex; justify-content: space-between; align-items: center; }
        .card-price { font-size: 0.95rem; font-weight: 700; }
        .card-price small { color: var(--muted); font-weight: 400; }
        .card-btn { padding: 8px 12px; font-size: 0.8rem; }

        .footer {
            margin-top: 40px;
            border-top: 1px solid var(--border);
            background: var(--card);
        }
        .footer-inner {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 24px;
            padding-top: 40px;
            padding-bottom: 24px;
        }
        .footer h3 { margin: 0 0 12px; font-size: 1rem; }
        .footer p, .footer ul { margin: 0; color: var(--muted); font-size: 0.95rem; }
        .footer ul { padding: 0; list-style: none; }
        .footer li { margin-top: 8px; }
        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 16px;
            padding-bottom: 24px;
            text-align: center;
            color: var(--muted);
            font-size: 0.8rem;
        }

        @media (max-width: 920px) {
            .detail-card { grid-template-columns: 1fr; }
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .footer-inner { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .header-inner { flex-direction: column; gap: 12px; }
            .nav { gap: 16px; }
            .header-actions { width: 100%; justify-content: space-between; }
            .cards { grid-template-columns: 1fr; }
            .perk-list { grid-template-columns: 1fr; }
            .price-box { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>
</head>
<body>
    @php
        $kelengkapan = [
            'Bensin 1 liter',
            'Helm SNI 2 buah',
            'Jas hujan 2 buah',
            'STNK',
            'Tas boncengi 1 buah',
            'Sarung tangan 1 buah',
        ];

        $rekomendasi = [
            ['id' => 1, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9001DE', 'price' => 'Rp75.000'],
            ['id' => 2, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9002DE', 'price' => 'Rp75.000'],
            ['id' => 3, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9003DE', 'price' => 'Rp75.000'],
            ['id' => 4, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9004DE', 'price' => 'Rp75.000'],
            ['id' => 5, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9005DE', 'price' => 'Rp75.000'],
            ['id' => 6, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9006DE', 'price' => 'Rp75.000'],
            ['id' => 7, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9007DE', 'price' => 'Rp75.000'],
            ['id' => 8, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9008DE', 'price' => 'Rp75.000'],
            ['id' => 9, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9009DE', 'price' => 'Rp75.000'],
            ['id' => 10, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9010DE', 'price' => 'Rp75.000'],
            ['id' => 11, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9011DE', 'price' => 'Rp75.000'],
            ['id' => 12, 'name' => 'Vega Force', 'type' => 'Matic', 'plate' => 'AB 9012DE', 'price' => 'Rp75.000'],
        ];
    @endphp

    <div class="page">
        <header class="header">
            <div class="header-inner">
                <div class="brand">ED.RENT</div>
                <nav class="nav">
                    <a href="#">Home</a>
                    <a href="#">Pilih Kendaraan</a>
                    <a href="#">Daftar Pesanan</a>
                </nav>
                <div class="header-actions">
                    <span class="status-pill"><span class="dot"></span> Butuh bantuan?</span>
                    <button class="btn">Masuk</button>
                </div>
            </div>
        </header>

        <main class="main">
            <section class="detail-card">
                <div class="image-column">
                    <div class="image-box">
                        <img src="{{ $product->image_url }}" alt="{{ $product->nama_motor }}">
                    </div>
                    <div class="detail-list" style="margin-top: 16px;">
                        <div>Brand</div>
                        <strong>{{ explode(' ', $product->nama_motor)[0] ?? 'Brand' }}</strong>
                        <div>Tipe</div>
                        <strong>Matic</strong>
                        <div>Kapasitas Tangki</div>
                        <strong>7,0 L</strong>
                        <div>No. Plat</div>
                        <strong>AB 3467 DG</strong>
                    </div>
                </div>

                <div class="vehicle-info">
                    <div class="title-wrap">
                        <h1>{{ $product->nama_motor }}</h1>
                        <div class="availability"><span class="dot"></span> Tersedia</div>
                    </div>

                    <p class="desc">
                        <p class="desc">
                            {{ $product->deskripsi ?? 'Lihat detail kendaraan ini, termasuk fitur, spesifikasi, dan harga sewa per hari.' }}
                        </p>

                    <div class="perlengkapan">
                        <h3>Perlengkapan</h3>
                        <ul class="perk-list">
                            @foreach ($kelengkapan as $item)
                                <li><span></span> {{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="price-box">
                        <strong>Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }} <small>/hari</small></strong>
                        <button class="btn">Booking</button>
                    </div>
                </div>
            </section>

            <section class="recommendations">
                <h2>Rekomendasi Kendaraan</h2>
                <p>Pilih kendaraan yang paling sesuai dengan gaya perjalanan dan budget Anda. Semua motor terawat, siap jalan!</p>

                <div class="cards">
                    @foreach ($rekomendasi as $item)
                        <div class="card">
                            <div class="card-title">{{ $item['name'] }}</div>
                            <div class="card-type">{{ $item['type'] }}</div>
                            <div class="card-image">
                                <img src="src/assets/vega-force.jpg" alt="{{ $item['name'] }}">
                            </div>
                            <div class="card-meta">
                                <span>🛵 {{ $item['plate'] }}</span>
                                <span class="status">● Tersedia</span>
                            </div>
                            <div class="card-footer">
                                <div class="card-price">{{ $item['price'] }} <small>/hari</small></div>
                                @auth
                                    <a href="{{ route('booking.checkout', $product->id) }}?tanggal_sewa={{ request('tanggal_sewa', date('Y-m-d', strtotime('+1 day'))) }}&jam_sewa={{ request('jam_sewa', '08:00') }}&durasi={{ request('durasi', 1) }}" class="btn">Booking</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn">Login untuk booking</a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="footer-inner">
                <div>
                    <div class="brand">ED.RENT</div>
                    <p style="margin-top: 12px; max-width: 320px;">
                        Rental terlengkap, harga transparan, dan nyaman 24 jam. Siap menemani setiap perjalanan Anda.
                    </p>
                </div>
                <div>
                    <h3>About</h3>
                    <ul>
                        <li>Chat Admin</li>
                    </ul>
                </div>
                <div>
                    <h3>Sosial</h3>
                    <ul>
                        <li>Discord</li>
                        <li>Instagram</li>
                        <li>Twitter</li>
                        <li>Facebook</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">©2025 ED.RENT. All rights reserved</div>
        </footer>
    </div>
</body>
</html>
