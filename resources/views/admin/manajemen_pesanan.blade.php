@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-box-open me-2"></i>
                            Daftar Pesanan Baru & Pending
                        </h2>
                        <p class="text-muted">Kelola pesanan yang masih berstatus **Baru** atau **Diproses** dengan pembayaran **Pending**.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @forelse ($orders as $order)
                        <div class="card mb-3 shadow-sm border-{{ $order->status_pesanan === 'Baru' ? 'danger' : 'warning' }}">
                            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                <div>
                                    <h5 class="mb-0 fw-bold">#{{ $order->kode_transaksi }}</h5>
                                    <small class="text-muted">Pelanggan: {{ $order->user->name ?? 'User Dihapus' }}</small>
                                </div>
                                <div>
                                    <span class="badge bg-primary me-2">{{ $order->tipe_pengiriman }}</span>
                                    <span class="badge bg-{{ $order->status_pesanan === 'Baru' ? 'danger' : 'warning' }}">{{ $order->status_pesanan }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1">Tgl: <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</strong></p>
                                        <p class="mb-1">Pembayaran: <strong>{{ $order->metode_pembayaran }}</strong> (Status: <span class="text-danger fw-bold">{{ $order->status_pembayaran }}</span>)</p>
                                        <p class="mb-1">Total: <span class="fs-5 fw-bold main-color">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        @if ($order->tipe_pengiriman === 'Diantar')
                                            <p class="mb-1">Alamat: **{{ $order->alamat_pengiriman }}**</p>
                                        @else
                                            <p class="mb-1">Pengambilan di Apotek</p>
                                        @endif
                                    </div>
                                </div>

                                <h6 class="mt-3 border-bottom pb-2">Detail Produk:</h6>
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach ($order->detailTransaksis as $detail)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                                            <span>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</span>
                                            <span class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Tombol untuk mengubah status dari Baru ke Diproses --}}
                                    @if ($order->status_pesanan === 'Baru')
                                        <form action="{{ route('admin.orders.process', $order->id_transaksi) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm fw-bold" onclick="return confirm('Ubah status pesanan ke Diproses?')">
                                                <i class="fas fa-spinner me-1"></i> Proses Pesanan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol untuk menyelesaikan pesanan dan melunasi pembayaran --}}
                                    <form action="{{ route('admin.orders.complete', $order->id_transaksi) }}" method="POST" onsubmit="return confirm('Yakin pesanan ini sudah **Selesai** dan Pembayaran **Lunas**?')">
                                        @csrf
                                        <button type="submit" class="btn main-bg text-white btn-sm fw-bold">
                                            <i class="fas fa-check-circle me-1"></i> Selesaikan & Lunas
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <p class="fs-5 text-muted">Tidak ada pesanan baru atau yang sedang diproses saat ini.</p>
                        </div>
                    @endforelse

                    {{-- Tautan Paginasi --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
