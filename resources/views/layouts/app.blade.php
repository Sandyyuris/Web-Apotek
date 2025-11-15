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
        }
        .navbar-brand .fa-pills {
            color: #1abc9c;
        }
        .footer {
            background-color: #2c3e50; /* Warna gelap untuk footer */
            color: white;
        }
        .category-nav .nav-link {
            color: #2c3e50; /* Warna teks kategori default */
            font-weight: bold;
            border-bottom: 3px solid transparent;
            transition: border-bottom 0.3s;
        }
        .category-nav .nav-link:hover, .category-nav .nav-link.active {
            color: #1abc9c;
            border-bottom: 3px solid #1abc9c;
        }
    </style>
</head>
<body class="app-bg">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('artikel.index') }}">
                <i class="fas fa-pills me-2"></i>
                APOTEK ARTIKEL
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Tombol Login/Masuk di kanan --}}
                    <li class="nav-item">
                        <a class="btn btn-primary main-bg fw-bold" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Apotek Artikel Web. Hak Cipta Dilindungi.</p>
            <p class="mb-0"><small>Dibuat dengan semangat hidup sehat.</small></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
