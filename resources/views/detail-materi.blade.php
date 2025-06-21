<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $materi->judul }}</h1>
                <p class="text-sm text-gray-600 mb-2">
                    Tanggal Publikasi: {{ $materi->created_at->format('d M Y') }}
                </p>

                <div class="prose max-w-none text-gray-700 mt-4">
                    {!! nl2br(e($materi->deskripsi)) !!}
                </div>

                {{-- Tombol kembali --}}
                <div class="mt-6">
                    <x-secondary-button>
                        <a href="{{ route('materi.edukasi') }}">
                            ← Kembali ke Materi
                        </a>
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
