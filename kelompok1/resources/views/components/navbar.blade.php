<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-300 mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-indigo-600 hover:opacity-90 transition">
            ED.RENT
        </a>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 transition hover:text-indigo-600">Home</a>
            <a href="#motors" class="text-gray-600 hover:text-indigo-600 font-semibold text-sm transition">Pilih Kendaraan</a>
            <a href="{{ route('order.index') }}" class="text-gray-600 hover:text-indigo-600 font-semibold text-sm transition">Daftar Pesanan</a>
        </nav>

        <!-- Actions (WhatsApp & Avatar) -->
        <div class="flex items-center space-x-4">
            <a href="https://wa.me/628123456789" target="_blank" class="flex items-center gap-2 border border-green-500 text-green-600 hover:bg-green-50 px-5 py-2.5 rounded-full font-bold text-sm transition cursor-pointer">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.007 2.003a9.999 9.999 0 1 0 8.022 16.017l2.6 2.6a1 1 0 0 0 1.415-1.414l-2.6-2.6A9.957 9.957 0 0 0 22.007 12.01C22.007 6.477 17.53 2 12.007 2.003Z" stroke="#25D366" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.5 11.5c0 1.933-1.567 3.5-3.5 3.5a3.504 3.504 0 0 1-3.168-1.987l-1.761.457.468-1.716A3.507 3.507 0 0 1 8 11.5c0-1.933 1.567-3.5 3.5-3.5S15 9.567 15 11.5Z" stroke="#25D366" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Butuh bantuan?</span>
            </a>
            <!-- Avatar Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="open = !open"
                    class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 focus:outline-none"
                >
                    <img
                    src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop"
                    alt="Profile"
                    class="w-full h-full object-cover"
                    >
                </button>

                <!-- Dropdown -->
                <div
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
                >

                    @guest
                        <a href="{{ route('login') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Login
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('profile') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <button
                            type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Logout
                            </button>
                        </form>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</header>