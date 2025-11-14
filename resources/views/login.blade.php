@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center login-bg">
    <div class="col-lg-5 col-md-7 col-sm-10">
        <div class="card login-card p-4">
            <div class="card-body">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-primary mb-1" style="color: #1abc9c !important;">
                        <i class="fas fa-pills me-2"></i>
                        Sistem Apotek
                    </h2>
                    <p class="text-muted">Silakan masuk untuk mengelola inventaris dan transaksi.</p>
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
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Belum punya akun?
                            <a class="text-decoration-none fw-bold" href="{{ route('register') }}" style="color: #1abc9c;">Daftar Sekarang</a>
                        </p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold" style="background-color: #1abc9c; border-color: #1abc9c;">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            MASUK
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
