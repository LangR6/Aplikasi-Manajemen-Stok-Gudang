<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Manajemen Stok Gudang</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="login-container">

        <div class="left-box">
            <img src="{{ asset('images/STOK GUDANG LOGO.png') }}" class="logo">
        </div>

        <div class="right-box">

            <h1 class="title">MASUK</h1>
            <p class="subtitle">MANAJEMEN STOK GUDANG</p>

            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <div>
                    <label>Nama Pengguna</label>
                    <input type="text" name="username" placeholder="Silahkan masukan nama pengguna..."
                        class="input">
                </div>

                <div>
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="Silahkan masukan kata sandi..." class="input">
                </div>

                <button type="submit" class="button">
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>

</html>
