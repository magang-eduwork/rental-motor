<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ED.RENT') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @isset($favicon)
        <link rel="icon" type="image/png" href="{{ asset($favicon) }}">
    @endisset

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    @if (!request()->routeIs(['login', 'register']))
        @include('components.navbar')
    @endif

    {{-- Main Content --}}
    <main class="flex-grow">
        {{-- Mendukung @yield('content') DAN <x-slot /> --}}
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    {{-- Footer --}}
    @if (!request()->routeIs(['login', 'register']))
        @include('components.footer')
    @endif

    {{-- Scripts --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>