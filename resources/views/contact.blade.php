<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Edukasi-UKM') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="manifest" href="{{ asset('build/manifest.webmanifest') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Content Wrapper -->
    <div class="flex-grow">
        <main class="px-8 md:px-20 py-16 text-center">
            <h1 class="text-3xl font-bold mb-4  text-pink-600">Hubungi Kami</h1>
            <p class="text-gray-700 max-w-2xl mx-auto mb-8">Jika Anda memiliki pertanyaan, kritik, atau saran, silakan
                hubungi kami melalui informasi kontak di bawah ini.</p>

            <div class="space-y-2">
                <p><i class="fas fa-envelope text-pink-600 mr-2"></i> edukasiukm@example.com</p>
                <p><i class="fas fa-phone text-pink-600 mr-2"></i> +62 812-3456-7890</p>
                <p><i class="fas fa-map-marker-alt text-pink-600 mr-2"></i> Jl. Merdeka No. 123, Jakarta</p>
            </div>
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>
