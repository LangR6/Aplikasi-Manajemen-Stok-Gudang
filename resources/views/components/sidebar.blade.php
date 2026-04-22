<aside id="sidebar"
    class="fixed top-0 left-0 z-40 flex h-screen w-56 -translate-x-full flex-col overflow-y-auto bg-[#205375] px-3.5 py-5 text-white shadow-[4px_0_20px_rgba(0,0,0,0.15)] transition-transform duration-300 md:translate-x-0">

    <div class="mb-6 flex justify-center">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-20 w-20 object-contain">
    </div>

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

        @if (session('role') === 'admin')
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
        @endif
    </ul>

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