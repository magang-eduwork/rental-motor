<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ED.RENT | Rental Motor</title>

    <!-- Menggunakan CDN Tailwind CSS agar tidak perlu Vite/npm -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konfigurasi tambahan jika diperlukan -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5', // Indigo-600
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header / Navigasi Global -->
    <header class="bg-white border-b border-gray-200">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-indigo-600">ED.RENT</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Global -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="container mx-auto px-6 py-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} ED.RENT. All rights reserved.
        </div>
    </footer>

</body>
</html>