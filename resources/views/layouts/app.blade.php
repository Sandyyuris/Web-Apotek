<?php
// sandyyuris/web-apotek/Web-Apotek-76618f6dd49995b1c531bdb0b4ef886e26e1c55d/resources/views/layouts/app.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Apotek Web - Artikel Kesehatan')</title>
    {{-- Menggunakan link Bootstrap dan Font Awesome dari layout auth --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Gaya kustom untuk konsistensi tema */
        .app-bg {
            background-color: #f0f2f5; /* Latar belakang abu-abu muda yang bersih, diambil dari login-bg */
            min-height: 100vh;
        }
        .main-color {
            color: #1abc9c !important; /* Warna aksen utama */
        }
        .main-bg {
            background-color: #1abc9c !important;
            border-color: #1abc9c !important;
        }
        .card-hover:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            border-bottom: #1abc9c 4px solid !important;
            border-right: #1abc9c 4px solid !important;
        }

        /* === Penyesuaian Navbar Baru === */
        .navbar-brand {
            color: white !important;
            margin-right: 1.5rem !important;
            margin-left: 1.5rem !important;
        }
        .navbar-brand .fa-pills {
            color: white;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85); /* Warna teks link default (putih agak pudar) */
            transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        .navbar-nav .nav-link:hover {
            color: white;
            font-weight: bold;
        }

        /* Gaya untuk Tautan Aktif */
        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: bold;
            border-bottom: 3px solid white;
            padding-bottom: 8px;
            /* background-color: rgba(0, 0, 0, 0.1); */
            border-radius: 4px 4px 0 0;
        }

        /* ============================== */

        .footer {
            background-color: #2c3e50; /* Warna gelap untuk footer */
            color: white;
        }
        .category-nav {
            background-color: transparent;

        }
        .category-nav .nav-link {
            color: #2c3e50;
            font-weight: bold;
            border-bottom: 3px solid transparent;
            transition: border-bottom 0.3s;
            background-color: white !important;
            margin-right: 15px;
            margin-left: 15px;
            border-radius: 20px;


        }
        .category-nav .nav-link:hover, .category-nav .nav-link.active {
            color: #1abc9c;
            border-bottom: 3px solid #1abc9c;
            border-right: 3px solid #1abc9c;
            /* background-color: transparent !important; */
        }
    </style>
</head>
<body class="app-bg">

    {{-- Navbar --}}
    @include('components.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
