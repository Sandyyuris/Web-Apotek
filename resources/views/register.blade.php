@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center login-bg">
    <div class="col-lg-5 col-md-7 col-sm-10">
        <div class="card login-card p-4">
            <div class="card-body">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-primary mb-1" style="color: #1abc9c !important;">
                        <i class="fas fa-user-plus me-2"></i>
                        Daftar Akun Baru
                    </h2>
                    <p class="text-muted">Isi formulir untuk membuat akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan Nama Anda">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Buat Username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- BARU: Input Nomor Telepon --}}
                    <div class="mb-3">
                        <label for="nomor_telp" class="form-label fw-bold">Nomor Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input id="nomor_telp" type="text" class="form-control @error('nomor_telp') is-invalid @enderror" name="nomor_telp" value="{{ old('nomor_telp') }}" required placeholder="Contoh: 081234567890">
                            @error('nomor_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- END BARU --}}

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Min. 8 Karakter">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label fw-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Password">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold" style="background-color: #1abc9c; border-color: #1abc9c;">
                            <i class="fas fa-save me-2"></i>
                            DAFTAR
                        </button>
                    </div>

                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        Sudah punya akun?
                        <a class="text-decoration-none fw-bold" href="{{ route('login') }}" style="color: #1abc9c;">Masuk Di Sini</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
