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
        <div class="w-1/3 flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" class="w-[300px]">
        </div>
        <!-- Right -->
        <div class="w-2/3 pl-10">
            <h1 class="text-[64px] font-bold text-center text-blue-900 leading-none mt-5">
                MASUK
            </h1>
            <p class="text-sm text-center text-orange-500 tracking-widest font-bold m-0">MANAJEMEN STOK GUDANG</p>
            <form method="POST" action="/login" class="space-y-4 mt-4">
                @csrf
                <div>
                    <label class="block">Nama Pengguna</label>
                    <input type="text" name="username" placeholder="Silahkan masukan nama pengguna..."
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="block">Kata Sandi</label>
                    <input type="password" name="password" placeholder="Silahkan masukan kata sandi..."
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
                </div>
                <button type="submit"
                    class="w-full bg-gray-200 text-orange-500 py-2 rounded mt-2 hover:bg-blue-900 hover:text-white transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
