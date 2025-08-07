<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA  -->

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


    @include('layouts.navbar')
    <!-- Content Wrapper -->
    <div class="flex-grow">
        <!-- Navbar -->

        <!-- Hero Section -->
        <main class="flex flex-col-reverse md:flex-row items-center justify-between px-8 md:px-20 py-16 h-auto">
            <div class="max-w-xl">
                <p class="text-sm text-pink-600 font-semibold">Halo, Selamat Datang</p>
                <h2 class="text-3xl font-bold mt-2 mb-4 leading-tight">
                    Solusi Terbaik untuk Edukasi Desain<br>
                    Kemasan dan Informasi Supplier Bagi UKM
                </h2>
                <p class="text-gray-600 mb-6">Belajar, Desain, dan Temukan Supplier untuk Kemasan Terbaik Anda</p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">Register</a>
                    <a href="{{ route('login') }}"
                        class="px-6 py-2 border border-pink-600 text-pink-600 rounded hover:bg-pink-200 transition">Login</a>
                </div>
            </div>

            <div class="w-full md:w-1/2 mb-10 md:mb-0">
                <img src="{{ asset('img/woman-working.png') }}" alt="Ilustrasi wanita dengan laptop"
                    class="w-full max-w-md mx-auto">
            </div>
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.footer')
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
</body>

</html>
