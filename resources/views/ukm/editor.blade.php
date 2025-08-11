<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Buat Desain Baru - {{ config('app.name') }}</title>

    <!-- Fonts & CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .tool-btn {
            @apply bg-gray-100 hover:bg-gray-200 text-sm px-3 py-1 rounded transition;
        }

        /* opsional: biar scrollbar ramping */
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }
    </style>
</head>

<body class="bg-pink-100 w-full h-screen overflow-hidden font-sans text-gray-800">

    <!-- ==================== TOP BAR ==================== -->
    <section
        class="absolute top-4 left-4 right-4 flex flex-wrap sm:flex-nowrap sm:justify-between items-center bg-white shadow-md rounded-lg px-6 py-3 gap-4 z-50">

        <div class="flex items-center w-full sm:w-auto gap-4">
            <a href="{{ route('ukm.desain') }}"
                class="flex items-center gap-1 text-gray-700 hover:text-pink-600 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <input type="text" id="judul" placeholder="Judul Desain"
                class="w-full sm:max-w-md border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-3 focus:ring-pink-500 transition" />
        </div>
    </section>


    <!-- ==================== BOTTOM ACTION BAR ==================== -->
    <div class="fixed bottom-4 left-4 right-4 flex flex-wrap justify-end gap-2 sm:gap-3 z-40">
        <button id="btn-export"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-md text-sm sm:text-base transition">
            ⬇️ Export
        </button>
        <button id="btn-simpan"
            class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md text-sm sm:text-base transition">
            💾 Simpan
        </button>
    </div>


    <!-- ==================== TOOLBAR ==================== -->
    <section
        class="absolute top-24 left-4 right-4 flex flex-wrap sm:flex-nowrap gap-3 bg-white shadow-sm rounded-lg px-4 py-2 z-40 items-center overflow-x-auto scrollbar-thin">

        <!-- Selection Tool -->
        <button id="tool-select" class="tool-btn">🔲 Select</button>

        <!-- Text Tool -->
        <button id="tool-text" class="tool-btn">🅣 Text</button>

        <!-- Shape Tools -->
        <button id="tool-rect" class="tool-btn">⬛ Rect</button>
        <button id="tool-circle" class="tool-btn">⚪ Circle</button>
        <button id="tool-triangle" class="tool-btn">🔺 Triangle</button>

        <!-- Line & Arrow -->
        <button id="tool-line" class="tool-btn">➖ Line</button>
        <button id="tool-arrow" class="tool-btn">➡️ Arrow</button>

        <!-- Image Upload -->
        <label class="tool-btn cursor-pointer">
            🖼️ Upload
            <input type="file" id="tool-image" accept="image/*" class="hidden">
        </label>

        <!-- Color Picker -->
        <input type="color" id="fill-color" class="w-8 h-8 border rounded" title="Fill Color">
        <input type="color" id="stroke-color" class="w-8 h-8 border rounded" title="Stroke Color">

        <!-- Canvas Size -->
        <div class="flex items-center gap-2 ml-auto">
            <label class="text-sm">W:</label>
            <input type="number" id="canvas-width" value="800" min="100"
                class="w-20 border border-gray-300 px-2 py-1 rounded text-sm" />
            <label class="text-sm">H:</label>
            <input type="number" id="canvas-height" value="600" min="100"
                class="w-20 border border-gray-300 px-2 py-1 rounded text-sm" />
            <button id="resize-canvas"
                class="tool-btn bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg p-1">Resize</button>
        </div>
    </section>

    <!-- ==================== LAYERS PANEL ==================== -->
    <section id="layers-panel" class="absolute top-36 right-4 w-80 bg-white rounded-lg shadow-md p-4 z-40 ">
        <h2 class="text-lg font-semibold mb-2">📚 Layers</h2>
        <ul id="layers-list" class="space-y-2 max-h-[300px] overflow-y-auto text-sm">
            <!-- JS akan menambahkan list item di sini -->
        </ul>
    </section>



    <!-- ==================== OBJECT PROPERTIES PANEL ==================== -->
    <section id="object-properties"
        class="absolute top-[160px] left-4 w-80 bg-white rounded-lg shadow-md p-4 z-40 hidden overflow-y-auto max-h-[calc(100vh-180px)]">
        <h2 class="text-lg font-semibold mb-2">🎛️ Object Properties</h2>

        <!-- Position -->
        <div class="mb-2">
            <label class="block text-sm">Position</label>
            <div class="flex gap-2">
                <input type="number" id="prop-x" class="w-1/2 border px-2 py-1 rounded text-sm" placeholder="X" />
                <input type="number" id="prop-y" class="w-1/2 border px-2 py-1 rounded text-sm" placeholder="Y" />
            </div>
        </div>

        <!-- Size -->
        <div class="mb-2">
            <label class="block text-sm">Size</label>
            <div class="flex gap-2 items-center">
                <input type="number" id="prop-width" class="w-1/2 border px-2 py-1 rounded text-sm"
                    placeholder="Width" />
                <input type="number" id="prop-height" class="w-1/2 border px-2 py-1 rounded text-sm"
                    placeholder="Height" />
            </div>
            <label class="flex items-center mt-1 gap-2 text-xs">
                <input type="checkbox" id="lock-aspect" class="accent-blue-500" />
                Lock aspect ratio
            </label>
        </div>

        <!-- Rotation & Skew -->
        <div class="mb-2">
            <label class="block text-sm">Rotation</label>
            <input type="number" id="prop-angle" class="w-full border px-2 py-1 rounded text-sm"
                placeholder="Angle" />
        </div>

        <!-- Opacity -->
        <div class="mb-2">
            <label class="block text-sm">Opacity</label>
            <input type="range" id="prop-opacity" min="0" max="1" step="0.01" class="w-full" />
        </div>

        <!-- Layer Order -->
        <div class="flex justify-between mt-2">
            <button id="btn-bring-front" class="text-xs bg-blue-100 px-2 py-1 rounded hover:bg-blue-200">🔼
                Front</button>
            <button id="btn-send-back" class="text-xs bg-blue-100 px-2 py-1 rounded hover:bg-blue-200">🔽
                Back</button>
            <button id="btn-lock" class="text-xs bg-red-100 px-2 py-1 rounded hover:bg-red-200">🔒 Lock</button>
            <button id="btn-unlock" class="text-xs bg-green-100 px-2 py-1 rounded hover:bg-green-200">🔓
                Unlock</button>
        </div>

        <!-- ==================== STYLE PANEL ==================== -->
        <div class="" id="style-panel">
            <h2 class="text-lg font-semibold mb-2 mt-2">🛠️ Style Panel</h2>

            <!-- Font Family -->
            <div class="mb-2">
                <label class="block text-sm mb-1">Font</label>
                <select id="style-font" class="w-full border px-2 py-1 rounded text-sm">
                    <option value="Arial">Arial</option>
                    <option value="Verdana">Verdana</option>
                    <option value="Helvetica">Helvetica</option>
                    <option value="Tahoma">Tahoma</option>
                    <option value="Trebuchet MS">Trebuchet MS</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Times New Roman">Times New Roman</option>
                    <option value="Palatino Linotype">Palatino Linotype</option>
                    <option value="Garamond">Garamond</option>
                    <option value="Bookman">Bookman</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Poppins">Poppins</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lato">Lato</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Raleway">Raleway</option>
                    <option value="Ubuntu">Ubuntu</option>
                    <option value="Courier New">Courier New</option>
                    <option value="Lucida Console">Lucida Console</option>
                    <option value="Consolas">Consolas</option>
                </select>
            </div>

            <!-- Font Size & Weight -->
            <div class="flex gap-2 mb-2">
                <input type="number" id="style-font-size" placeholder="Size"
                    class="w-1/2 border px-2 py-1 rounded text-sm" />
                <div class="flex items-center gap-1 w-1/2">
                    <button id="btn-bold" class="tool-btn w-full">𝐁</button>
                    <button id="btn-italic" class="tool-btn w-full">𝘐</button>
                    <button id="btn-underline" class="tool-btn w-full">U̲</button>
                </div>
            </div>

            <!-- Fill & Stroke -->
            <div class="flex gap-2 mb-2">
                <div class="flex flex-col w-1/2">
                    <label class="text-xs">Fill</label>
                    <input type="color" id="style-fill" class="w-full h-8 border rounded" />
                </div>
                <div class="flex flex-col w-1/2">
                    <label class="text-xs">Stroke</label>
                    <input type="color" id="style-stroke" class="w-full h-8 border rounded" />
                </div>
            </div>

            <!-- Stroke Width -->
            <div class="mb-2">
                <label class="text-sm block mb-1">Stroke Width</label>
                <input type="number" id="style-stroke-width" class="w-full border px-2 py-1 rounded text-sm" />
            </div>
        </div>
    </section>


    <!-- ==================== CANVAS CONTAINER ==================== -->
    <div class="absolute top-40 left-4 right-4 bottom-4 rounded-lg overflow-auto">
        <div class="w-full h-full flex justify-center items-center">
            <canvas id="canvas" class="border rounded shadow-lg"></canvas>
        </div>
    </div>

    {{-- Kirim data desain ke JS jika sedang edit --}}
    <script>
        window.existingDesain = @json($desain ?? null);
    </script>
</body>

</html>
