@if (session('success'))
    <div id="successModal"
        style="position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.3);">
        <div class="bg-white rounded-2xl px-8 py-7 flex flex-col items-center gap-3 shadow-xl max-w-xs w-full mx-4">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 text-center">{{ session('success') }}</p>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.opacity = '0';
                modal.style.transition = 'opacity 0.3s';
                setTimeout(() => modal.remove(), 300);
            }
        }, 2000);
    </script>
@endif

@if (session('error'))
    <div id="errorModal"
        style="position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.3);">
        <div class="bg-white rounded-2xl px-8 py-7 flex flex-col items-center gap-3 shadow-xl max-w-xs w-full mx-4">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 text-center">
                {{ session('error') }}
            </p>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const modal = document.getElementById('errorModal');
            if (modal) {
                modal.style.opacity = '0';
                modal.style.transition = 'opacity 0.3s';
                setTimeout(() => modal.remove(), 300);
            }
        }, 2000);
    </script>
@endif

@if ($errors->any())
    <div id="validasiModal"
        style="position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.3);">
        <div class="bg-white rounded-2xl px-8 py-7 flex flex-col items-center gap-3 shadow-xl max-w-xs w-full mx-4">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 text-center">Validasi Gagal!</p>
            <ul class="text-sm text-gray-600 text-center list-none space-y-1 w-full">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="document.getElementById('validasiModal').remove()"
                class="mt-1 px-5 py-1.5 rounded-lg text-xs font-medium bg-red-500 hover:bg-red-600 text-white transition-all duration-200">
                OK
            </button>
        </div>
    </div>
@endif
