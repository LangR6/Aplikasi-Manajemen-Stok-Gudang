<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif;}
    </style>
</head>

<body>
    <div class="flex">

        <!-- SIDEBAR -->
        <div class="fixed top-0 left-0 w-56 h-screen bg-white border-r p-6 shadow-xl overflow-y-auto">

            <!-- LOGO -->
            <div class="flex justify-center mb-5">
                <img src="{{ asset('images/logo1.png') }}" class="w-20">
            </div>

            <!-- MENU -->
            <ul class="space-y-2 text-gray-600 text-[15px]">

                <!-- BERANDA -->
                <li>
                    <a href="#"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 hover:translate-x-1 transition group
                        {{ request()->is('/') ? 'bg-orange-50 border-l-4 border-orange-500 font-medium text-orange-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10l9-7 9 7v9a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z"/>
                        </svg>
                        <span class="group-hover:text-orange-500">Beranda</span>
                    </a>
                </li>

                <!-- SUPPLIER -->
                <li>
                    <a href="#"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 hover:translate-x-1 transition group
                        {{ request()->is('kelola_supplier*') ? 'bg-orange-50 border-l-4 border-orange-500 font-medium text-orange-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17H6a2 2 0 01-2-2V7a2 2 0 012-2h9v12m0 0h2m-2 0a2 2 0 104 0m-4 0a2 2 0 11-4 0"/>
                        </svg>
                        <span class="group-hover:text-orange-500">Kelola Supplier</span>
                    </a>
                </li>

                <!-- BARANG -->
                <li>
                    <a href="{{ route('kelola_barang') }}"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 hover:translate-x-1 transition group
                        {{ request()->is('kelola_barang*') ? 'bg-orange-50 border-l-4 border-orange-500 font-medium text-orange-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 group-hover:text-orange-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4"/>
                        </svg>
                        <span class="group-hover:text-orange-500">Kelola Barang</span>
                    </a>
                </li>

                <!-- KATEGORI -->
                <li>
                    <a href="#"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 hover:translate-x-1 transition group
                        {{ request()->is('kategori*') ? 'bg-orange-50 border-l-4 border-orange-500 font-medium text-orange-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 group-hover:text-orange-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h10M7 12h10M7 17h10M4 7h.01M4 12h.01M4 17h.01"/>
                        </svg>
                        <span class="group-hover:text-orange-500">Kelola Kategori</span>
                    </a>
                </li>

                <!-- RIWAYAT -->
                <li>
                    <a href="#"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 hover:translate-x-1 transition group
                        {{ request()->is('riwayat*') ? 'bg-orange-50 border-l-4 border-orange-500 font-medium text-orange-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 group-hover:text-orange-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="group-hover:text-orange-500">Riwayat</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- MAIN CONTENT -->
        <div class="ml-56 w-full">

            <!-- NAVBAR -->
            <div class="sticky top-0 z-50 bg-white flex justify-between items-center px-6 py-4 shadow-md">
                <h1 class="text-xl font-semibold">@yield('title')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-gray-700">Admin 1</span>
                    <div class="w-9 h-9 border rounded-full bg-amber-600"></div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
</body>

</html>