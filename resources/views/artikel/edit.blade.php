@extends('layouts.app')

@section('title', 'Edit Artikel: ' . $artikel->judul)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-edit me-2"></i>
                            Formulir Edit Artikel
                        </h2>
                        <p class="text-muted">Perbarui detail artikel. Kosongkan foto jika tidak ingin diubah.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.artikel.update', $artikel->id_artikel) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Artikel</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $artikel->judul) }}" required placeholder="Masukkan Judul">
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
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori_artikel }}"
                                            {{ old('id_kategori_artikel', $artikel->id_kategori_artikel) == $kategori->id_kategori_artikel ? 'selected' : '' }}>
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
                            <textarea id="isi" class="form-control @error('isi') is-invalid @enderror" name="isi" rows="8" required placeholder="Isi Artikel">{{ old('isi', $artikel->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="path_foto" class="form-label fw-bold">Foto Artikel (Kosongkan jika tidak diubah)</label>
                            @if ($artikel->path_foto)
                                <div class="mb-2">
                                    <img src="{{ $artikel->path_foto }}" alt="Foto Saat Ini" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('path_foto') is-invalid @enderror" name="path_foto">
                            @error('path_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn main-bg text-white btn-lg fw-bold">
                                <i class="fas fa-save me-2"></i>
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('artikel.detail', ['id' => $artikel->id_artikel, 'slug' => \Illuminate\Support\Str::slug($artikel->judul)]) }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Detail Artikel
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
