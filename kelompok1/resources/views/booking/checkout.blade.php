<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-8">Detail Pemesanan</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- KOLOM KIRI: Detail Pemesanan & Syarat Ketentuan --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Pemesanan --}}
                <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
                    <h2 class="font-bold text-xl mb-6">Pemesanan</h2>
                    <div class="space-y-4">
                        <div class="flex"><span class="w-40 text-gray-500">Nama</span> <span>: <strong>{{ auth()->user()->name }}</strong></span></div>
                        <div class="flex"><span class="w-40 text-gray-500">No. whatsapp</span> <span>: <strong>{{ auth()->user()->whatsapp ?? '-' }}</strong></span></div>
                        <div class="flex"><span class="w-40 text-gray-500">No. KTP</span> <span>: <strong>{{ auth()->user()->ktp ?? '-' }}</strong></span></div>
                        <div class="flex"><span class="w-40 text-gray-500">No. SIM</span> <span>: <strong>{{ auth()->user()->sim ?? '-' }}</strong></span></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-6">Kamu bisa mengubah email lewat profilmu di menu Akun.</p>
                </div>

                {{-- Card Syarat & Ketentuan (Sudah dirapikan di sini) --}}
                <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Syarat & Ketentuan Rental Motor</h2>
                    <p class="text-sm text-gray-500 mb-6">
                        Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum melakukan pemesanan.
                    </p>
                    
                    <ul class="space-y-4 text-sm text-gray-700">
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">1</span>
                            <p>Lakukan pemesanan minimal <strong class="font-semibold text-gray-900">1×24 jam</strong> sebelum waktu penggunaan. Setelah pesanan dikonfirmasi, penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor whatsapp atau datang ke lokasi ED.RENT.</p>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">2</span>
                            <p>Membawa <strong class="font-semibold text-gray-900">2 kartu identitas</strong> (SIM A, KK, KTP, ID Kerja atau ID Pelajar).</p>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">3</span>
                            <p>Menyertakan akun sosial media dan <strong class="font-semibold text-gray-900">nomor whatsapp</strong> yang aktif.</p>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">4</span>
                            <p>Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan <strong class="font-semibold text-gray-900">pengecekan keaslian data</strong> dan kondisi kendaraan.</p>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">5</span>
                            <p>Pihak penyedia rental <strong class="font-semibold text-gray-900">berhak membatalkan</strong> apabila data tidak sesuai dan syarat sewa tidak dapat dilengkapi.</p>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs flex items-center justify-center mt-0.5">6</span>
                            <p>Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia, penyewa <strong class="font-semibold text-gray-900">berhak memilih kendaraan lain</strong> yang tersedia tanpa dikenakan biaya tambahan.</p>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- KOLOM KANAN: Detail Waktu, Kendaraan, & Ringkasan Transaksi --}}
            <div class="space-y-6">
                {{-- Detail Waktu & Unit Motor --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-medium text-gray-700">Durasi sewa : {{ request('durasi', 1) }} hari</span>
                        <button
                            type="button"
                            onclick="openEditModal()"
                            class="text-blue-600 text-sm hover:underline flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-2.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Tanggal sewa</p>
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse(request('tanggal_sewa'))->format('D, d M Y') }}</p>
                            <p class="text-gray-500 text-xs mt-0.5">{{ \Carbon\Carbon::parse(request('jam_sewa'))->format('H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Selesai sewa</p>
                            <p class="font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse(request('tanggal_sewa'))->addDays((int) request('durasi', 1))->format('D, d M Y') }}
                            </p>
                            <p class="text-gray-500 text-xs mt-0.5">{{ \Carbon\Carbon::parse(request('jam_sewa'))->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-xl">
                       <img src="{{ $product->image_url }}" alt="{{ $product->nama_motor }}" class="w-16 h-16 object-contain rounded-lg bg-white border border-gray-100">
                        <div>
                            <p class="font-bold text-gray-800">{{ $product->nama_motor }}</p>
                            <p class="text-xs text-gray-400 font-medium">{{ $product->tipe }}</p>
                            <span class="inline-block bg-gray-200 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded mt-1">
                                {{ $product->plat_nomor }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Transaksi --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h2 class="font-bold text-gray-800 mb-4">Ringkasan transaksi</h2>
                    <div class="space-y-3 text-sm mb-4">
                        <div class="flex justify-between text-gray-600"><span>Harga</span> <span>Rp{{ number_format($product->harga_per_hari, 0, ',', '.') }} / hari</span></div>
                        <div class="flex justify-between text-gray-600"><span>Diskon</span> <span>-</span></div>
                    </div>
                    <div class="flex justify-between font-bold text-base border-t border-gray-100 pt-4 text-gray-900">
                        <span>Total harga</span> 
                        <span>Rp{{ number_format($product->harga_per_hari * (int) request('durasi', 1), 0, ',', '.') }}</span>
                    </div>
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="tanggal_sewa" value="{{ request('tanggal_sewa') }}">
                        <input type="hidden" name="jam_sewa" value="{{ request('jam_sewa') }}">
                        <input type="hidden" name="durasi" value="{{ request('durasi', 1) }}">
                        <input type="hidden" name="no_ktp" value="{{ auth()->user()->ktp }}">
                        <input type="hidden" name="no_sim" value="{{ auth()->user()->sim }}">
                        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-xl mt-6 hover:bg-blue-700 transition duration-200 shadow-sm shadow-blue-200">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
            </div>
        </div>

    {{-- Modal Edit Jadwal --}}
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 transition-opacity duration-200">
    <div id="modalCard" class="bg-white rounded-2xl p-8 w-full max-w-md scale-95 opacity-0 transition-all duration-200">

        <h2 class="text-xl font-bold mb-6">
            Edit Jadwal Sewa
        </h2>

        <form id="editForm">

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">
                    Tanggal Sewa
                </label>

                <input
                    type="date"
                    name="tanggal_sewa"
                    value="{{ request('tanggal_sewa') }}"
                    class="w-full border rounded-lg p-3">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">
                    Jam Sewa
                </label>

                <input
                    type="time"
                    name="jam_sewa"
                    value="{{ request('jam_sewa') }}"
                    class="w-full border rounded-lg p-3">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">
                    Durasi
                </label>

                <<select id="durasi" name="durasi" class="w-full border rounded-lg p-3">
                    @for($i=1;$i<=14;$i++)
                        <option
                            value="{{ $i }}"
                            {{ request('durasi',1)==$i ? 'selected' : '' }}>
                            {{ $i }} Hari
                        </option>
                    @endfor

                </select>
                <div class="bg-gray-50 rounded-xl p-4 mt-5">

                <div class="flex justify-between items-center">

                    <span class="text-gray-600">
                        Estimasi Total
                    </span>

                    <span
                        id="previewTotal"
                        class="text-xl font-bold text-blue-600">

                        Rp{{ number_format($product->harga_per_hari * (int) request('durasi',1),0,',','.') }}

                    </span>

                </div>

            </div>
            </div>

            <div class="flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-5 py-2 rounded-lg border">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>


<script>

    function openEditModal(){

        const modal = document.getElementById('editModal');
        const card = document.getElementById('modalCard');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            card.classList.remove('scale-95','opacity-0');
            card.classList.add('scale-100','opacity-100');
        },10);

    }

    function closeEditModal(){

        const modal = document.getElementById('editModal');
        const card = document.getElementById('modalCard');

        card.classList.remove('scale-100','opacity-100');
        card.classList.add('scale-95','opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        },200);

    }
    document
    .getElementById('editForm')
    .addEventListener('submit', function(e){

        e.preventDefault();

        let data = new FormData(this);

        let url =
            "{{ route('booking.checkout',$product) }}"
            + "?tanggal_sewa=" + data.get('tanggal_sewa')
            + "&jam_sewa=" + data.get('jam_sewa')
            + "&durasi=" + data.get('durasi');

        window.location.href = url;

    });

    const hargaPerHari = {{ $product->harga_per_hari }};

    const durasi = document.getElementById('durasi');

    const preview = document.getElementById('previewTotal');

    durasi.addEventListener('change', function(){

        let total = hargaPerHari * parseInt(this.value);

        preview.innerHTML =
            "Rp" + total.toLocaleString('id-ID');

    });
</script>

</x-app-layout>