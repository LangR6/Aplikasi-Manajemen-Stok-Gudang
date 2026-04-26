@props(['title' => ''])

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

        <h1 class="truncate text-xl font-semibold text-[#112B3C] sm:text-[18px]">
            {{ $title }}
        </h1>
    </div>

    <a href="{{ route('profile') }}" class="flex shrink-0 items-center gap-2.5 transition hover:opacity-80">
        <span class="hidden text-sm text-[#444] sm:inline">
            {{ session('username') }}
        </span>
        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F66B0E] text-sm font-semibold text-white">
            {{ strtoupper(substr(session('username', 'U'), 0, 1)) }}
        </div>
    </a>
</nav>