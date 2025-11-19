@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
<div class="container-fluid">
    {{-- Search Form (BARU) --}}
    <div class="row mb-4">
        <div class="col-12">
            <form action="{{ route('artikel.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari artikel berdasarkan judul..." value="{{ request('q') }}">
                    {{-- Pertahankan filter kategori jika ada --}}
                    @if (request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <button class="btn main-bg text-white btn-lg" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- Pilihan Kategori di bawah Search --}}
    @php
        // $selectedKategoriName adalah nama kategori aktif dari Controller. Jika null, anggap 'Semua Artikel'.
        $activeKategoriName = $selectedKategoriName ?? 'Semua Artikel'; // <-- PERUBAHAN

        // Gabungkan "Semua Artikel" dengan koleksi kategori dari DB
        $allCategories = collect([
            (object) ['nama_kategori' => 'Semua Artikel', 'slug' => 'Semua Artikel']
        ])->merge($kategoris); // $kategoris adalah KategoriArtikel::all() dari Controller
    @endphp

    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill category-nav">
                @foreach ($allCategories as $cat)
                    @php
                        // Gunakan slug untuk URL
                        $categorySlug = $cat->slug !== 'Semua Artikel' ? $cat->slug : null;
                        $url = route('artikel.index', array_filter(['kategori' => $categorySlug, 'q' => request('q')]));
                        $isActive = ($activeKategoriName === $cat->nama_kategori); // Cek berdasarkan nama
                    @endphp
                    <li class="nav-item me-3">
                        <a class="nav-link {{ $isActive ? 'active' : '' }}"
                            aria-current="{{ $isActive ? 'page' : '' }}"
                            href="{{ $url }}">
                            {{ $cat->nama_kategori }}
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
                    <img src="{{ $article->path_foto ? asset('storage/' . $article->path_foto) : 'https://via.placeholder.com/400x250?text=Apotek+Artikel' }}" class="card-img-top" alt="{{ $article->judul }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        {{-- Badge Kategori --}}
                        <span class="badge bg-opacity-75 mb-2 fw-bold" style="background-color: #1abc9c;">
                            {{ $article->kategoriArtikel->nama_kategori}} {{-- <-- PERUBAHAN --}}
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

            </div>
        @endforelse
    </div>

    {{-- Tampilkan tautan paginasi --}}
    <div class="d-flex justify-content-center mt-4">
        {{-- Menambahkan parameter 'kategori' ke link paginasi agar filter tetap berlaku --}}
        {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@auth
    {{-- Cek apakah user adalah Admin (id_role = 1) untuk menampilkan tombol --}}
    @if (Auth::user()->id_role === 1)
        <a href="{{ route('admin.artikel.create') }}"
           class="btn main-bg text-white rounded-circle floating-action-button"
           data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah Artikel Baru">
            <i class="fas fa-plus"></i>
        </a>
    @endif
@endauth
@endsection
