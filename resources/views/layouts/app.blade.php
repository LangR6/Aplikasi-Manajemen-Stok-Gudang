<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Manajemen Stok Gudang')</title>

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
    <div id="sidebarOverlay"
        class="fixed inset-0 z-30 hidden bg-black/50 backdrop-blur-[2px] md:hidden"
        onclick="closeSidebar()"></div>

    <!-- Blade Components -->
    <x-sidebar />

    <div class="min-h-screen md:ml-56">
        <x-navbar :title="View::yieldContent('title')" />

        <main class="p-4 sm:p-5">
            @yield('content')
        </main>
    </div>

    <x-logout-modal />

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

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

        if (logoutModal) {
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) closeLogoutModal();
            });
        }

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
