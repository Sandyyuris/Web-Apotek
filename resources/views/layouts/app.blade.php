<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Apotek Web - Artikel Kesehatan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .app-bg {
            background: linear-gradient(rgba(240, 242, 245, 0.8), rgba(240, 242, 245, 0.8)),
                        url('https://res.cloudinary.com/dklm74kwy/image/upload/v1764092233/background_hyocid.avif');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .main-color {
            color: #1abc9c !important;
        }
        .main-bg {
            background-color: #1abc9c !important;
            border-color: #1abc9c !important;
        }
        .card {
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            border-bottom: #1abc9c 4px solid !important;
            border-right: #1abc9c 4px solid !important;
        }
        .navbar-brand {
            color: white !important;
            margin-right: 1.5rem !important;
            margin-left: 1.5rem !important;
        }
        .navbar-brand .fa-pills {
            color: white;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            transition: color 0.3s ease-in-out, background-color 0.3s ease-in-out;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        .navbar-nav .nav-link:hover {
            color: white;
            font-weight: bold;
        }
        .navbar-nav .nav-link.active {
            color: white !important;
            font-weight: bold;
            border-bottom: 3px solid white;
            padding-bottom: 8px;
            border-radius: 4px 4px 0 0;
        }
        .footer {
            background-color: #2c3e50;
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
            border-radius: 15px;
        }
        .category-nav .nav-link:hover, .category-nav .nav-link.active {
            color: #1abc9c;
            border-bottom: 3px solid #1abc9c;
            border-right: 3px solid #1abc9c;
        }
        .floating-action-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 56px;
            height: 56px;
            line-height: 48px;
            padding: 0 !important;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.5);
        }
    </style>
</head>
<body class="app-bg">

    @include('components.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Konfigurasi Toast (Notifikasi kecil di pojok kanan atas)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Menangkap Session Success dari Laravel
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1abc9c'
            });
        @endif

        // Menangkap Session Error dari Laravel
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        @endif

        // Menangkap Validasi Error (Jika ada error input form)
        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#1abc9c'
            });
        @endif
    </script>

    @yield('scripts')
</body>
</html>
    @yield('scripts')
</body>
</html>
