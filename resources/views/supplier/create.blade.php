<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-700">
                <h1 class="text-2xl font-bold mb-6">Tambah Template Desain</h1>

                <form action="{{ route('supplier.templates.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <x-input-label for="title" value="Judul" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required
                            autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <x-input-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring-pink-500 focus:border-pink-500">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- File Desain -->
                    <div>
                        <x-input-label for="file" value="File Desain" />
                        <input id="file" name="file" type="file" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <!-- Link Preview -->
                    <div>
                        <x-input-label for="example_link" value="Link Preview Canva" />
                        <x-text-input id="example_link" name="example_link" type="url" class="mt-1 block w-full"
                            :value="old('example_link')" />
                        <x-input-error :messages="$errors->get('example_link')" class="mt-2" />
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-end">
                        <x-secondary-button type="submit" class="border-pink-600 text-pink-600 hover:bg-pink-200">
                            Simpan
                        </x-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
