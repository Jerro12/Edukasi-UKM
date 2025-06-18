<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Daftar Bab Materi</h2>

            @foreach ($babMateris as $bab)
                <div class="bg-white border-l-4 border-pink-600 shadow rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold text-pink-800">
                        {{ $bab->judul_bab }}
                        @if ($bab->is_locked ?? false)
                            <span class="text-sm text-red-500 ml-2">🔒 Terkunci</span>
                        @endif
                    </h3>

                    <p class="text-gray-600">{{ $bab->sub_materi_count }} materi</p>

                    @if (isset($bab->total_poin_user))
                        <p class="mt-1 text-green-700 font-semibold">
                            Total Poin Kamu: {{ $bab->total_poin_user }}
                        </p>
                    @endif

                    <div class="mt-3">
                        @if (!($bab->is_locked ?? false))
                            <x-secondary-button>
                                <a href="{{ route('materi.edukasi.bab.detail', $bab->id) }}">Lihat Materi</a>
                            </x-secondary-button>
                        @else
                            <button class="bg-gray-300 text-gray-600 px-4 py-2 rounded"
                                onclick="showLockedMessage({{ $loop->index + 1 }})">
                                Materi Terkunci
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function showLockedMessage() {
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'alert-modal'
            }));
        }
    </script>

</x-app-layout>

<x-modal name="alert-modal" maxWidth="sm">
    <div class="p-6 text-center">
        <h2 class="text-lg font-semibold text-pink-700 mb-4">Akses Ditolak</h2>
        <p class="text-gray-700">Kamu harus mencapai minimal 80 poin di bab sebelumnya untuk membuka materi ini.</p>

        <div class="mt-4">
            <button @click="$dispatch('close-modal', 'alert-modal')"
                class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">
                Mengerti
            </button>
        </div>
    </div>
</x-modal>
