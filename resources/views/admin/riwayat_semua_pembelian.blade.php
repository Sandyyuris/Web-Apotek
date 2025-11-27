@extends('layouts.app')

@section('title', 'Semua Riwayat Pembelian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-list-alt me-2"></i>
                            Riwayat Transaksi Customer
                        </h2>
                    </div>

                    @if (isset($totalPemasukan) && $totalPemasukan > 0)
                        <div class="alert main-bg text-white text-center mb-4">
                            <h4 class="mb-0">
                                Total Pemasukan Lunas:
                                <span class="fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                            </h4>
                        </div>
                    @endif

                    @forelse ($allHistories as $history)
                        @php
                            $statusPesananClass = [
                                'Baru' => 'danger',
                                'Diproses' => 'warning',
                                'Selesai' => 'success',
                                'Dibatalkan' => 'secondary'
                            ][$history->status_pesanan] ?? 'secondary';
                            $statusPembayaranClass = $history->status_pembayaran === 'Lunas' ? 'success' : 'secondary';
                        @endphp
                        <div class="card mb-3 shadow-sm border-{{ $statusPesananClass }}">
                            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                <div>
                                    <h5 class="mb-0 fw-bold">#{{ $history->kode_transaksi }}</h5>
                                    <small class="text-muted">Pelanggan: <strong>{{ $history->user->name ?? 'User Dihapus' }}</strong> (Username: {{ $history->user->username ?? '-' }})</small>
                                </div>
                                <div>
                                    <span class="badge bg-{{ $statusPesananClass }} me-2"> {{ $history->status_pesanan }}</span>
                                    <span class="badge bg-{{ $statusPembayaranClass }}"> {{ $history->status_pembayaran }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1">Tgl Transaksi: <strong>{{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y H:i') }}</strong></p>
                                        <p class="mb-1">Metode Bayar: <strong>{{ $history->metode_pembayaran }}</strong></p>
                                        <p class="mb-1">Tipe Kirim: <strong>{{ $history->tipe_pengiriman }}</strong></p>
                                        <p class="mb-1">Nomor Telp: <strong>{{ $history->user->nomor_telp ?? '-' }}</strong></p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <p class="mb-1">Total Harga: <span class="fs-5 fw-bold main-color">Rp {{ number_format($history->total_harga, 0, ',', '.') }}</span></p>
                                        @if ($history->tipe_pengiriman === 'Diantar')
                                            <p class="mb-1 text-muted">Alamat: {{ $history->alamat_pengiriman }}</p>
                                        @endif
                                    </div>
                                </div>

                                <h6 class="mt-3 border-bottom pb-2">Detail Produk:</h6>
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach ($history->detailTransaksis as $detail)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                                            <span>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</span>
                                            <span class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <p class="fs-5 text-muted">Tidak ada riwayat transaksi yang tercatat.</p>
                        </div>
                    @endforelse

                    <div class="d-flex justify-content-center mt-4">
                        {{ $allHistories->links('pagination::bootstrap-5') }}
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('artikel.index') }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
