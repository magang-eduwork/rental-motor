<aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col justify-between p-4 h-full">
    <div class="flex flex-col">

        <!-- Logo / Brand di Sidebar -->
        <div class="px-2 mb-6">
            <span class="text-xl font-bold text-blue-600 tracking-wider">ED.RENT</span>
        </div>

        <!-- Teks Kategori Menu -->
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 px-2">MAIN MENU</p>
        
        <nav class="space-y-2">
            <!-- Dashboard Link -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#3B82F6] text-white shadow-lg shadow-blue-100' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fa-solid fa-chart-pie mr-3 text-lg"></i>
                Dashboard
            </a>

            <!-- Daftar Pesanan Link -->
            <a href="{{ route('admin.pesanan.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.pesanan.*') ? 'bg-[#3B82F6] text-white shadow-lg shadow-blue-100' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fa-solid fa-receipt mr-3 text-lg"></i>
                Daftar Pesanan
            </a>

            <!-- Kendaraan Link -->
            <a href="{{ route('admin.kendaraan.index') }}" 
               class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all {{ request()->routeIs('admin.kendaraan.*') ? 'bg-[#3B82F6] text-white shadow-lg shadow-blue-100' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="fa-solid fa-motorcycle mr-3 text-lg"></i>
                Kendaraan
            </a>
        </nav>
    </div>

    <!-- Tombol Log Out -->
    <div class="pb-2">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
            @csrf
        </form>
        <button type="button" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                class="flex items-center w-full px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-red-50 hover:text-red-500 rounded-xl transition-all cursor-pointer">
            <i class="fa-solid fa-right-from-bracket mr-3 text-lg rotate-180"></i>
            Log Out
        </button>
    </div>
</aside>