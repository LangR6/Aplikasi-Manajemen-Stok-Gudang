<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Stok Gudang</title>
    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white w-[850px] h-[420px] rounded-md flex p-8 shadow-lg">
        <!-- Left -->
        <div class="w-1/3">
            <img src="{{ asset('images/Gudang.jpg') }}"
        class="w-full h-full object-cover rounded-md">
        </div>
        <!-- Right -->
        <div class="w-2/3 pl-10">
            <h1 class="text-[64px] font-bold text-center text-blue-900 leading-none mt-5">
                MASUK
            </h1>
            <p class="text-sm text-center text-orange-500 tracking-widest font-bold m-0">MANAJEMEN STOK GUDANG</p>

            @if (session('error'))
                <div id="toast-danger"
                    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow"
                    role="alert">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                        ❌
                    </div>
                    <div class="ms-3 text-sm font-normal">
                        {{ session('error') }}
                    </div>
                    <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5"
                        data-dismiss-target="#toast-danger">
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('loginaction') }}" class="space-y-4 mt-4">
                @method('POST')
                @csrf
                <div>
                    <label class="block">Nama Pengguna</label>
                    <input type="text" name="username" placeholder="Silahkan masukan nama pengguna..."
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">Username wajib diisi</p>
                    @enderror
                    <div>
                        <label class="block">Kata Sandi</label>
                        <input type="password" name="password" placeholder="Silahkan masukan kata sandi..."
                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">Kata sandi wajib diisi</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-orange-500 text-white py-2 rounded mt-2
           hover:bg-blue-900 transition duration-300">
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
