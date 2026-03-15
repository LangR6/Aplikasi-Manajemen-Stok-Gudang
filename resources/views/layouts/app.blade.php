<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="container">

        @include('layouts.sidebar')

        <div class="main">

            @include('layouts.navbar')

            <div class="content">

                @yield('content')

            </div>

        </div>

    </div>

</body>

</html>