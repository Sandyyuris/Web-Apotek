<?php
?>
@extends('layouts.app')

@section('title', 'Edit Produk: ' . $produk->nama_produk)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-edit me-2"></i>
                            Formulir Edit Produk
                        </h2>
                        <p class="text-muted">Perbarui detail produk.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.produk.update', $produk->id_produk) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                <input id="nama_produk" type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required placeholder="Contoh: Paracetamol 500mg">
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label fw-bold">Kategori Produk</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                <select id="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" name="id_kategori" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $produk->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_satuan" class="form-label fw-bold">Satuan Produk</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                                <select id="id_satuan" class="form-select @error('id_satuan') is-invalid @enderror" name="id_satuan" required>
                                    <option value="" disabled>Pilih Satuan</option>
                                    @foreach ($satuans as $satuan)
                                        <option value="{{ $satuan->id_satuan }}" {{ old('id_satuan', $produk->id_satuan) == $satuan->id_satuan ? 'selected' : '' }}>
                                            {{ $satuan->nama_satuan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label fw-bold">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                    <input id="stok" type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $produk->stok) }}" required min="0" placeholder="Jumlah Stok">
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga_jual" class="form-label fw-bold">Harga Jual (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    <input id="harga_jual" type="number" class="form-control @error('harga_jual') is-invalid @enderror" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" required min="0" placeholder="Contoh: 18000">
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Produk (Opsional)</label>
                            <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="4" placeholder="Jelaskan manfaat, komposisi, atau cara pakai produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
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
                        <a href="{{ route('transaksi.index') }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
