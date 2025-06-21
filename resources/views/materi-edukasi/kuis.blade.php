<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">

                <h2 class="text-2xl font-bold text-pink-800 mb-6">
                    Kuis: {{ $materi->judul }}
                </h2>

                {{-- Notifikasi sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Cek apakah ada kuis --}}
                @if ($materi->kuis->count())
                    <form method="POST" action="{{ route('materi.kirimJawaban', $materi->id) }}">
                        @csrf

                        @foreach ($materi->kuis as $index => $kuis)
                            <div class="mb-6">
                                <p class="font-semibold text-gray-700 mb-2">
                                    #{{ $index + 1 }}. {{ $kuis->pertanyaan }}
                                </p>

                                <div class="mt-2 space-y-2">
                                    @foreach (['a', 'b', 'c', 'd'] as $opsi)
                                        <label class="block">
                                            <input type="radio" name="jawaban[{{ $kuis->id }}]"
                                                value="{{ $opsi }}" required>
                                            <span class="ml-2 font-medium">
                                                {{ strtoupper($opsi) }}. {{ $kuis['opsi_' . $opsi] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <x-primary-button type="submit">
                            Kirim Jawaban
                        </x-primary-button>
                    </form>
                @else
                    <p class="mt-6 text-gray-500">Belum ada kuis untuk materi ini.</p>
                @endif

                <div class="mt-6">
                    <x-secondary-button>
                        <a href="{{ route('materi.edukasi') }}">
                            ← Kembali ke Daftar Bab
                        </a>
                    </x-secondary-button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
