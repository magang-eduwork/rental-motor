@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Daftar Pesanan</h1>

    <!-- ================= BAGIAN BAR FILTER ================= -->
    <form action="{{ route('admin.pesanan.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-wrap gap-4 items-end mb-6">
        <!-- Filter Status -->
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Status</label>
            <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500">
                <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                <option value="Sedang dibawa" {{ request('status') == 'Sedang dibawa' ? 'selected' : '' }}>Sedang dibawa</option>
                <option value="Sudah kembali" {{ request('status') == 'Sudah kembali' ? 'selected' : '' }}>Sudah kembali</option>
            </select>
        </div>

        <!-- Filter Tipe Kendaraan -->
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Tipe Kendaraan</label>
            <select name="tipe_kendaraan" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500">
                <option value="Semua">Semua</option>
                @foreach($motorOptions as $motor)
                    <option value="{{ $motor }}" {{ request('tipe_kendaraan') == $motor ? 'selected' : '' }}>{{ $motor }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filter Tanggal Booking -->
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Tanggal Booking</label>
            <input type="date" name="tanggal_booking" value="{{ request('tanggal_booking') }}" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500">
        </div>

        <!-- Cari Kendaraan -->
        <div class="flex-1 min-w-[220px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Cari Kendaraan / Kode</label>
            <div class="relative">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama motor atau kode booking..." class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </div>
        
        @if(request()->anyFilled(['status', 'tipe_kendaraan', 'tanggal_booking', 'cari']))
            <div>
                <a href="{{ route('admin.pesanan.index') }}" class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-3 text-sm font-semibold rounded-xl transition-all">Clear</a>
            </div>
        @endif
    </form>

    <!-- ================= DAFTAR KARTU PESANAN (CARDS) ================= -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-6 hover:shadow-md transition-all">
                
                <!-- Motor & Nama Info -->
                <div class="flex items-center gap-4 min-w-[220px]">
                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-100 bg-gray-50 flex-shrink-0">
                        <img src="{{ $order->product?->image_url ? asset($order->product->image_url) : 'https://i.ibb.co.com/VYfhgqm4/image-44.png' }}" alt="{{ $order->nama_motor }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Kendaraan Rental</span>
                        <h3 class="font-bold text-gray-800 text-base">{{ $order->nama_motor }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Pemesan: <span class="font-medium text-gray-700">{{ $order->nama_pemesan ?? 'User' }}</span></p>
                    </div>
                </div>

                <!-- Kode Booking -->
                <div>
                    <span class="text-xs text-gray-400 font-medium block mb-1">Kode Booking</span>
                    <span class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">{{ $order->kode_booking }}</span>
                </div>

                <!-- Tanggal Booking -->
                <div>
                    <span class="text-xs text-gray-400 font-medium block mb-1">Tanggal Booking</span>
                    <span class="text-sm font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($order->tanggal_booking)->translatedFormat('d M Y') }}
                    </span>
                </div>

                <!-- Status Pembayaran & Kendaraan -->
                <div class="flex items-center gap-4">
                    <!-- Pembayaran -->
                    <div>
                        <span class="text-xs text-gray-400 font-medium block mb-1">Status Pembayaran</span>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                            @switch($order->payment?->status_pembayaran)
                                @case('success') bg-green-100 text-green-700 @break
                                @case('pending') bg-yellow-100 text-yellow-700 @break
                                @case('failed') bg-red-100 text-red-700 @break
                                @default bg-gray-100 text-gray-700
                            @endswitch">
                            {{ $order->payment?->status_pembayaran ?? 'Belum Bayar' }}
                        </span>
                    </div>

                    <!-- Kendaraan -->
                    <div>
                        <span class="text-xs text-gray-400 font-medium block mb-1">Status Kendaraan</span>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <!-- Harga -->
                <div>
                    <span class="text-xs text-gray-400 font-medium block mb-1">Harga</span>
                    <span class="font-bold text-gray-900 text-base">Rp{{ number_format($order->harga, 0, ',', '.') }}</span>
                </div>

                <!-- Tombol Aksi Update -->
                <div>
                    <button type="button" 
                            onclick='openUpdateModal(@json($order))'
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-all shadow-sm cursor-pointer">
                        Update
                    </button>
                </div>

            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-2xl border border-gray-100 shadow-sm text-gray-400">
                <i class="fa-solid fa-folder-open text-4xl mb-3"></i>
                <p class="text-sm">Tidak ada data pesanan yang sesuai dengan filter pencarian.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>

<!-- ================= MODAL POPUP UPDATE STATUS & WAKTU SEWA ================= -->
<div id="statusModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-8 shadow-2xl transform scale-95 transition-transform duration-300 relative max-h-[90vh] overflow-y-auto">
        
        <!-- Tombol Close (X) -->
        <button type="button" onclick="closeUpdateModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-lg cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-2xl font-bold text-gray-900 mb-6">Update Pemesanan</h3>
        
        <!-- Informasi Detail Pesanan di Dalam Modal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-2xl mb-6 border border-gray-100 items-center">
            <div class="flex items-center gap-4">
                <!-- Kotak Gambar Kendaraan Di dalam Modal -->
                <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-200 bg-white flex-shrink-0">
                    <img id="modalGambarMotor" src="" alt="Motor" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 id="modalNamaMotor" class="font-bold text-gray-800 text-base"></h4>
                    <!-- Tipe kendaraan dinamis tersinkronisasi database -->
                    <span id="modalTipeKendaraan" class="text-xs text-blue-600 font-medium"></span>
                </div>
            </div>
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between border-b border-gray-200/60 pb-1"><span class="text-gray-400">Nama</span><span id="modalNamaPemesan" class="font-semibold text-gray-800"></span></div>
                <div class="flex justify-between border-b border-gray-200/60 pb-1"><span class="text-gray-400">No. WhatsApp</span><span id="modalNoWa" class="font-semibold text-gray-800"></span></div>
                <div class="flex justify-between border-b border-gray-200/60 pb-1"><span class="text-gray-400">Kode booking</span><span id="modalBookingCode" class="font-mono font-bold text-blue-600"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Tanggal booking</span><span id="modalTglBooking" class="font-semibold text-gray-800"></span></div>
            </div>
        </div>
        
        <form id="updateStatusForm" onsubmit="submitStatusForm(event)">
            @csrf
            @method('PATCH')
            <input type="hidden" id="modalOrderId" name="order_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Tanggal & Jam Sewa -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Tanggal & Waktu Sewa</label>
                    <input type="datetime-local" id="modalTanggalSewa" name="tanggal_sewa" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 font-medium">
                </div>

                <!-- Tanggal & Jam Selesai -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Tanggal & Waktu Selesai</label>
                    <input type="datetime-local" id="modalTanggalSelesai" name="tanggal_selesai" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 font-medium">
                </div>
            </div>

            <!-- Status Pesanan -->
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Status Pesanan</label>
                <select id="modalStatusSelect" name="status" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 font-semibold">
                    <option value="Pending">Pending</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Sedang dibawa">Sedang dibawa</option>
                    <option value="Sudah kembali">Sudah kembali</option>
                    <option value="Batal">Batal</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeUpdateModal()" class="px-6 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-gray-500 hover:bg-gray-50 transition-all cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-md cursor-pointer">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
    const modal = document.getElementById('statusModal');
    const modalContent = modal.querySelector('.transform');

    function formatDateTimeLocal(dateString) {
        if (!dateString) return '';
        // KOREKSI: Mengambil string secara presisi dari database tanpa konversi zona waktu browser
        return dateString.substring(0, 16).replace(' ', 'T');
    }

    function openUpdateModal(order) {
        document.getElementById('modalOrderId').value = order.id;
        document.getElementById('modalNamaMotor').innerText = order.nama_motor;
        document.getElementById('modalNamaPemesan').innerText = order.nama_pemesan ?? 'User';
        document.getElementById('modalNoWa').innerText = order.no_wa ?? '-';
        document.getElementById('modalBookingCode').innerText = order.kode_booking;
        document.getElementById('modalTglBooking').innerText = order.tanggal_booking ? new Date(order.tanggal_booking).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-';
        
        // Sinkronisasi Tipe Kendaraan dari Database melalui relasi product
        const tipeElement = document.getElementById('modalTipeKendaraan');
        if (order.product && order.product.tipe) {
            tipeElement.innerText = order.product.tipe;
        } else {
            tipeElement.innerText = '-';
        }

        // Sinkronisasi Gambar Kendaraan pada Modal
        const imgElement = document.getElementById('modalGambarMotor');
        if (order.product && order.product.image_url) {
            let imageUrl = order.product.image_url;
            imgElement.src = imageUrl.startsWith('http') ? imageUrl : '/' + imageUrl;
        } else {
            imgElement.src = 'https://i.ibb.co.com/VYfhgqm4/image-44.png';
        }

        // Masukkan nilai tanggal sewa dan selesai ke form input datetime-local secara presisi
        document.getElementById('modalTanggalSewa').value = formatDateTimeLocal(order.tanggal_sewa);
        document.getElementById('modalTanggalSelesai').value = formatDateTimeLocal(order.tanggal_selesai);
        
        document.getElementById('modalStatusSelect').value = order.status;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 20);
    }

    function closeUpdateModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function submitStatusForm(e) {
        e.preventDefault();
        const id = document.getElementById('modalOrderId').value;
        const statusValue = document.getElementById('modalStatusSelect').value;
        const tanggalSewa = document.getElementById('modalTanggalSewa').value;
        const tanggalSelesai = document.getElementById('modalTanggalSelesai').value;
        const url = `{{ url('/admin/pesanan') }}/${id}/update-status`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PATCH',
                status: statusValue,
                tanggal_sewa: tanggalSewa,
                tanggal_selesai: tanggalSelesai
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                closeUpdateModal();
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan sistem.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghubungkan ke database server.');
        });
    }
</script>
@endsection