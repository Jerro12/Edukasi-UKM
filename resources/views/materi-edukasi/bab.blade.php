<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Daftar Bab Materi</h2>

            @forelse ($babMateris as $bab)
                <div class="bg-white border-l-4 border-pink-600 shadow rounded-lg p-6 mb-4 transition">
                    <h3 class="text-lg font-semibold text-pink-800">{{ $bab->judul_bab }}</h3>
                    <p class="mt-2 text-gray-700">Jumlah Materi: {{ $bab->sub_materi_count }}</p>
                    @if (isset($bab->total_poin_user))
                        <p class="mt-1 text-green-700 font-semibold">Total Poin Kamu: {{ $bab->total_poin_user }}</p>
                        <pre>{{ var_dump($bab) }}</pre>
                    @endif
                    <div class="mt-4">
                        <x-secondary-button>
                            <a href="{{ route('materi.edukasi.bab.detail', $bab->id) }}">Lihat Materi</a>
                        </x-secondary-button>
                    </div>
                </div>
            @empty
                <div class="bg-pink-100 border-l-4 border-pink-600 text-pink-700 p-4 rounded mb-4">
                    <p>Belum ada bab materi tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
