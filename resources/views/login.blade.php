<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Stok Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white w-[850px] h-[420px] rounded shadow flex p-8">

    <!-- Left Box -->
    <div class="w-1/3 flex items-center justify-center">
        <img src="{{ asset('images/STOK GUDANG LOGO.png') }}" class="w-64">
    </div>

    <!-- Right Form -->
    <div class="w-2/3 pl-10">

        <h1 class="text-7xl text-blue-900 font-bold text-center m-2">MASUK</h1>
        <p class="text-sm text-orange-500 tracking-widest mb-8 text-center m-2">MANAJEMEN STOK GUDANG</p>

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-blue-900">Nama Pengguna</label>
                <input
                    type="text"
                    name="username"
                    placeholder="Silahkan masukan nama pengguna..."
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-gray-400"
                >
            </div>

            <div>
                <label class="text-sm text-blue-900">Kata Sandi</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Silahkan masukan kata sandi..."
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-gray-400"
                >
            </div>

            <button
                type="submit"
                class="w-full text-orange-500 bg-gray-200 hover:bg-blue-900 rounded py-2 mt-2">
                Masuk
            </button>

        </form>

    </div>

</div>

</body>
</html>
