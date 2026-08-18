<div class="w-full flex items-center justify-between">
    <!-- Left Side: Hamburger & Brand (only visible on mobile/tablet) -->
    <div class="flex items-center gap-3">
        <button type="button" 
                @click="sidebarOpen = !sidebarOpen" 
                class="lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-xl hover:bg-gray-100 transition-all cursor-pointer flex items-center justify-center">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <span class="lg:hidden text-xl font-bold text-blue-600 tracking-wider">ED.RENT</span>
    </div>

    <!-- Right Side: Admin Profile -->
    <div class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
            <p class="text-sm font-semibold text-gray-800">Admin Utama</p>
            <p class="text-xs text-gray-500">Super Admin</p>
        </div>
        <img class="w-9 h-9 rounded-full bg-gray-200 border" src="https://ui-avatars.com/api/?name=Admin+Utama&background=2563eb&color=fff" alt="Admin Profile">
    </div>
</div>