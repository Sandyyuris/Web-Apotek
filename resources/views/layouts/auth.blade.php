<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Apotek Anda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .login-bg {
            background: linear-gradient(rgba(240, 242, 245, 0.8), rgba(240, 242, 245, 0.8)),
                        url('https://res.cloudinary.com/dklm74kwy/image/upload/v1764092233/background_hyocid.avif');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .auth-image-container {
            position: relative;
        }
        .auth-image-container-bg {
            background: linear-gradient(rgba(26, 188, 156, 0.85), rgba(26, 188, 156, 0.85)),
                        url('https://res.cloudinary.com/dklm74kwy/image/upload/v1764092233/background_hyocid.avif') center center / cover;
        }
        .auth-image-container-login {
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }
        .auth-image-container-register {
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }
        .auth-form-container {
            padding: 2rem;
        }
        .btn-main-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(26, 188, 156, 0.5);
            background-color: #148f77 !important;
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body class="login-bg">
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
