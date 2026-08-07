<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - ED.RENT</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    @if(!empty($favicon))
        <link rel="icon" type="image/png" href="{{ str_contains($favicon, 'http') ? $favicon : asset($favicon) }}">
    @endif

    @stack('styles')
</head>
<body class="bg-[#F8F9FA] font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 h-full bg-white border-r border-gray-200">
        @include('admin.components.sidebar')
    </aside>

    <!-- Content -->
    <div class="flex-1 flex flex-col min-w-0 h-full">

        <!-- Navbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">
            @include('admin.components.navbar')
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#F8F9FA] p-6">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>