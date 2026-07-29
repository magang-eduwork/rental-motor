@extends('layouts.auth')
@section('title', 'Buat Akun')

@section('content')
<div class="grid min-h-screen grid-cols-1 lg:grid-cols-5">

    <!-- Left Side -->
    <div class="relative hidden lg:block lg:col-span-2 overflow-hidden">
        <img
        src="{{ $heroImage }}"
        alt="Rental motor ED.RENT" class="absolute inset-0 w-full h-full object-cover"
        />

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 flex h-full items-center px-8 lg:px-12 xl:px-16">
          <div class="max-w-lg">
            <div class="mb-8">
                <a href="{{ route('home') }}" class="text-2xl font-black text-white">ED.RENT</a>
            </div>
            <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-white">
            Rental Motor <br>
            Cepat & Aman,<br>
            Mulai Rp75.000/hari
            </h1>
          </div>
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center justify-center bg-gray-50 px-6 py-10 sm:px-8 lg:col-span-3">

        <div class="w-full max-w-md mx-auto">

            <!-- Logo Mobile -->
            <div class="lg:hidden mb-10">
                <a href="{{ route('home') }}"
                   class="text-3xl sm:text-4xl font-black text-indigo-600">
                    ED.RENT
                </a>
            </div>

            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Buat Akun
            </h2>

            <p class="mt-3 text-sm sm:text-base text-gray-500">
                Yuk daftar dulu! Isi data sekali, sewa motor kapan saja tanpa ribet saat liburan.
            </p>

            <form
                action="{{ route('register') }}"
                method="POST"
                class="mt-8 space-y-4">

                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama Lengkap"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Ditambahkan sesuai hasil diskusi) -->
                <div>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No. WhatsApp -->
                <div>
                    <input
                        type="text"
                        name="whatsapp"
                        value="{{ old('whatsapp') }}"
                        placeholder="No. WhatsApp"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    @error('whatsapp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="relative">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Konfirmasi Password"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>

                <!-- No. KTP -->
                <div>
                    <input
                        type="text"
                        name="ktp"
                        value="{{ old('ktp') }}"
                        placeholder="No. KTP"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    @error('ktp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No. SIM -->
                <div>
                    <input
                        type="text"
                        name="sim"
                        value="{{ old('sim') }}"
                        placeholder="No. SIM"
                        class="w-full rounded-lg border-gray-300 px-4 py-3 bg-white focus:border-indigo-500 focus:ring-indigo-500 border-none shadow-sm text-sm">
                    @error('sim')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button -->
                <div class="pt-2">
                    <button
                        class="w-full rounded-lg bg-blue-600 hover:bg-blue-700 text-white py-3 text-sm sm:text-base font-semibold transition">
                        Daftar
                    </button>
                </div>

            </form>

            <!-- Divider -->
            <!-- <div class="my-6 flex items-center">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="px-4 text-xs text-gray-400">
                    CARA LAIN
                </span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div> -->

            <!-- Google -->
            <!-- <button
                class="w-full bg-white border border-gray-200 rounded-lg py-3 font-medium hover:bg-gray-50 text-sm sm:text-base flex items-center justify-center gap-2 shadow-sm">
                <svg class="h-5 w-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </button> -->

            <!-- Register -->
            <p class="text-center mt-6 text-sm text-gray-600">
                Sudah punya akun?
                <a
                    href="{{ route('login') }}"
                    class="text-blue-600 font-medium hover:underline">
                    Masuk
                </a>
            </p>

        </div>

    </div>

</div>
@endsection
