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
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

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

        <!-- Left -->
        <div class="w-full md:w-1/3 h-48 md:h-auto">
            <img src="{{ asset('images/Gudang.jpg') }}"
                class="w-full h-full object-cover rounded-lg">
        </div>

        <!-- Right -->
        <div class="w-full md:w-2/3 md:pl-6 lg:pl-10 flex flex-col justify-center">

            <h1 class="text-3xl md:text-5xl lg:text-[64px] font-bold text-center text-blue-900 leading-none mt-2">
                MASUK
            </h1>

            <p class="text-xs md:text-sm text-center text-orange-500 tracking-widest font-semibold mb-4">
                MANAJEMEN STOK GUDANG
            </p>

            @if (session('error'))
                <div id="toast-danger"
                    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow">
                    <div class="inline-flex items-center justify-center w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                        ❌
                    </div>
                    <div class="ms-3 text-sm">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('loginaction') }}" class="space-y-4">
                @method('POST')
                @csrf

                <!-- Username -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                    <input type="text" name="username"
                        placeholder="Silahkan masukan nama pengguna..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-1
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">

                    @error('username')
                        <p class="text-red-500 text-xs leading-tight">
                            Username wajib diisi
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" name="password"
                        placeholder="Silahkan masukan kata sandi..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-1
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">

                    @error('password')
                        <p class="text-red-500 text-xs leading-tight">
                            Kata sandi wajib diisi
                        </p>
                    @enderror
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-blue-900 text-white py-2.5 rounded-lg mt-2
                    hover:bg-blue-950 hover:shadow-md active:scale-[0.98]
                    transition duration-300">
                    Masuk
                </button>

            </form>
        </div>
    </div>

</body>

<script>
    setTimeout(() => {
        const toast = document.getElementById('toast-danger');
        if (toast) {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>

</html>