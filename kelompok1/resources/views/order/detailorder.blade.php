<div x-show="open" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" 
     style="display: none;"
     x-cloak>
    
    <div @click.away="open = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-2xl">
        
        <!-- Header Modal -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Detail Pemesanan</h2>
            <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 text-3xl font-bold leading-none cursor-pointer">&times;</button>
        </div>
        
        <!-- Informasi Utama & Gambar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <p class="font-bold text-lg" x-text="selectedOrder ? selectedOrder.nama_motor : 'Memuat...'"></p>
                <img :src="selectedOrder && selectedOrder.product && selectedOrder.product.image_url ? 
                           (selectedOrder.product.image_url.startsWith('http') ? selectedOrder.product.image_url : '/' + selectedOrder.product.image_url) : 
                           'https://i.ibb.co.com/VYfhgqm4/image-44.png'" 
                     alt="Motor" 
                     class="w-full mt-4 rounded-2xl bg-gray-50 object-cover h-48">
            </div>

            <div class="space-y-4">
                <h3 class="font-bold text-gray-700">Informasi Pemesanan</h3>
                <div class="grid grid-cols-2 gap-y-3 text-sm items-center">
                    <p class="text-gray-500">Nama</p> 
                    <p class="font-semibold" x-text="selectedOrder?.nama_pemesan"></p>
                    
                    <p class="text-gray-500">No. WhatsApp</p> 
                    <p class="font-semibold" x-text="selectedOrder?.no_wa"></p>
                    
                    <p class="text-gray-500">Kode Booking</p> 
                    <p class="font-semibold font-mono text-blue-600" x-text="selectedOrder?.kode_booking"></p>
                    
                    <p class="text-gray-500">Tanggal Booking</p> 
                    <div>
                        <p class="font-semibold text-gray-800" 
                        x-text="selectedOrder?.tanggal_booking ? new Date(selectedOrder.tanggal_booking).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-'"></p>
                        <p class="text-xs font-medium text-gray-400" 
                        x-text="selectedOrder?.tanggal_booking ? new Date(selectedOrder.tanggal_booking).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) + ' WIB' : ''"></p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-100">

        <!-- Bagian Waktu Sewa (Tanggal & Waktu Dipisah) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            
            <!-- Mulai Sewa -->
            <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Mulai Sewa</p>
                <p class="font-bold text-sm text-gray-800" 
                   x-text="selectedOrder?.tanggal_sewa ? new Date(selectedOrder.tanggal_sewa).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-'"></p>
                <p class="text-xs font-semibold text-blue-600 mt-1 inline-block bg-blue-50 px-2 py-0.5 rounded-md" 
                   x-text="selectedOrder?.tanggal_sewa ? new Date(selectedOrder.tanggal_sewa).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) + ' WIB' : ''"></p>
            </div>

            <!-- Selesai Sewa -->
            <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Selesai Sewa</p>
                <p class="font-bold text-sm text-gray-800" 
                   x-text="selectedOrder?.tanggal_selesai ? new Date(selectedOrder.tanggal_selesai).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-'"></p>
                <p class="text-xs font-semibold text-blue-600 mt-1 inline-block bg-blue-50 px-2 py-0.5 rounded-md" 
                   x-text="selectedOrder?.tanggal_selesai ? new Date(selectedOrder.tanggal_selesai).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) + ' WIB' : ''"></p>
            </div>

            <!-- Status Pesanan -->
            <div class="flex flex-col justify-center items-start md:items-center bg-gray-50 p-3.5 rounded-2xl border border-gray-100 h-full">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Status</p>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-600" 
                      x-text="selectedOrder?.status"></span>
            </div>

        </div>
    </div>
</div>