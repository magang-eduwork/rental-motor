{{-- HALAMAN UTK USER BARU/USER BELUM LOGIN --}}
@props(['title', 'message', 'buttonText' => null, 'buttonRoute' => null])

<div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
    <!-- Ilustrasi -->
    <img src="https://i.ibb.co.com/VYfhgqm4/image-44.png" alt="Empty State" class="w-48 mx-auto mb-6 opacity-50">
    
    <!-- Teks -->
    <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
    <p class="text-gray-500 mt-2 max-w-sm mx-auto">{{ $message }}</p>

    <!-- Tombol Opsional -->
    @if($buttonText && $buttonRoute)
        <a href="{{ $buttonRoute }}" class="mt-8 inline-block bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition">
            {{ $buttonText }}
        </a>
    @endif
</div>