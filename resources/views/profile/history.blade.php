@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Pembelian Saya
                        </h2>
                        <p class="text-muted">Daftar semua transaksi yang pernah Anda lakukan.</p>
                    </div>

                    @forelse ($histories as $history)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Kode Transaksi: {{ $history->kode_transaksi }}</h5>
                                <div>
                                    @php
                                        $statusPesananClass = [
                                            'Baru' => 'danger',
                                            'Diproses' => 'warning',
                                            'Selesai' => 'success',
                                            'Dibatalkan' => 'secondary'
                                        ][$history->status_pesanan] ?? 'secondary';

                                        $statusPembayaranClass = $history->status_pembayaran === 'Lunas' ? 'success' : 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusPesananClass }} me-2"> {{ $history->status_pesanan }}</span>
                                    <span class="badge bg-{{ $statusPembayaranClass }}"> {{ $history->status_pembayaran }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">Tanggal: {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y H:i') }}</p>
                                <p class="mb-2 fs-5 fw-bold main-color">Total Harga: Rp {{ number_format($history->total_harga, 0, ',', '.') }}</p>

                                <h6 class="mt-3 border-bottom pb-2">Detail Produk:</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach ($history->detailTransaksis as $detail)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                {{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}
                                                <br>
                                                <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}</small>
                                            </div>
                                            <span class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                            <p class="fs-5 text-muted">Anda belum memiliki riwayat pembelian.</p>
                            <a href="{{ route('transaksi.index') }}" class="btn main-bg text-white fw-bold mt-2">Mulai Belanja Sekarang</a>
                        </div>
                    @endforelse

                    <div class="d-flex justify-content-center mt-4">
                        {{ $histories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
