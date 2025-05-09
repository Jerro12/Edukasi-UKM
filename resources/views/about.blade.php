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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Content Wrapper -->
    <div class="flex-grow">
        <!-- About Section -->
        <main class="flex flex-col items-center justify-center px-8 md:px-20 py-16 h-auto text-center">
            <h1 class="text-3xl font-bold text-pink-600 mb-6">Tentang Edukasi-UKM</h1>
            <p class="text-lg text-gray-700 mb-4 max-w-3xl">
                <strong>Edukasi-UKM</strong> adalah platform digital yang bertujuan mendukung pelaku Usaha Kecil dan
                Menengah (UKM) di Indonesia
                dalam memahami pentingnya desain kemasan dan menemukan supplier yang tepat untuk kebutuhan produk
                mereka.
            </p>
            <p class="text-lg text-gray-700 mb-4 max-w-3xl">
                Kami menyediakan materi edukasi, tutorial desain, dan informasi kontak supplier yang relevan, agar UKM
                dapat tumbuh lebih profesional, efisien, dan mampu bersaing di pasar nasional maupun global.
            </p>
            <p class="text-lg text-gray-700 max-w-3xl">
                Misi kami adalah menjembatani edukasi dan kebutuhan praktis UKM melalui pendekatan digital yang
                sederhana,
                ramah pengguna, dan berdampak nyata.
            </p>
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>
