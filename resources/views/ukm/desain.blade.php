<x-app-layout>
    <div class="py-12 bg-pink-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{
            showModal: false,
            deleteId: null,
            deleteTitle: '',
            openModal(id, title) {
                this.deleteId = id;
                this.deleteTitle = title;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.deleteId = null;
                this.deleteTitle = '';
            }
        }">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-pink-800">Desain Saya</h1>
                <a href="{{ route('ukm.desain.editor') }}"
                    class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded shadow transition">
                    + Buat Desain Baru
                </a>
            </div>

            {{-- Daftar desain --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($desains as $desain)
                    <div
                        class="relative p-2 bg-white border-l-4 border-pink-600 rounded shadow hover:shadow-md transition">
                        <a href="{{ route('desain.edit', $desain->id) }}">
                            <img src="{{ asset('storage/' . $desain->thumbnail_url) }}" alt="Preview"
                                class="w-full h-48 object-cover bg-gray-200 rounded">
                            <div class="mt-4 px-2">
                                <h2 class="text-lg font-bold text-pink-800 truncate">
                                    {{ $desain->judul ?? 'Tanpa Judul' }}
                                </h2>
                                <p class="text-sm text-gray-600">{{ $desain->updated_at->diffForHumans() }}</p>
                            </div>
                        </a>

                        {{-- Tombol hapus --}}
                        <button class="absolute top-2 right-2 text-red-600 hover:text-red-800"
                            @click.prevent="openModal({{ $desain->id }}, '{{ addslashes($desain->judul) }}')"
                            aria-label="Hapus desain">
                            <!-- Icon X simple -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-600">Belum ada desain yang kamu buat.</p>
                @endforelse
            </div>

            {{-- Modal hapus desain --}}
            <div x-show="showModal" x-transition
                class="fixed inset-0 flex items-center justify-center bg-pink-50 bg-opacity-90 z-50"
                style="display: none;" @keydown.escape.window="closeModal()">
                <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-lg" @click.away="closeModal()">
                    <h2 class="text-lg font-semibold mb-4 text-center text-pink-800">Hapus desain ini?</h2>
                    <p class="mb-4 text-center text-gray-700">
                        Apakah kamu yakin ingin menghapus desain: <br>
                        <span class="font-bold" x-text="deleteTitle"></span>?
                    </p>
                    <form :action="`/ukm/desain/${deleteId}`" method="POST" class="flex justify-center gap-4">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click.prevent="closeModal()"
                            class="px-4 py-2 rounded bg-pink-200 hover:bg-pink-300 text-pink-800 font-semibold transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-pink-600 hover:bg-pink-700 text-white font-semibold transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
