<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded-lg shadow border-l-4 border-pink-600">
            <h2 class="text-3xl font-bold text-pink-800 mb-4">{{ $template->title }}</h2>
            @if ($template->file_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $template->file_path) }}" alt="Thumbnail"
                        class="w-full max-w-md rounded shadow">
                </div>
            @endif

            <p class="text-gray-700 text-lg mb-6">
                {{ $template->description }}
            </p>

            @if ($template->example_link)
                <div class="mb-4">
                    <a href="{{ $template->example_link }}" target="_blank"
                        class="inline-block text-white bg-pink-600 hover:bg-pink-700 px-2 py-1 rounded transition">
                        Lihat Preview
                    </a>
                </div>
            @endif
            <x-secondary-button>
                <a href="{{ route('templates.index') }}"> Kembali ke daftar template
                </a>
            </x-secondary-button>
        </div>
    </div>
</x-app-layout>
