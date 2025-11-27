@extends('layouts.app')

@section('title', $article->judul)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('artikel.index') }}" class="text-decoration-none mb-3 d-inline-block main-color fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Artikel
            </a>

            <div class="card shadow-sm p-4">
                <h1 class="fw-bold main-color mb-3">{{ $article->judul }}</h1>

                <div class="text-muted mb-4">
                    <span class="me-3"><i class="fas fa-user-edit me-1"></i> Oleh: Penulis Apotek</span>
                    <span class="me-3"><i class="fas fa-tag me-1"></i> Kategori: {{ $article->kategoriArtikel->nama_kategori }}</span>
                    <span><i class="fas fa-calendar-alt me-1"></i> Tanggal: {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</span>
                </div>

                <img src="{{ $article->path_foto ? $article->path_foto : 'https://via.placeholder.com/800x450?text=Gambar+Utama+Artikel' }}" class="img-fluid rounded mb-4 shadow-sm" alt="{{ $article->judul }}">

                <div class="article-content">
                    <p>{!! nl2br(e($article->isi)) !!}</p>

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
