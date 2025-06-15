<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Bab: {{ $bab->judul_bab }}</h2>

            @forelse ($bab->subMateri as $item)
                <div class="bg-white border-l-4 border-pink-600 shadow rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold text-pink-800">{{ $item->judul }}</h3>
                    <p class="mt-2 text-gray-700">{{ $item->deskripsi }}</p>
                    <div class="mt-4">
                        <x-secondary-button>
                            <a href="{{ route('materi.edukasi.detail', $item->id) }}">Lihat Selengkapnya</a>
                        </x-secondary-button>
                    </div>
                </div>
            @empty
                <div class="bg-pink-100 border-l-4 border-pink-600 text-pink-700 p-4 rounded mb-4">
                    <p>Belum ada materi pada bab ini.</p>
                </div>
            @endforelse

            <div class="mt-8">
                <x-secondary-button>
                    <a href="{{ route('materi.edukasi') }}">← Kembali ke Daftar Bab</a>
                </x-secondary-button>
            </div>
        </div>
    </div>
</x-app-layout>
