<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Daftar Supplier</h2>

            @forelse ($suppliers as $supplier)
                <div class="bg-white border-l-4 border-pink-600 shadow rounded-lg p-6 mb-4 transition">
                    <h3 class="text-lg font-semibold text-pink-800">{{ $supplier->nama }}</h3>
                    <p class="text-gray-700">Alamat: {{ $supplier->alamat ?? '-' }}</p>
                    <p class="text-gray-700">Kontak: {{ $supplier->kontak ?? '-' }}</p>
                    <p class="text-gray-700">Email: {{ $supplier->email ?? '-' }}</p>
                    <p class="text-gray-700">Layanan: {{ $supplier->layanan ?? '-' }}</p>
                </div>
            @empty
                <div class="bg-pink-100 border-l-4 border-pink-600 text-pink-700 p-4 rounded mb-4">
                    <p>Belum ada informasi supplier tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
