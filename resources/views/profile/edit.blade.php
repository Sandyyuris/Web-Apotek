@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-user-edit me-2"></i>
                            Formulir Edit Profil
                        </h2>
                        <p class="text-muted">Kosongkan kolom password jika tidak ingin diubah.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required placeholder="Masukkan Nama Anda">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username" placeholder="Buat Username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nomor_telp" class="form-label fw-bold">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input id="nomor_telp" type="text" class="form-control @error('nomor_telp') is-invalid @enderror" name="nomor_telp" value="{{ old('nomor_telp', $user->nomor_telp) }}" required placeholder="Contoh: 081234567890">
                                @error('nomor_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kosongkan jika tidak ingin diubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Password Baru">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn main-bg text-white btn-lg fw-bold">
                                <i class="fas fa-save me-2"></i>
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.index') }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
