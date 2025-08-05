{{-- resources/views/supplier/show.blade.php --}}
<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-600">

                <h1 class="text-2xl font-bold text-pink-800 mb-4">
                    {{ $template->title }}
                </h1>

                {{-- Deskripsi --}}
                <p class="text-gray-700 mb-4">
                    {{ $template->description ?? 'Tidak ada deskripsi.' }}
                </p>

                {{-- Link Preview Canva --}}
                @if ($template->example_link)
                    <div class="mb-4">
                        <a href="{{ $template->example_link }}" target="_blank"
                            class="inline-flex items-center px-3 py-1 text-sm border rounded-md text-pink-700 border-pink-300 hover:bg-pink-50 transition">
                            🔗 Lihat di Canva
                        </a>
                    </div>
                @endif

                {{-- File yang diupload --}}
                @if (!empty($fileUrl))
                    <div class="mb-4">
                        <p class="font-semibold mb-2">File Desain:</p>

                        @php
                            $ext = pathinfo($template->file_path, PATHINFO_EXTENSION);
                        @endphp

                        {{-- Preview jika gambar --}}
                        @if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'svg']))
                            <img src="{{ $fileUrl }}" alt="Preview Desain" class="max-w-md rounded shadow">
                        @else
                            <a href="{{ $fileUrl }}" target="_blank"
                                class="inline-flex items-center px-3 py-1 text-sm border rounded-md text-blue-700 border-blue-300 hover:bg-blue-50 transition">
                                📂 Download File
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3 mt-6">
                    <a href="{{ route('supplier.templates.index') }}"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                        ← Kembali
                    </a>

                    <a href="{{ route('supplier.templates.edit', $template->id) }}"
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">
                        ✏️ Edit
                    </a>

                    {{-- Hapus --}}
                    <form method="POST" action="{{ route('supplier.templates.destroy', $template->id) }}"
                        onsubmit="return confirm('Yakin ingin menghapus template ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
