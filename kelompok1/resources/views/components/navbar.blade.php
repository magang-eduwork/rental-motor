<style>
    /* ================================
       DESKTOP
       ================================ */
    @media (min-width: 768px) {
        .mobile-menu-button {
            display: none !important;
        }

        .mobile-menu-panel {
            display: none !important;
        }
    }

    /* ================================
       MOBILE
       ================================ */
    @media (max-width: 767px) {
        .desktop-navigation {
            display: none !important;
        }

        .desktop-actions {
            display: none !important;
        }

        .mobile-menu-button {
            display: flex !important;
        }
    }
</style>

<header
    class="bg-white border-b border-gray-200 sticky top-0 z-50"
    x-data="{ mobileOpen: false, profileOpen: false }"
>

    <div class="max-w-300 mx-auto px-4 sm:px-6 py-3 sm:py-4">

        <div class="flex items-center justify-between">

            {{-- =========================
                 LOGO
            ========================== --}}
            <a
                href="{{ route('home') }}"
                class="text-2xl font-black tracking-tight text-indigo-600 hover:opacity-90 transition"
            >
                ED.RENT
            </a>


            {{-- =========================
                 DESKTOP NAVIGATION
                 Muncul hanya >= md
            ========================== --}}
            <nav class="desktop-navigation flex items-center space-x-8">

                <a
                    href="{{ route('home') }}"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition"
                >
                    Home
                </a>

                <a
                    href="{{ route('kendaraan') }}"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition"
                >
                    Pilih Kendaraan
                </a>

                <a
                    href="{{ route('order.index') }}"
                    class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition"
                >
                    Daftar Pesanan
                </a>

            </nav>


            {{-- =========================
                 DESKTOP ACTIONS
                 Muncul hanya >= md
            ========================== --}}
            <div class="desktop-actions flex items-center space-x-4">

                {{-- WhatsApp --}}
                <a
                    href="https://wa.me/628123456789"
                    target="_blank"
                    class="flex items-center gap-2 border border-green-500 text-green-600 hover:bg-green-50 px-5 py-2.5 rounded-full font-bold text-sm transition"
                >

                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M12.007 2.003a9.999 9.999 0 1 0 8.022 16.017l2.6 2.6a1 1 0 0 0 1.415-1.414l-2.6-2.6A9.957 9.957 0 0 0 22.007 12.01C22.007 6.477 17.53 2 12.007 2.003Z"
                            stroke="#25D366"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M15.5 11.5c0 1.933-1.567 3.5-3.5 3.5a3.504 3.504 0 0 1-3.168-1.987l-1.761.457.468-1.716A3.507 3.507 0 0 1 8 11.5c0-1.933 1.567-3.5 3.5-3.5S15 9.567 15 11.5Z"
                            stroke="#25D366"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    <span>Butuh bantuan?</span>

                </a>


                {{-- Profile Desktop --}}
                <div class="relative">

                    <button
                        type="button"
                        @click="profileOpen = !profileOpen"
                        class="w-10 h-10 rounded-full overflow-hidden border border-gray-200 focus:outline-none"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop"
                            alt="Profile"
                            class="w-full h-full object-cover"
                        >
                    </button>


                    {{-- Profile Dropdown --}}
                    <div
                        x-show="profileOpen"
                        @click.away="profileOpen = false"
                        x-transition
                        class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
                    >

                        @guest

                            <a
                                href="{{ route('login') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Login
                            </a>

                        @endguest


                        @auth

                            <a
                                href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                >
                                    Logout
                                </button>

                            </form>

                        @endauth

                    </div>

                </div>

            </div>


            {{-- =========================
                 MOBILE BUTTON
                 Muncul hanya < md
            ========================== --}}
            <button
                type="button"
                @click="mobileOpen = !mobileOpen"
                class="mobile-menu-button items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-700"
                style="display: none;"
            >

                {{-- Hamburger --}}
                <svg
                    x-show="!mobileOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="22"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>


                {{-- Close --}}
                <svg
                    x-show="mobileOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="22"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                </svg>

            </button>

        </div>


        {{-- =========================
             MOBILE MENU
             Muncul hanya < md
        ========================== --}}
        <div
            x-show="mobileOpen"
            x-transition
            class="mobile-menu-panel"
        >

            <div class="border-t border-gray-100 mt-3 pt-3 pb-2">

                {{-- Home --}}
                <a
                    href="{{ route('home') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition"
                >
                    Home
                </a>


                {{-- Kendaraan --}}
                <a
                    href="{{ route('kendaraan') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition"
                >
                    Pilih Kendaraan
                </a>


                {{-- Pesanan --}}
                <a
                    href="{{ route('order.index') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition"
                >
                    Daftar Pesanan
                </a>


                {{-- Divider --}}
                <div class="border-t border-gray-100 my-2"></div>


                {{-- WhatsApp --}}
                <a
                    href="https://wa.me/628123456789"
                    target="_blank"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-green-600 hover:bg-green-50 transition"
                >

                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M12.007 2.003a9.999 9.999 0 1 0 8.022 16.017l2.6 2.6a1 1 0 0 0 1.415-1.414l-2.6-2.6A9.957 9.957 0 0 0 22.007 12.01C22.007 6.477 17.53 2 12.007 2.003Z"
                            stroke="#25D366"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        <path
                            d="M15.5 11.5c0 1.933-1.567 3.5-3.5 3.5a3.504 3.504 0 0 1-3.168-1.987l-1.761.457.468-1.716A3.507 3.507 0 0 1 8 11.5c0-1.933 1.567-3.5 3.5-3.5S15 9.567 15 11.5Z"
                            stroke="#25D366"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Butuh bantuan?

                </a>


                {{-- Profile / Login --}}
                <div class="border-t border-gray-100 mt-2 pt-2">

                    @guest

                        <a
                            href="{{ route('login') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition"
                        >
                            Login
                        </a>

                    @endguest


                    @auth

                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition"
                        >
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50 transition"
                            >
                                Logout
                            </button>

                        </form>

                    @endauth

                </div>

            </div>

        </div>

    </div>

</header>