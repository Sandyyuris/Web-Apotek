@extends('layouts.app')

@section('title', 'Tambah Artikel Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Form Tambah Artikel Baru</h1>
            <div class="alert alert-info">
                <strong>Placeholder Konten:</strong> Di sinilah form untuk menambahkan artikel baru akan berada.
            </div>
            <a href="{{ route('artikel.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Artikel</a>
        </div>
    </div>
</div>
@endsection
