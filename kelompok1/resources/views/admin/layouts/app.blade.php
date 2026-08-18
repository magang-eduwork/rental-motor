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
    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F8F9FA] font-sans antialiased flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed inset-y-0 left-0 z-40 w-64 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:h-full flex-shrink-0 bg-white">
        @include('admin.components.sidebar')
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-30 bg-black/40 lg:hidden"
         style="display: none;"
         x-cloak>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col min-w-0 h-full">

        <!-- Navbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 flex-shrink-0">
            @include('admin.components.navbar')
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#F8F9FA] p-4 sm:p-6">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>