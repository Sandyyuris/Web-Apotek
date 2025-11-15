@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
<div class="container">
    {{-- Pilihan Kategori di bawah Navbar --}}
    <div class="row mb-4">
        <div class="col-12">
            <nav class="nav nav-pills nav-fill category-nav bg-white shadow-sm p-2 rounded">
                <a class="nav-link active" aria-current="page" href="{{ route('artikel.index') }}">Semua Artikel</a>
                <a class="nav-link" href="#">Obat</a>
                <a class="nav-link" href="#">Tips Hidup Sehat</a>
            </nav>
        </div>
    </div>

    {{-- Daftar Artikel (Grid 3 kolom) --}}
    <div class="row">
        @php
            // Data dummy artikel, ganti dengan data dari controller
            // Gunakan placeholder dari API agar terlihat profesional, atau ganti dengan link gambar Anda
            $articles = [
                ['title' => 'Manfaat Luar Biasa dari Madu untuk Daya Tahan Tubuh', 'category' => 'Obat', 'image' => 'https://via.placeholder.com/400x250?text=Obat+Alami'],
                ['title' => 'Panduan Tidur Cepat dan Nyenyak untuk Kesehatan Mental', 'category' => 'Tips Hidup Sehat', 'image' => 'https://via.placeholder.com/400x250?text=Tidur+Sehat'],
                ['title' => 'Cara Tepat Mengonsumsi Paracetamol untuk Demam Anak', 'category' => 'Obat', 'image' => 'https://via.placeholder.com/400x250?text=Obat+Demam'],
                ['title' => '5 Resep Smoothie Sehat untuk Sarapan Cepat', 'category' => 'Tips Hidup Sehat', 'image' => 'https://via.placeholder.com/400x250?text=Resep+Sehat'],
                ['title' => 'Mengenal Bahaya Antibiotik jika Dikonsumsi Berlebihan', 'category' => 'Obat', 'image' => 'https://via.placeholder.com/400x250?text=Antibiotik'],
                ['title' => 'Yoga Pagi: 10 Menit Gerakan untuk Meningkatkan Energi', 'category' => 'Tips Hidup Sehat', 'image' => 'https://via.placeholder.com/400x250?text=Yoga+Pagi'],
            ];
            use Illuminate\Support\Str; // Panggil helper Str untuk slug dan limit
        @endphp

        @foreach ($articles as $article)
        <div class="col-md-4 mb-4">
            {{-- Tambahkan link ke detail artikel dengan URL dummy slug --}}
            <a href="{{ route('artikel.detail', ['slug' => Str::slug($article['title'])]) }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 card-hover">
                    {{-- Gambar Placeholder --}}
                    <img src="{{ $article['image'] }}" class="card-img-top" alt="{{ $article['title'] }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        {{-- Badge Kategori --}}
                        <span class="badge bg-opacity-75 mb-2 fw-bold" style="background-color: #1abc9c;">
                            {{ $article['category'] }}
                        </span>
                        {{-- Judul Artikel --}}
                        <h5 class="card-title fw-bold text-dark">{{ $article['title'] }}</h5>
                        {{-- Cuplikan Artikel (Lorem Ipsum) --}}
                        <p class="card-text text-muted">
                            {{ Str::limit('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 100) }}
                        </p>
                        <small class="text-secondary">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></small>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <small class="text-muted">Dipublikasikan: 15 November 2025</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Pagination dummy --}}
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
              <li class="page-item disabled"><span class="page-link">Sebelumnya</span></li>
              <li class="page-item active"><a class="page-link main-bg border-0" href="#">1</a></li>
              <li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
              <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li>
              <li class="page-item"><a class="page-link text-secondary" href="#">Selanjutnya</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection
