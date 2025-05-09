<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo di kiri -->
            <div class="flex items-center">
                <h1 class="text-xl font-bold  text-pink-600">EDKAS-UKM</h1>
            </div>

            <!-- Menu link di kanan -->
            <div class="hidden sm:flex space-x-8 font-medium">
                <a href="/" class="text-gray-700 hover:text-pink-600">Beranda</a>
                <a href="{{ 'about' }}" class="text-gray-700 hover:text-pink-600">About</a>
                <a href="{{ 'contact' }}" class="text-gray-700 hover:text-pink-600">Kontak & Bantuan</a>
                <div class="space-x-4">
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">Register</a>
                    <a href="{{ route('login') }}"
                        class="px-6 py-2 border border-pink-600 text-pink-600 rounded hover:bg-pink-200 transition">Login</a>
                </div>
            </div>

            <!-- Hamburger icon untuk mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-pink-600 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Responsif -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#" class="block pl-3 pr-4 py-2 text-gray-700 hover:text-pink-600">Beranda</a>
            <a href="#" class="block pl-3 pr-4 py-2 text-gray-700 hover:text-pink-600">About</a>
            <a href="#" class="block pl-3 pr-4 py-2 text-gray-700 hover:text-pink-600">Kontak & Bantuan</a>
            <div class="space-x-4">
                <a href="{{ route('register') }}"
                    class="px-6 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition">Register</a>
                <a href="{{ route('login') }}"
                    class="px-6 py-2 border border-pink-600 text-pink-600 rounded hover:bg-pink-200 transition">Login</a>
            </div>
        </div>
    </div>
</nav>
