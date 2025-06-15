<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Daftar Bab Materi</h2>

            @foreach ($babMateris as $bab)
                <div class="bg-white border-l-4 border-pink-600 shadow rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold text-pink-800">{{ $bab->judul_bab }}</h3>
                    <p class="text-gray-600">{{ $bab->sub_materi_count }} materi</p>
                    @if (isset($bab->total_poin_user))
                        <p class="mt-1 text-green-700 font-semibold">Total Poin Kamu: {{ $bab->total_poin_user }}</p>
                        {{-- <pre>{{ var_dump($bab) }}</pre> --}}
                    @endif
                    <div class="mt-3">
                        <x-secondary-button>
                            <a href="{{ route('materi.edukasi.bab.detail', $bab->id) }}">Lihat Materi</a>
                        </x-secondary-button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
