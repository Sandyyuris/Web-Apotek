@extends('layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-12">
            <form action="{{ route('artikel.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-lg"
                        placeholder="Cari artikel berdasarkan judul..." value="{{ request('q') }}">
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

    @php
        $activeKategoriName = $selectedKategoriName ?? 'Semua Artikel';
        $allCategories = collect([
            (object) ['nama_kategori' => 'Semua Artikel', 'slug' => 'Semua Artikel']
        ])->merge($kategoris);
    @endphp

    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill category-nav">
                @foreach ($allCategories as $cat)
                    @php
                        $categorySlug = $cat->slug !== 'Semua Artikel' ? $cat->slug : null;
                        $url = route('artikel.index', array_filter(['kategori' => $categorySlug, 'q' => request('q')]));
                        $isActive = ($activeKategoriName === $cat->nama_kategori);
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

    <div class="row">
        @forelse ($articles as $article)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100 card">
                <a href="{{ route('artikel.detail', ['id' => $article->id_artikel, 'slug' => Illuminate\Support\Str::slug($article->judul)]) }}"
                    class="text-decoration-none">
                    <img src="{{ $article->path_foto ? $article->path_foto : 'https://via.placeholder.com/400x250?text=Apotek+Artikel' }}"
                        class="card-img-top" alt="{{ $article->judul }}"
                        style="height: 180px; object-fit: cover;">
                </a>

                <div class="card-body">
                    <span class="badge bg-opacity-75 mb-2 fw-bold" style="background-color: #1abc9c;">
                        {{ $article->kategoriArtikel->nama_kategori }}
                    </span>

                    <a href="{{ route('artikel.detail', ['id' => $article->id_artikel, 'slug' => Illuminate\Support\Str::slug($article->judul)]) }}"
                        class="text-decoration-none">
                        <h5 class="card-title fw-bold text-dark">{{ $article->judul }}</h5>
                    </a>

                    <p class="card-text text-muted">
                        {{ Illuminate\Support\Str::limit(strip_tags($article->isi), 100) }}
                    </p>
                </div>

                <div class="card-footer bg-white border-0">
                    <small class="text-muted d-block">
                        Dipublikasikan: {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}
                    </small>

                    @auth
                        @if (Auth::user()->id_role === 1)
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('admin.artikel.edit', $article->id_artikel) }}"
                                    class="btn btn-sm btn-warning flex-grow-1">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.artikel.delete', $article->id_artikel) }}"
                                    method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Artikel">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('artikel.detail', ['id' => $article->id_artikel, 'slug' => Illuminate\Support\Str::slug($article->judul)]) }}"
                                class="text-decoration-none fw-bold main-color mt-2 d-inline-block">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('artikel.detail', ['id' => $article->id_artikel, 'slug' => Illuminate\Support\Str::slug($article->judul)]) }}"
                            class="text-decoration-none fw-bold main-color mt-2 d-inline-block">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center my-5">
                <p class="fs-4 text-muted">Tidak ada artikel yang ditemukan saat ini.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

@auth
    @if (Auth::user()->id_role === 1)
        <a href="{{ route('admin.artikel.create') }}"
           class="btn main-bg text-white rounded-circle floating-action-button"
           data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah Artikel Baru">
            <i class="fas fa-plus"></i>
        </a>
    @endif
@endauth
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus Artikel?',
                    text: "Artikel yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#1abc9c',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
