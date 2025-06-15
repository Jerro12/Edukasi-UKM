<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">

            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $materi->judul }}</h1>
                <p class="text-sm text-gray-600 mb-2">Tanggal Publikasi: {{ $materi->created_at->format('d M Y') }}</p>

                <div class="prose max-w-none text-gray-700 mt-4">
                    {!! nl2br(e($materi->deskripsi)) !!}
                </div>

                {{-- Tambahkan blok kuis --}}
                @if ($materi->kuis->count())
                    <hr class="my-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Kuis</h2>

                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('materi.kirimJawaban', $materi->id) }}" method="POST">
                        @csrf
                        @foreach ($materi->kuis as $kuis)
                            <div class="mb-6">
                                <p class="font-medium text-gray-700">
                                    {{ $loop->iteration }}. {{ $kuis->pertanyaan }}
                                </p>
                                <div class="mt-2 space-y-2">
                                    @foreach (['a', 'b', 'c', 'd'] as $opsi)
                                        <label class="block">
                                            <input type="radio" name="jawaban[{{ $kuis->id }}]"
                                                value="{{ $opsi }}" required>
                                            <span class="ml-2">{{ strtoupper($opsi) }}.
                                                {{ $kuis['opsi_' . $opsi] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <x-primary-button type="submit">Kirim Jawaban</x-primary-button>
                    </form>
                @else
                    <p class="mt-6 text-gray-500">Tidak ada kuis untuk materi ini.</p>
                @endif

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
