<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ED.RENT') | Rental Motor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $favicon }}">

    <!-- Alpine.js (Ditaruh di head agar tersedia sebelum komponen di-render) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col justify-between">

    @if (!Request::routeIs('login') && !Request::routeIs('register'))
    @include('components.navbar')
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    @if (!Request::routeIs('login') && !Request::routeIs('register'))
    @include('components.footer')
    @endif

    @stack('scripts')
</body>
</html>