@extends('layouts.app')

@section('title', 'Toko / Transaksi Produk')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">

            {{-- ... (Bagian Search dan Filter Kategori tetap sama) ... --}}
            <div class="row mb-4">
                <div class="col-12">
                    <form action="{{ route('transaksi.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari produk berdasarkan nama..." value="{{ request('q') }}">
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

            <div class="row mb-4">
                <div class="col-12">
                    <ul class="nav nav-pills nav-fill category-nav">
                        @php
                            $isActive = $selectedKategori === null;
                            $baseRoute = ['q' => request('q')];
                        @endphp
                        <li class="nav-item me-3">
                            <a class="nav-link {{ $isActive ? 'active' : '' }}"
                                aria-current="{{ $isActive ? 'page' : '' }}"
                                href="{{ route('transaksi.index', array_filter($baseRoute)) }}">
                                Semua Produk
                            </a>
                        </li>
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

            @if (session('add_to_cart'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('add_to_cart') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error_to_cart'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('remove_from_cart'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm border-start border-warning border-4" role="alert">
                    <i class="fas fa-trash-alt me-2"></i> {{ session('remove_from_cart') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                @forelse ($produks as $produk)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100 p-3 card-hover">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-secondary me-1">{{ $produk->kategori->nama_kategori }}</span>
                                <span class="badge bg-opacity-75 fw-bold main-bg">{{ $produk->satuan->nama_satuan }}</span>
                            </div>

                            <h5 class="card-title fw-bold">{{ $produk->nama_produk }}</h5>
                            <p class="card-text text-muted">
                                {{ Illuminate\Support\Str::limit($produk->deskripsi ?? 'Tidak ada deskripsi.', 100) }}
                            </p>
                            <p class="fs-5 fw-bold text-">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                            <p class="text-secondary mb-3">Stok: {{ $produk->stok }}</p>

                            <div class="mt-auto">
                                @auth
                                    @if (Auth::user()->id_role === 1)
                                        <div class="d-flex gap-2 mb-3">
                                            <a href="{{ route('admin.produk.edit', $produk->id_produk) }}" class="btn btn-sm btn-warning flex-grow-1">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.produk.delete', $produk->id_produk) }}" method="POST" class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Produk">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <hr>
                                    @endif
                                @endauth

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
                </div>
                @empty
                    <div class="col-12 text-center my-5">
                        <p class="fs-4 text-muted">Tidak ada produk yang tersedia di kategori ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $produks->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

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

                        <a href="{{ route('transaksi.checkout.form') }}" class="btn main-bg text-white w-100 btn-lg fw-bold mt-3">
                            <i class="fas fa-cash-register me-2"></i> LANJUT KE PEMBAYARAN
                        </a>
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

@auth
    @if (Auth::user()->id_role === 1)
        <a href="{{ route('admin.produk.create') }}"
           class="btn main-bg text-white rounded-circle floating-action-button"
           data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah Produk Baru">
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
                    title: 'Yakin ingin menghapus?',
                    text: "Produk yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
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
