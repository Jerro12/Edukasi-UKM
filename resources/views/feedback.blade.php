<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white border-l-4 border-pink-600 rounded shadow">
        <h2 class="text-2xl font-bold text-pink-800 mb-4">Kirim Feedback</h2>

        @if (session('success'))
            <div class="bg-pink-600 border border-pink-600 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('feedback.submit') }}" method="POST">
            @csrf

            <div class="mb-4">
                <x-input-label for="message" :value="'Pesan Feedback'" />
                <textarea id="message" name="message" rows="5"
                    class="mt-1 block w-full border border-pink-600 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 transition">{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>

            <x-secondary-button type="submit"
                class="border-pink-600 text-pink-600 rounded hover:bg-pink-200 transition">
                Kirim
            </x-secondary-button>
        </form>
    </div>
</x-app-layout>
