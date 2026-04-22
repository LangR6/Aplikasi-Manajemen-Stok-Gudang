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