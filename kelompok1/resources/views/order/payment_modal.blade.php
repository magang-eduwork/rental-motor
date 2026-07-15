<div x-show="paymentOpen" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" 
     style="display: none;"
     x-cloak>
    
    <div @click.away="paymentOpen = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-lg border border-gray-100">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Pilih Cara Pembayaran</h2>
            <button type="button" @click="paymentOpen = false" class="text-gray-400 hover:text-gray-600 text-3xl font-bold leading-none">&times;</button>
        </div>
        
        <!-- Detail Pesanan Singkat -->
        <div class="bg-gray-50 p-5 rounded-2xl mb-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Ringkasan Pesanan</h3>
            <div class="flex justify-between items-center mb-1">
                <span class="text-sm text-gray-500">Motor</span>
                <span class="text-sm font-semibold text-gray-900" x-text="selectedOrderForPayment?.nama_motor"></span>
            </div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-sm text-gray-500">Kode Booking</span>
                <span class="text-sm font-mono font-semibold text-indigo-600" x-text="selectedOrderForPayment?.kode_booking"></span>
            </div>
            <div class="border-t border-gray-200 my-2"></div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-bold text-gray-900">Total Tagihan</span>
                <span class="text-base font-bold text-gray-900">
                    Rp<span x-text="selectedOrderForPayment ? Number(selectedOrderForPayment.harga).toLocaleString('id-ID') : '0'"></span>
                </span>
            </div>
        </div>

        <!-- Pilihan Metode Pembayaran -->
        <div class="space-y-4">
            <h4 class="text-sm font-bold text-gray-800">Metode Pembayaran</h4>
            
            <div class="grid grid-cols-1 gap-3">
                <!-- Transfer Bank -->
                <button type="button" 
                        @click="selectedPaymentMethod = 'Transfer'"
                        :class="selectedPaymentMethod === 'Transfer' ? 'border-indigo-600 bg-indigo-50/40 text-indigo-900 shadow-sm' : 'border-gray-200 hover:border-gray-300 text-gray-700 bg-white'"
                        class="flex items-center justify-between p-4 rounded-2xl border-2 transition text-left focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 rounded-xl bg-blue-50 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </span>
                        <div>
                            <p class="font-bold text-sm">Transfer Bank</p>
                            <p class="text-xs text-gray-400">Transfer manual / Virtual Account</p>
                        </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border flex items-center justify-center" 
                         :class="selectedPaymentMethod === 'Transfer' ? 'border-indigo-600 bg-indigo-600' : 'border-gray-300'">
                        <div class="w-2 h-2 rounded-full bg-white" x-show="selectedPaymentMethod === 'Transfer'"></div>
                    </div>
                </button>

                <!-- QRIS -->
                <button type="button" 
                        @click="selectedPaymentMethod = 'QRIS'"
                        :class="selectedPaymentMethod === 'QRIS' ? 'border-indigo-600 bg-indigo-50/40 text-indigo-900 shadow-sm' : 'border-gray-200 hover:border-gray-300 text-gray-700 bg-white'"
                        class="flex items-center justify-between p-4 rounded-2xl border-2 transition text-left focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </span>
                        <div>
                            <p class="font-bold text-sm">QRIS</p>
                            <p class="text-xs text-gray-400">Bayar dengan GoPay, OVO, ShopeePay, dll</p>
                        </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border flex items-center justify-center" 
                         :class="selectedPaymentMethod === 'QRIS' ? 'border-indigo-600 bg-indigo-600' : 'border-gray-300'">
                        <div class="w-2 h-2 rounded-full bg-white" x-show="selectedPaymentMethod === 'QRIS'"></div>
                    </div>
                </button>

                <!-- Tunai -->
                <button type="button" 
                        @click="selectedPaymentMethod = 'Tunai'"
                        :class="selectedPaymentMethod === 'Tunai' ? 'border-indigo-600 bg-indigo-50/40 text-indigo-900 shadow-sm' : 'border-gray-200 hover:border-gray-300 text-gray-700 bg-white'"
                        class="flex items-center justify-between p-4 rounded-2xl border-2 transition text-left focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 rounded-xl bg-green-50 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </span>
                        <div>
                            <p class="font-bold text-sm">Tunai (Bayar di Tempat)</p>
                            <p class="text-xs text-gray-400">Bayar langsung secara tunai saat ambil motor</p>
                        </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border flex items-center justify-center" 
                         :class="selectedPaymentMethod === 'Tunai' ? 'border-indigo-600 bg-indigo-600' : 'border-gray-300'">
                        <div class="w-2 h-2 rounded-full bg-white" x-show="selectedPaymentMethod === 'Tunai'"></div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Form Submit -->
        <form :action="'/daftar-pesanan/' + selectedOrderForPayment?.id + '/pay'" method="POST" class="mt-8">
            @csrf
            <input type="hidden" name="metode_pembayaran" :value="selectedPaymentMethod">
            
            <div class="flex gap-3">
                <button type="button" 
                        @click="paymentOpen = false" 
                        class="flex-1 border border-gray-200 text-gray-700 py-3 rounded-2xl font-bold hover:bg-gray-50 transition cursor-pointer text-center">
                    Batal
                </button>
                <button type="submit" 
                        :disabled="!selectedPaymentMethod"
                        :class="selectedPaymentMethod ? 'bg-indigo-600 hover:bg-indigo-700 text-white cursor-pointer shadow-indigo-100 shadow-lg' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
                        class="flex-1 py-3 rounded-2xl font-bold transition text-center">
                    Bayar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
