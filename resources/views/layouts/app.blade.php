<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-black/50 backdrop-blur-[2px] md:hidden"
        onclick="closeSidebar()"></div>

    <!-- Blade Components -->
    <x-sidebar />

    <div class="min-h-screen md:ml-56">
        <x-navbar :title="View::yieldContent('title')" />



        <main class="p-4 sm:p-5 mt-12">
            @yield('content')
        </main>


    </div>

    <x-logout-modal />
    <x-success-modal />

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

    <div x-data="{
    show: false,
    namaBarang: '',
    sisaStok: 0,
    _hideTimer: null,

    init() {
        const role = '{{ session('role') }}';
        const username = '{{ session('username') }}';

        window.Echo.channel('gudang-notification.role.' + role)
            .listen('.stok.menipis', (data) => {
                // skip kalau yang menerima adalah pelaku aksi itu sendiri
                if (data.pelaku === username) return;

                this.namaBarang = data.nama_barang;
                this.sisaStok = data.sisa_stok;
                this.show = true;

                clearTimeout(this._hideTimer);
                this._hideTimer = setTimeout(() => this.show = false, 5000);
            });
        }
    }" class="fixed top-4 right-4 z-[9999]">
        <div x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="flex items-start gap-3 bg-orange-50 border-l-4 border-red-500 text-red-700 shadow-lg rounded-lg p-4 w-80">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <p class="font-semibold text-red-800">Stok Menipis!</p>
                <p class="text-sm">
                    <span x-text="namaBarang"></span> tersisa
                    <span x-text="sisaStok" class="font-bold"></span> pcs
                </p>
            </div>
            <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">✕</button>
        </div>
    </div>
</body>

</html>