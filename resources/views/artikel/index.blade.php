@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
<div class="container-fluid">
    {{-- Pilihan Kategori di bawah Navbar --}}
    @php
        // Ambil kategori aktif dari controller (variabel 'kategori'). Jika null, anggap 'Semua Artikel'.
        $activeKategori = $kategori ?? 'Semua Artikel';

        // Definisikan kategori yang tersedia (sesuai data seeder: 'Obat', 'Tips Hidup Sehat')
        $categories = ['Semua Artikel', 'Obat', 'Tips Hidup Sehat'];
    @endphp

    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill category-nav">
                @foreach ($categories as $cat)
                    @php
                        $url = route('artikel.index');
                        if ($cat !== 'Semua Artikel') {
                            $url = route('artikel.index', ['kategori' => $cat]);
                        }
                        $isActive = ($activeKategori === $cat);
                    @endphp
                    <li class="nav-item me-3"> {{-- Tambahkan wrapper li.nav-item --}}
                        <a class="nav-link {{ $isActive ? 'active' : '' }}"
                            aria-current="{{ $isActive ? 'page' : '' }}"
                            href="{{ $url }}">
                            {{ $cat }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Daftar Artikel (Grid 3 kolom) --}}
    <div class="row">
        {{-- Perulangan kini menggunakan data dari database yang dikirim oleh Controller --}}
        @forelse ($articles as $article)
        <div class="col-md-3 mb-4">
            {{-- Menggunakan Str::slug dari Illuminate\Support\Str untuk URL yang bersih --}}
            <a href="{{ route('artikel.detail', ['id' => $article->id_artikel, 'slug' => Illuminate\Support\Str::slug($article->judul)]) }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 card">
                    {{-- Gambar: Menggunakan path_foto dari database. Jika null, gunakan placeholder. --}}
                    <img src="{{ $article->path_foto ?? 'https://via.placeholder.com/400x250?text=Apotek+Artikel' }}" class="card-img-top" alt="{{ $article->judul }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        {{-- Badge Kategori --}}
                        <span class="badge bg-opacity-75 mb-2 fw-bold" style="background-color: #1abc9c;">
                            {{ $article->kategori }}
                        </span>
                        {{-- Judul Artikel --}}
                        <h5 class="card-title fw-bold text-dark">{{ $article->judul }}</h5>
                        {{-- Cuplikan Artikel: Menggunakan isi dari database, membatasi, dan menghapus tag HTML (jika ada) --}}
                        <p class="card-text text-muted">
                            {{ Illuminate\Support\Str::limit(strip_tags($article->isi), 100) }}
                        </p>
                        <small class="text-secondary">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></small>
                    </div>
                    <div class="card-footer bg-white border-0">
                        {{-- Menggunakan created_at dan memformatnya dengan Carbon --}}
                        <small class="text-muted">Dipublikasikan: {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</small>
                    </div>
                </div>
            </a>
        </div>
        @empty
            {{-- Tampilkan pesan jika tidak ada artikel di database --}}
            <div class="col-12 text-center my-5">
                <p class="fs-4 text-muted">Tidak ada artikel yang ditemukan saat ini.</p>
                <p class="text-secondary">Pastikan Anda sudah menjalankan seeder atau menambahkan data ke tabel `artikels`.</p>
            </div>
        @endforelse
    </div>

    {{-- Tampilkan tautan paginasi --}}
    <div class="d-flex justify-content-center mt-4">
        {{-- Menambahkan parameter 'kategori' ke link paginasi agar filter tetap berlaku --}}
        {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
