@extends('layouts.app')

@section('title', 'Tambah Artikel Baru')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-file-alt me-2"></i>
                            Form Tambah Artikel
                        </h2>
                        <p class="text-muted">Isi detail artikel dan publikasikan.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Artikel</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required placeholder="Masukkan Judul">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_kategori_artikel" class="form-label fw-bold">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                <select id="id_kategori_artikel" class="form-select @error('id_kategori_artikel') is-invalid @enderror" name="id_kategori_artikel" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori_artikel }}" {{ old('id_kategori_artikel') == $kategori->id_kategori_artikel ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori_artikel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label fw-bold">Isi Artikel</label>
                            <textarea id="isi" class="form-control @error('isi') is-invalid @enderror" name="isi" rows="8" required placeholder="Isi Artikel">{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="path_foto" class="form-label fw-bold">Foto Artikel</label>
                            <input type="file" class="form-control" name="path_foto">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn main-bg text-white btn-lg fw-bold">
                                <i class="fas fa-upload me-2"></i>
                                PUBLIKASIKAN ARTIKEL
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('artikel.index') }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Artikel
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
