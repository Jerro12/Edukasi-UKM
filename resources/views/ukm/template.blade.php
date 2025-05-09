<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <h2 class="text-2xl font-bold text-pink-800 mb-6">Daftar Template Design</h2>
            @foreach ($templates as $template)
                <div class="p-4 bg-white border-l-4 border-pink-600 rounded shadow transition">
                    <h3 class="text-lg font-bold text-pink-800">{{ $template->title }}</h3>
                    <p class="text-gray-700">{{ $template->description }}</p>

                    @if ($template->preview_link)
                        <a href="{{ $template->preview_link }}"
                            class="inline-block mt-2 text-pink-600 hover:bg-pink-200 px-3 py-1 rounded transition"
                            target="_blank">
                            Lihat Contoh
                        </a>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('templates.show', $template->id) }}">
                            <x-secondary-button>
                                {{ __('Lihat Selengkapnya') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
