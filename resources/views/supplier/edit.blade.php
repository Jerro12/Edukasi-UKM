<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-700">
                <h1 class="text-2xl font-bold mb-6 text-pink-800">Edit Template Desain</h1>

                <form action="{{ route('supplier.templates.update', $template->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Judul -->
                    <div>
                        <x-input-label for="title" value="Judul" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            value="{{ old('title', $template->title) }}" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-pink-500 focus:border-pink-500">{{ old('description', $template->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- File Desain -->
                    <div>
                        <x-input-label for="file" value="File Desain (Biarkan kosong jika tidak ingin mengganti)" />
                        <input id="file" name="file" type="file" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />

                        @if ($template->file_path)
                            <p class="mt-2 text-sm text-gray-500">File saat ini:</p>

                            @php
                                $ext = strtolower(pathinfo($template->file_path, PATHINFO_EXTENSION));
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
                            @endphp

                            @if (in_array($ext, $imageExtensions))
                                <img src="{{ Storage::url($template->file_path) }}" alt="Preview"
                                    class="mt-2 max-h-48 rounded border border-gray-300">
                            @else
                                <a href="{{ Storage::url($template->file_path) }}" target="_blank"
                                    class="text-pink-600 hover:underline">
                                    Lihat File
                                </a>
                            @endif
                        @endif
                    </div>

                    <!-- Link Preview -->
                    <div>
                        <x-input-label for="example_link" value="Link Preview Canva" />
                        <x-text-input id="example_link" name="example_link" type="url" class="mt-1 block w-full"
                            value="{{ old('example_link', $template->example_link) }}" />
                        <x-input-error :messages="$errors->get('example_link')" class="mt-2" />
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('supplier.templates.index') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">
                            Batal
                        </a>
                        <x-primary-button class="bg-pink-600 hover:bg-pink-700 text-white">
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
