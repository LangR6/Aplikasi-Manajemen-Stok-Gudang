@props(['title' => ''])

@php
    $role = session('role');
    $nama = session('nama', 'Pengguna');

    $titleMap = [
        'Kelola Supplier' => 'Data Supplier',
        'Kelola Barang'   => 'Data Barang',
        'Kelola Kategori' => 'Data Kategori',
    ];
    $displayTitle = ($role === 'manager' && isset($titleMap[$title]))
        ? $titleMap[$title]
        : $title;
@endphp

<nav class="sticky top-0 z-20 flex items-center justify-between gap-3 bg-white px-4 py-3 shadow-sm sm:px-6">
    <div class="flex min-w-0 items-center gap-3">
        <button onclick="openSidebar()"
            class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EFEFEF] text-[#112B3C] transition hover:bg-gray-300 md:hidden"
            aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <h1 class="truncate text-xl font-semibold text-[#112B3C] sm:text-[18px]">
            {{ $displayTitle }}
        </h1>
    </div>

    <a href="{{ route('profile') }}" class="flex shrink-0 items-center gap-3 transition hover:opacity-80">

        <div class="hidden sm:flex flex-col leading-tight text-right">
            <span class="text-sm font-semibold text-[#112B3C]">
                {{ $nama }}
            </span>
            <span class="text-xs text-gray-500 capitalize">
                {{ $role ?? '-' }}
            </span>
        </div>

        <div class="flex h-9 w-9 items-center justify-center rounded-full text-white
            {{ $role === 'admin' ? 'bg-[#F66B0E]' : 'bg-[#112B3C]' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
        </div>

    </a>
</nav>