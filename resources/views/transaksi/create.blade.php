@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Form Tambah Produk Baru</h1>
            <div class="alert alert-info">
                <strong>Placeholder Konten:</strong> Di sinilah form untuk menambahkan produk baru akan berada.
            </div>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Belanja</a>
        </div>
    </div>
</div>
@endsection
