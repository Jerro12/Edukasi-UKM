<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-700">
                    <h3 class="text-xl font-semibold text-gray-800">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-4 text-gray-600">Kamu telah berhasil login sebagai pengguna.</p>
                    <p class="mt-2 text-gray-500">Ini adalah halaman pengguna, tempat kamu bisa mengakses berbagai
                        informasi dan fitur yang tersedia untuk pengguna.</p>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
