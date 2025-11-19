@extends('layouts.app')

@section('title', 'Toko / Transaksi Produk')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Kolom Daftar Produk & Filter Kategori (10 kolom - Diperluas) --}}
        <div class="col-lg-9">

            {{-- Search Form (BARU) --}}
            <div class="row mb-4">
                <div class="col-12">
                    <form action="{{ route('transaksi.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari produk berdasarkan nama..." value="{{ request('q') }}">
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

            {{-- Filter Kategori (Diubah agar mirip artikel) --}}
            <div class="row mb-4">
                <div class="col-12">
                    <ul class="nav nav-pills nav-fill category-nav">
                        {{-- Opsi "Semua Produk" --}}
                        @php
                            $isActive = $selectedKategori === null;
                            $baseRoute = ['q' => request('q')]; // <-- BARU: Ambil query 'q'
                        @endphp
                        <li class="nav-item me-3">
                            <a class="nav-link {{ $isActive ? 'active' : '' }}"
                                aria-current="{{ $isActive ? 'page' : '' }}"
                                href="{{ route('transaksi.index', array_filter($baseRoute)) }}"> {{-- Gunakan array_filter untuk menghilangkan null --}}
                                Semua Produk
                            </a>
                        </li>
                        {{-- Loop Kategori dari Database --}}
                        @foreach ($kategoris as $kategori)
                            @php
                                $isActive = $selectedKategori === $kategori->slug;
                            @endphp
                            <li class="nav-item me-3">
                                <a class="nav-link {{ $isActive ? 'active' : '' }}"
                                    aria-current="{{ $isActive ? 'page' : '' }}"
                                    href="{{ route('transaksi.index', array_merge($baseRoute, ['kategori' => $kategori->slug])) }}">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Pesan Status (Success/Error) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Daftar Produk dalam Card Grid --}}
            <div class="row">
                @forelse ($produks as $produk)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100 p-3 card-hover">
                        <div class="card-body">
                            {{-- Tampilkan Kategori --}}
                            <span class="badge bg-secondary mb-2">{{ $produk->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                            <span class="badge bg-opacity-75 mb-2 fw-bold main-bg">{{ $produk->satuan }}</span>

                            <h5 class="card-title fw-bold">{{ $produk->nama_produk }}</h5>
                            <p class="card-text text-muted">
                                {{ Illuminate\Support\Str::limit($produk->deskripsi ?? 'Tidak ada deskripsi.', 100) }}
                            </p>
                            <p class="fs-5 fw-bold text-success">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                            <p class="text-secondary mb-3">Stok: {{ $produk->stok }}</p>

                            {{-- Form Tambah ke Keranjang --}}
                            @if ($produk->stok > 0)
                                <form action="{{ route('transaksi.addToCart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" placeholder="Jumlah" min="1" max="{{ $produk->stok }}" value="1" required>
                                        <button type="submit" class="btn main-bg text-white fw-bold">
                                            <i class="fas fa-cart-plus me-1"></i> Tambah
                                        </button>
                                    </div>
                                    @error('quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12 text-center my-5">
                        <p class="fs-4 text-muted">Tidak ada produk yang tersedia di kategori ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Tautan paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $produks->appends(request()->query())->links('pagination::bootstrap-5') }} {{-- Menambahkan appends(request()->query()) untuk membawa parameter q dan kategori --}}
            </div>
        </div>

        {{-- Kolom Keranjang Belanja (2 kolom - Tetap di Kanan) --}}
        <div class="col-lg-3">
            <div class="card shadow sticky-top" style="top: 20px;">
                <div class="card-header main-bg text-white fw-bold">
                    <i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja ({{ count($cart) }})
                </div>
                <div class="card-body">
                    @if (count($cart) > 0)
                        @php $grandTotal = 0; @endphp
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($cart as $item)
                                @php $grandTotal += $item['subtotal']; @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $item['nama_produk'] }}</h6>
                                        <small class="text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold d-block">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                        <a href="{{ route('transaksi.removeFromCart', ['id_produk' => $item['id_produk']]) }}" class="text-danger small text-decoration-none">Hapus</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between fw-bold fs-5 border-top pt-3">
                            <span>Total Keseluruhan:</span>
                            <span class="main-color">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('transaksi.checkout') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn main-bg text-white w-100 btn-lg fw-bold" onclick="return confirm('Apakah Anda yakin ingin memproses transaksi ini? Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}')">
                                <i class="fas fa-cash-register me-2"></i> BAYAR SEKARANG
                            </button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Keranjang Anda masih kosong. Silakan tambahkan produk.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
