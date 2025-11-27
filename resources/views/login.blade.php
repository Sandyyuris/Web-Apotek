@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center login-bg">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card login-card shadow-lg p-0" style="border-right: 6px solid #1abc9c; border-left: none; border-radius: 1rem;">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-flex justify-content-center align-items-center auth-image-container auth-image-container-bg auth-image-container-login">
                    <div style="position: absolute; color: white; text-align: center; padding: 20px;">
                        <i class="fas fa-prescription-bottle-alt fa-5x mb-3"></i>
                        <h3 class="fw-bold">Selamat Datang Kembali!</h3>
                        <p>Akses cepat ke semua fitur Apotek Web.</p>
                    </div>
                </div>

                <div class="col-md-7 auth-form-container">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary mb-1" style="color: #1abc9c !important;">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Masuk ke Sistem
                        </h2>
                        <p class="text-muted">Silakan masukkan username dan password akun Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Masukkan Username Anda">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan Password">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold btn-main-hover" style="background-color: #1abc9c; border-color: #1abc9c;">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                MASUK
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-muted">
                                Belum punya akun?
                                <a class="text-decoration-none fw-bold" href="{{ route('register') }}" style="color: #1abc9c;">Daftar Sekarang</a>
                            </p>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('artikel.index') }}" class="text-decoration-none fw-bold" style="color: #1abc9c;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>
@endsection
