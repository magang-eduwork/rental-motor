<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - ED.RENT</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#F8F9FA] font-sans antialiased flex h-screen overflow-hidden m-0 p-0">

    <!-- SIDEBAR DI KIRI (Fixed width, full height) -->
    <aside class="w-64 flex-shrink-0 h-full bg-white border-r border-gray-200 flex flex-col z-20">
        @include('admin.components.sidebar')
    </aside>

    <!-- WRAPPER UTAMA DI KANAN (Navbar + Area Gulir Bersama untuk Konten & Footer) -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        
        <!-- TOP NAVBAR (Tetap di atas) -->
        <header class="h-16 bg-white border-b border-gray-200 flex-shrink-0 flex items-center justify-between px-6 z-10">
            @include('admin.components.navbar')
        </header>

        <!-- AREA UTAMA YANG DAPAT DIGULIR (Memuat Konten dan Footer Sekaligus) -->
        <main class="flex-1 overflow-y-auto bg-[#F8F9FA] p-6 flex flex-col justify-between">
            
            <!-- Konten Halaman -->
            <div class="mb-10">
                @yield('content')
            </div>

            <!-- FOOTER MENGIKUTI ALUR HALAMAN (DI BAGIAN BAWAH KONTEN) -->
            <footer class="bg-white border-t border-gray-200 py-6 px-6 rounded-2xl shadow-sm mt-auto">
                <x-footer />
            </footer>

        </main>

    </div>

</body>
</html>