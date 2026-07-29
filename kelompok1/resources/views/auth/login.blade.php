@extends('layouts.auth')
@section('title', 'Masuk')

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
            <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-white">
            Rental Motor <br>
            Cepat & Aman,<br>
            Mulai Rp75.000/hari
            </h1>

            <p class="mt-6 text-lg text-white/90">
            Temukan motor terbaik untuk perjalananmu bersama ED.RENT.
            </p>
          </div>
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center justify-center bg-white px-6 py-10 sm:px-8 lg:col-span-3">

        <div class="w-full max-w-md mx-auto">

            <!-- Logo Mobile -->
            <div class="lg:hidden mb-10">
                <a href="{{ route('home') }}"
                   class="text-3xl sm:text-4xl font-black text-indigo-600">
                    ED.RENT
                </a>
            </div>

            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">
                Masuk
            </h2>

            <p class="mt-3 text-sm sm:text-base text-gray-500">
                Siap keliling Jogja lagi?
                Masuk untuk melanjutkan booking motor Anda.
            </p>

            @if(session('success'))
                <div class="mt-5 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm sm:text-base">
                    {{ session('success') }}
                </div>
            @endif

            <form
                action="{{ route('login') }}"
                method="POST"
                class="mt-8 space-y-5">

                @csrf

                <!-- Email -->
                <div>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500">

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300">

                        <span>Ingatkan saya</span>
                    </label>

                    <a
                        href="#"
                        class="text-indigo-600 hover:underline">
                        Lupa password?
                    </a>

                </div>

                <!-- Button -->
                <button
                    class="w-full rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white py-3 text-sm sm:text-base font-semibold transition">

                    Masuk

                </button>

            </form>

            <!-- Divider -->
            <!-- <div class="my-8 flex items-center">

                <div class="flex-1 h-px bg-gray-300"></div>

                <span class="px-4 text-sm text-gray-400">
                    CARA LAIN
                </span>

                <div class="flex-1 h-px bg-gray-300"></div>

            </div> -->

            <!-- Google -->
            <!-- <button
                class="w-full border rounded-lg py-3 font-medium hover:bg-gray-50 text-sm sm:text-base">

                Masuk dengan Google

            </button> -->

            <!-- Register -->
            <p class="text-center mt-8 text-gray-600">

                Belum punya akun?

                <a
                    href="{{ route('register') }}"
                    class="text-indigo-600 font-semibold hover:underline">

                    Buat akun

                </a>

            </p>

        </div>

    </div>

</div>
@endsection