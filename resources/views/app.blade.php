<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-[#EFEFEF] font-[Poppins]">

    @if (!session('role'))
        <script>
            window.location.href = "{{ route('login') }}";
        </script>
    @endif

    <!-- Overlay Sidebar Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-black/50 backdrop-blur-[2px] md:hidden"
        onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 flex h-screen w-56 -translate-x-full flex-col overflow-y-auto bg-[#205375] px-3.5 py-5 text-white shadow-[4px_0_20px_rgba(0,0,0,0.15)] transition-transform duration-300 md:translate-x-0">

        <!-- Logo -->
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-20 w-20 object-contain">
        </div>

        <!-- Menu -->
        <ul class="flex flex-1 flex-col gap-1">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm transition-all duration-200
                   {{ request()->is('dashboard')
                       ? 'bg-[#F66B0E] text-white font-medium'
                       : 'text-white hover:bg-[#F66B0E] hover:text-white hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10l9-7 9 7v9a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('kelola_supplier') }}"
                    class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm transition-all duration-200
                   {{ request()->is('kelola_supplier*')
                       ? 'bg-[#F66B0E] text-white font-medium'
                       : 'text-white hover:bg-[#F66B0E] hover:text-white hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17H6a2 2 0 01-2-2V7a2 2 0 012-2h9v12m0 0h2m-2 0a2 2 0 104 0m-4 0a2 2 0 11-4 0" />
                    </svg>
                    Kelola Supplier
                </a>
            </li>

            <li>
                <a href="{{ route('kelola_barang') }}"
                    class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm transition-all duration-200
                   {{ request()->is('kelola_barang*')
                       ? 'bg-[#F66B0E] text-white font-medium'
                       : 'text-white hover:bg-[#F66B0E] hover:text-white hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
                    </svg>
                    Kelola Barang
                </a>
            </li>

            <li>
                <a href="{{ route('kelola_kategori') }}"
                    class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm transition-all duration-200
                   {{ request()->is('kategori*')
                       ? 'bg-[#F66B0E] text-white font-medium'
                       : 'text-white hover:bg-[#F66B0E] hover:text-white hover:translate-x-1' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h10M7 12h10M7 17h10M4 7h.01M4 12h.01M4 17h.01" />
                    </svg>
                    Kelola Kategori
                </a>
            </li>

                <li>
                    <a href="{{ route('riwayat') }}"
                        class="flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-sm transition-all duration-200
                       {{ request()->is('riwayat*')
                           ? 'bg-[#F66B0E] text-white font-medium'
                           : 'text-white hover:bg-[#F66B0E] hover:text-white hover:translate-x-1' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat
                    </a>
                </li>
        </ul>

        <!-- Logout Button -->
        <button onclick="openLogoutModal()"
            class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-[#112B3C] px-4 py-2.5 text-sm text-white transition hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m16 17 5-5-5-5" />
                <path d="M21 12H9" />
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            </svg>
            Keluar
        </button>
    </aside>

    <!-- Main Wrapper -->
    <div class="min-h-screen md:ml-56">
        <!-- Navbar -->
        <nav class="sticky top-0 z-20 flex items-center justify-between gap-3 bg-white px-4 py-3 shadow-sm sm:px-6">
            <div class="flex min-w-0 items-center gap-3">
                <button onclick="openSidebar()"
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EFEFEF] text-[#112B3C] transition hover:bg-gray-300 md:hidden"
                    aria-label="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h1 class="truncate text-xl font-semibold text-[#112B3C] sm:text-[17px]">
                    @yield('title')
                </h1>
            </div>

            <a href="{{ route('profile') }}" class="flex shrink-0 items-center gap-2.5 transition hover:opacity-80">
                <span class="hidden text-sm text-[#444] sm:inline">
                    {{ session('username') }}
                </span>
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F66B0E] text-sm font-semibold text-white">
                    {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
                </div>
            </a>
        </nav>

        <!-- Content -->
        <main class="p-4 sm:p-5">
            @yield('content')
        </main>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-[2px]">
        <div class="w-full max-w-md scale-95 rounded-2xl bg-white p-8 text-center shadow-2xl transition-all duration-200"
            id="logoutModalCard">

            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.07 12.25A2 2 0 0 0 5.22 19h13.56a2 2 0 0 0 1.73-2.99L13.71 3.86a2 2 0 0 0-3.42 0z" />
                </svg>
            </div>

            <h2 class="mb-2 text-lg font-semibold text-[#112B3C]">Konfirmasi Logout</h2>
            <p class="mb-6 text-sm text-gray-500">Apakah kamu yakin ingin keluar dari sistem?</p>

            <div class="flex gap-3">
                <button onclick="closeLogoutModal()"
                    class="flex-1 rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-[#F66B0E] hover:text-white">
                    Batal
                </button>

                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:scale-[1.02] hover:bg-red-700">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const logoutModal = document.getElementById('logoutModal');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openLogoutModal() {
        logoutModal.classList.remove('hidden');
        logoutModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeLogoutModal() {
        logoutModal.classList.add('hidden');
        logoutModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    logoutModal.addEventListener('click', function(e) {
        if (e.target === logoutModal) closeLogoutModal();
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            closeSidebar();
        }
    });
</script>

@stack('modals')
@stack('scripts')
</body>

</html>
