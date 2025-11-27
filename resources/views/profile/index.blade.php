@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-id-card-alt me-2"></i>
                            Informasi Profil
                        </h2>
                        <p class="text-muted">Kelola detail akun Anda.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Lengkap</div>
                        <div class="col-md-8">: {{ $user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Username</div>
                        <div class="col-md-8">: {{ $user->username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nomor Telepon</div>
                        <div class="col-md-8">: {{ $user->nomor_telp ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Peran (Role)</div>
                        <div class="col-md-8">: {{ $user->role->nama_role ?? 'Tidak Diketahui' }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">Akun Dibuat</div>
                        <div class="col-md-8">: {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y H:i') }}</div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn main-bg text-white btn-lg fw-bold">
                            <i class="fas fa-user-edit me-2"></i>
                            EDIT PROFIL
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
