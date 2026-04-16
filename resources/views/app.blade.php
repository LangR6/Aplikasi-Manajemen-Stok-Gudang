<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.25s ease-out;
        }
    </style>
</head>

<body>
    <div>

        <!-- SIDEBAR -->
        <div class="fixed top-0 left-0 w-56 h-screen bg-blue-900 text-white p-6 shadow-xl overflow-y-auto">
            <div class="w-full h-full relative">

                <!-- LOGO -->
                <div class="flex justify-center mb-5">
                    <img src="{{ asset('images/logo1.png') }}" class="w-20">
                </div>

                <!-- MENU -->
                <ul class="space-y-2 text-blue-100 text-[15px]">

                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-500 hover:text-white hover:translate-x-1 transition-all duration-300
                            {{ request()->is('/') ? 'bg-orange-500 text-white font-medium shadow-md' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('kelola_supplier') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-500 hover:text-white hover:translate-x-1 transition-all duration-300
                            {{ request()->is('kelola_supplier*') ? 'bg-orange-500 text-white font-medium shadow-md' : '' }}">
                            Kelola Supplier
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('kelola_barang') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-500 hover:text-white hover:translate-x-1 transition-all duration-300
                            {{ request()->is('kelola_barang*') ? 'bg-orange-500 text-white font-medium shadow-md' : '' }}">
                            Kelola Barang
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('kelola_kategori') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-500 hover:text-white hover:translate-x-1 transition-all duration-300
                            {{ request()->is('kategori*') ? 'bg-orange-500 text-white font-medium shadow-md' : '' }}">
                            Kelola Kategori
                        </a>
                    </li>

                    @if (session()->get('role') == 'admin')
                        <li>
                            <a href="{{ route('riwayat') }}"
                                class="flex items-center gap-3 p-3 rounded-lg hover:bg-orange-500 hover:text-white hover:translate-x-1 transition-all duration-300
                                {{ request()->is('riwayat*') ? 'bg-orange-500 text-white font-medium shadow-md' : '' }}">
                                Riwayat
                            </a>
                        </li>
                    @endif

                </ul>

                <!-- LOGOUT -->
                <div class="absolute bottom-0 w-full">
                    <button onclick="openLogoutModal()"
                        class="w-full flex items-center justify-center gap-2
                        bg-red-600 text-white rounded-lg p-2
                        hover:bg-red-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        </svg>
                        Keluar
                    </button>
                </div>

            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="ml-56">

            <!-- NAVBAR -->
            <div class="sticky top-0 z-30 bg-white flex justify-between items-center px-6 py-4 shadow-md">
                <h1 class="text-xl font-semibold">@yield('title')</h1>

                <a href="{{ route('profile') }}" class="flex items-center gap-3 hover:opacity-75 transition">
                    <span class="text-gray-700">Admin 1</span>
                    <div class="w-9 h-9 rounded-full bg-orange-500"></div>
                </a>
            </div>

            <!-- CONTENT -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>

    </div>

    <!-- MODAL LOGOUT -->
    <div id="logoutModal"
        class="fixed inset-0 hidden items-center justify-center z-50
        bg-black/50 backdrop-blur-md transition-all duration-300">

        <div
            class="bg-white rounded-2xl
            shadow-[0_40px_100px_rgba(0,0,0,0.5)]
            w-150 p-10 text-center animate-fadeIn">

            <!-- ICON -->
            <div class="flex justify-center mb-2 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-600" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.07 12.25A2 2 0 0 0 5.22 19h13.56a2 2 0 0 0 1.73-2.99L13.71 3.86a2 2 0 0 0-3.42 0z" />
                </svg>
            </div>

            <!-- TEXT -->
            <h2 class="text-2xl font-semibold mb-2 text-gray-800">
                Konfirmasi Logout
            </h2>
            <p class="text-gray-500 mb-4">
                Apakah kamu yakin ingin keluar dari sistem?
            </p>

            <!-- BUTTON -->
            <div class="flex gap-4">

                <!-- BATAL -->
                <button onclick="closeLogoutModal()"
                    class="w-full py-2 px-4 rounded-lg bg-gray-200
                    hover:bg-orange-500 hover:text-white
                    transform hover:scale-105 active:scale-95
                    shadow-sm hover:shadow-md
                    transition-all duration-300 ease-in-out">
                    Batal
                </button>

                <!-- KELUAR -->
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-lg bg-red-600 text-white
                        hover:bg-red-700
                        transform hover:scale-105 active:scale-95
                        shadow-sm hover:shadow-lg
                        transition-all duration-300 ease-in-out">
                        Keluar
                    </button>
                </form>

            </div>

        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // klik luar modal = close
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>

    @stack('styles')
    @stack('modals')
    @stack('scripts')

</body>

</html>
