@extends('admin.layouts.app')

@section('title', 'Daftar Kendaraan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-between items-center mb-2">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kendaraan</h1>
            <p class="text-sm text-gray-500 mt-1">Pilih kendaraan yang paling sesuai dengan gaya perjalanan dan budget Anda. Semua motor terawat, siap jalan!</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-plus"></i> <span>Tambah Kendaraan</span>
        </button>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('admin.kendaraan.index') }}" method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-wrap gap-4 items-end mb-6">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">TIPE KENDARAAN</label>
            <select name="tipe" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none">
                <option value="Semua">Semua</option>
                @foreach($tipes as $tipe)
                    <option value="{{ $tipe }}" {{ request('tipe') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">STATUS</label>
            <select name="status" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none">
                <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa / Tidak Tersedia</option>
            </select>
        </div>

        <div class="flex-1 min-w-[220px]">
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">CARI KENDARAAN</label>
            <div class="relative flex items-center">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama motor atau plat..." class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3 text-sm focus:outline-none pr-10">
                <button type="submit" class="absolute right-3 text-gray-400 hover:text-blue-600">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Grid Kartu Kendaraan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                <div>
                    <!-- Header Kartu -->
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $product->nama_motor }}
                            </h3>

                            <span class="text-xs text-gray-400 font-medium">
                                {{ $product->tipe }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-2 items-end">

                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ strtolower($product->status) == 'tersedia'
                                    ? 'bg-emerald-50 text-emerald-600'
                                    : 'bg-red-50 text-red-600' }}">
                                {{ strtolower($product->status) == 'tersedia'
                                    ? '● Tersedia'
                                    : '● Tidak Tersedia' }}
                            </span>

                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $product->fl_aktif == 'Y'
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->fl_aktif == 'Y'
                                    ? '● Aktif'
                                    : '● Tidak Aktif' }}
                            </span>

                        </div>
                    </div>

                    <!-- Gambar Motor (Proporsional & Rapi) -->
                    <div class="w-full h-32 rounded-xl overflow-hidden bg-gray-50 my-3 flex items-center justify-center p-2 border border-gray-50">
                        <img src="{{ str_starts_with($product->image_url ?? '', 'http') ? $product->image_url : asset($product->image_url ?? 'images/default.png') }}" alt="{{ $product->nama_motor }}" class="max-h-full max-w-full object-contain">
                    </div>

                    <!-- Plat Nomor -->
                    <p class="text-xs text-gray-400 mb-4 flex items-center gap-1.5">
                        <i class="fa-regular fa-id-card"></i> {{ $product->plat_nomor }}
                    </p>
                </div>

                <!-- Bagian Harga & Tombol Aksi -->
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <div>
                        <span class="font-bold text-gray-900 text-sm">Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-gray-400">/hari</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick='openEditModal(@json($product))' class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer">
                            Detail / Edit
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 bg-white p-12 text-center rounded-2xl border border-gray-100 shadow-sm text-gray-400">
                <i class="fa-solid fa-motorcycle text-4xl mb-3 text-gray-300"></i>
                <p class="text-sm">Tidak ada data kendaraan yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>

<!-- MODAL TAMBAH / EDIT KENDARAAN -->
<div id="kendaraanModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl max-w-lg w-full p-8 shadow-2xl transform scale-95 transition-transform duration-300 relative">
        <button type="button" onclick="closeModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 cursor-pointer">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <h3 id="modalTitle" class="text-2xl font-bold text-gray-900 mb-6">Tambah Kendaraan</h3>
        
        <form id="kendaraanForm" onsubmit="submitForm(event)">
            @csrf
            <input type="hidden" id="productId" name="product_id">

            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Gambar Kendaraan</label>
                    <input type="file" name="image" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Kendaraan</label>
                    <input type="text" name="nama_motor" id="modalNama" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Tipe Kendaraan
                    </label>

                    <select
                        name="tipe"
                        id="modalTipe"
                        required
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="" selected disabled>Pilih Tipe Kendaraan</option>
                        <option value="Matic">Matic</option>
                        <option value="Motor Bebek">Motor Bebek</option>
                        <option value="Sport">Sport</option>
                        <option value="Trail">Trail</option>
                        <option value="Listrik">Listrik</option>
                        

                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">No. Plat</label>
                    <input type="text" name="plat_nomor" id="modalPlat" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Harga Per Hari (Rp)</label>
                    <input type="number" name="harga_per_hari" id="modalHarga" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Status Kendaraan
                    </label>

                    <select
                        name="fl_aktif"
                        id="modalAktif"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none">

                        <option value="Y">Aktif</option>
                        <option value="N">Tidak Aktif</option>

                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <button type="button" id="deleteBtn" onclick="deleteData()" class="hidden px-5 py-2.5 rounded-xl border border-red-200 text-sm font-semibold text-red-600 hover:bg-red-50 cursor-pointer">Hapus</button>
                <div class="flex items-center gap-3 ml-auto">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-500 hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md cursor-pointer">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('kendaraanModal');
    const modalContent = modal.querySelector('.transform');

    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Kendaraan';
        document.getElementById('kendaraanForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('deleteBtn').classList.add('hidden');
        modal.classList.remove('hidden');
        setTimeout(() => { modal.classList.remove('opacity-0'); modalContent.classList.remove('scale-95'); modalContent.classList.add('scale-100'); }, 20);
    }

    function openEditModal(product) {
        document.getElementById('modalTitle').innerText = 'Edit Kendaraan';
        document.getElementById('productId').value = product.id;
        document.getElementById('modalNama').value = product.nama_motor;
        document.getElementById('modalTipe').value = product.tipe;
        document.getElementById('modalPlat').value = product.plat_nomor;
        document.getElementById('modalHarga').value = product.harga_per_hari;
        document.getElementById('deleteBtn').classList.remove('hidden');
        document.getElementById('modalAktif').value = product.fl_aktif;
        modal.classList.remove('hidden');
        setTimeout(() => { modal.classList.remove('opacity-0'); modalContent.classList.remove('scale-95'); modalContent.classList.add('scale-100'); }, 20);
    }

    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }

    function submitForm(e) {
        e.preventDefault();
        const id = document.getElementById('productId').value;
        const isEdit = id !== '';
        const url = isEdit ? `/admin/kendaraan/${id}` : `{{ route('admin.kendaraan.store') }}`;
        
        const formData = new FormData(document.getElementById('kendaraanForm'));
        if (isEdit) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { closeModal(); window.location.reload(); }
            else { alert(data.message || 'Terjadi kesalahan.'); }
        });
    }

    function deleteData() {
        if(!confirm('Yakin ingin menghapus kendaraan ini?')) return;
        const id = document.getElementById('productId').value;

        fetch(`/admin/kendaraan/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { closeModal(); window.location.reload(); }
        });
    }
</script>
@endsection