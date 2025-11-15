@extends('layouts.app')

@section('title', 'Detail Artikel')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Tombol Kembali --}}
            <a href="{{ route('artikel.index') }}" class="text-decoration-none mb-3 d-inline-block main-color fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Artikel
            </a>

            <div class="card shadow-sm p-4">
                {{-- Judul Artikel --}}
                <h1 class="fw-bold main-color mb-3">Judul Artikel Sesuai Kategori (Contoh Detail)</h1>

                {{-- Info Penulis/Kategori --}}
                <div class="text-muted mb-4">
                    <span class="me-3"><i class="fas fa-user-edit me-1"></i> Oleh: Penulis Apotek</span>
                    <span class="me-3"><i class="fas fa-tag me-1"></i> Kategori: Obat</span>
                    <span><i class="fas fa-calendar-alt me-1"></i> Tanggal: 15 November 2025</span>
                </div>

                {{-- Gambar Utama --}}
                <img src="https://via.placeholder.com/800x450?text=Gambar+Utama+Artikel" class="img-fluid rounded mb-4 shadow-sm" alt="Gambar Utama">

                {{-- Isi Artikel (Lorem Ipsum) --}}
                <div class="article-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

                    <h3 class="fw-bold mt-4 mb-3 main-color">Sub Judul: Informasi Tambahan</h3>
                    <p>Curabitur sit amet feugiat sem, in euismod mi. Suspendisse potenti. Nam non elit vel sem elementum vestibulum. Aliquam erat volutpat. Nulla facilisi. Proin vel ex at sem tristique pharetra a in ex. Integer non ipsum sapien. Curabitur vel odio non urna eleifend maximus.</p>

                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle me-2 main-color"></i> Poin penting pertama tentang artikel.</li>
                        <li><i class="fas fa-check-circle me-2 main-color"></i> Poin penting kedua tentang topik terkait.</li>
                        <li><i class="fas fa-check-circle me-2 main-color"></i> Kesimpulan atau langkah selanjutnya.</li>
                    </ul>

                    <p>Donec porttitor interdum magna. Cras vel est ac libero tristique tristique. Sed ullamcorper ac ipsum quis efficitur. In non magna eget nulla sodales eleifend. Fusce vel lorem nec nisl consectetur aliquet a id purus. Vestibulum in finibus dolor, eu euismod nisi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
