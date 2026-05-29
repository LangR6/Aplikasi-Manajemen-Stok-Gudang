<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Stok Gudang</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.85); }
            to   { opacity: 1; transform: scale(1); }
        }

        .animate-fade-in {
            animation: fadeInScale 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    {{-- MODAL LOGIN BERHASIL --}}
    @if (session('login_success'))
    <div id="modalSuccess"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl px-8 py-8 flex flex-col items-center gap-4 w-[300px] animate-fade-in">

            {{-- Icon Centang --}}
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- Teks --}}
            <div class="text-center">
                <h2 class="text-lg font-bold text-[#112B3C]">Login Berhasil!</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Selamat datang,
                    <span class="font-medium text-orange-500">{{ session('nama') }}</span>
                </p>
            </div>

            {{-- Loading bar --}}
            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                <div id="loadingBar"
                    class="h-1.5 bg-orange-500 rounded-full w-0 transition-all duration-[2000ms] ease-linear">
                </div>
            </div>

            <p class="text-xs text-gray-400">Mengalihkan halaman...</p>

        </div>
    </div>
    @endif

    <div class="
        bg-white
        w-full
        lg:w-[850px] lg:h-[420px]
        rounded-xl
        flex flex-col md:flex-row lg:flex
        p-4 md:p-6 lg:p-8
        shadow-[0_10px_30px_rgba(0,0,0,0.08)]
        border border-gray-100
    ">

        <!-- LEFT IMAGE -->
        <div class="w-full md:w-1/3 h-48 md:h-auto">
            <img
                src="{{ asset('images/Gudang.jpg') }}"
                class="w-full h-full object-cover rounded-lg"
            >
        </div>

        <!-- RIGHT FORM -->
        <div class="w-full md:w-2/3 md:pl-6 lg:pl-10 flex flex-col justify-center">

            <!-- TITLE -->
            <h1 class="
                text-3xl
                md:text-5xl
                lg:text-[64px]
                font-bold
                text-center
                text-blue-900
                leading-none
                mt-2
            ">
                MASUK
            </h1>

            <p class="
                text-xs
                md:text-sm
                text-center
                text-orange-500
                tracking-widest
                font-semibold
                mb-4
            ">
                MANAJEMEN STOK GUDANG
            </p>

            <!-- ERROR MESSAGE -->
            @if (session('error'))
            <div
                id="toast-danger"
                class="
                    fixed
                    top-5
                    right-5
                    z-50
                    flex
                    items-center
                    w-full
                    max-w-xs
                    p-4
                    text-gray-500
                    bg-white
                    rounded-lg
                    shadow
                    transition-opacity
                    duration-500
                "
            >
                <div class="
                    inline-flex
                    items-center
                    justify-center
                    w-8
                    h-8
                    text-red-500
                    bg-red-100
                    rounded-lg
                ">
                    ❌
                </div>
                <div class="ms-3 text-sm">
                    {{ session('error') }}
                </div>
            </div>
            @endif

            <!-- LOGIN FORM -->
            <form
                method="POST"
                action="{{ route('loginaction') }}"
                class="space-y-4"
            >

                @csrf

                <!-- USERNAME -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Pengguna
                    </label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Silahkan masukan nama pengguna..."
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            focus:ring-2
                            focus:ring-orange-500
                            focus:border-orange-500
                            outline-none
                            transition
                        "
                    >
                    @error('username')
                        <p class="text-red-500 text-xs leading-tight">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Silahkan masukan kata sandi..."
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            focus:ring-2
                            focus:ring-orange-500
                            focus:border-orange-500
                            outline-none
                            transition
                        "
                    >
                    @error('password')
                        <p class="text-red-500 text-xs leading-tight">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="
                        w-full
                        bg-blue-900
                        text-white
                        py-2.5
                        rounded-lg
                        mt-2
                        hover:bg-blue-950
                        hover:shadow-md
                        active:scale-[0.98]
                        transition
                        duration-300
                    "
                >
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>

<script>
    // ===== TOAST ERROR AUTO HIDE =====
    setTimeout(() => {
        const toast = document.getElementById('toast-danger');
        if (toast) {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);

    // ===== MODAL LOGIN BERHASIL =====
    const modal = document.getElementById('modalSuccess');
    if (modal) {
        // Jalankan loading bar
        setTimeout(() => {
            document.getElementById('loadingBar').style.width = '100%';
        }, 100);

        // Redirect ke dashboard setelah 2.3 detik
        setTimeout(() => {
            window.location.href = "{{ route('dashboard') }}";
        }, 2300);
    }
</script>

</html>
