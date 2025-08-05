<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-600">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-pink-800">Daftar Template Desain</h1>
                    <x-primary-button class="bg-pink-600 hover:bg-pink-700 text-white">
                        <a href="{{ route('supplier.templates.create') }}">
                            Tambah Baru
                        </a>
                    </x-primary-button>
                </div>

                <ul class="space-y-4">
                    @forelse ($templates as $template)
                        <li class="p-4 bg-white border border-pink-200 rounded shadow">
                            <div class="flex justify-between items-start">
                                <div class="w-3/4">
                                    <h2 class="text-lg font-semibold text-pink-700">
                                        {{ $template->title }}
                                    </h2>
                                    <p class="text-gray-600 mt-1">{{ $template->description }}</p>

                                    @if ($template->preview_link)
                                        <div class="mt-2 text-sm">
                                            <a href="{{ $template->preview_link }}" target="_blank"
                                                class="text-pink-600 hover:underline">
                                                Lihat Contoh
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Aksi: Lihat | Edit | Hapus -->
                                <div class="flex items-start gap-3">
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('supplier.templates.show', $template->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-sm border rounded-md
               text-pink-700 border-pink-200 bg-white
               hover:bg-pink-100 hover:border-pink-300 transition-colors duration-200">
                                        Lihat
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('supplier.templates.edit', $template->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-sm border rounded-md
               text-pink-700 border-pink-200 bg-white
               hover:bg-pink-100 hover:border-pink-300 transition-colors duration-200">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <x-secondary-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-template-deletion-{{ $template->id }}')"
                                        class="mt-0 px-3 py-1 text-sm text-red-600 border-red-300 bg-white
               hover:bg-red-100 hover:border-red-400 transition-colors duration-200">
                                        Hapus
                                    </x-secondary-button>
                                </div>


                                <!-- Modal Konfirmasi Penghapusan -->
                                <x-modal name="confirm-template-deletion-{{ $template->id }}" :show="$errors->deletion->isNotEmpty()"
                                    focusable>
                                    <form method="POST" action="{{ route('supplier.templates.destroy', $template) }}"
                                        class="p-6 bg-pink-50 text-gray-700">
                                        @csrf
                                        @method('DELETE')

                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Apakah Anda yakin ingin menghapus template ini?') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Setelah template dihapus, semua data terkait dengan template ini akan hilang secara permanen.') }}
                                        </p>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Batal') }}
                                            </x-secondary-button>

                                            <x-primary-button class="ms-3" type="submit">
                                                {{ __('Hapus Template') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </div>
                        </li>
                    @empty
                        <li class="text-pink-600">Belum ada template desain.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
