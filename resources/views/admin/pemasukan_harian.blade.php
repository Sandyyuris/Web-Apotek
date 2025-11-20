@extends('layouts.app')

@section('title', 'Laporan Pemasukan Harian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-chart-line me-2"></i>
                            Laporan Penjualan Harian
                        </h2>
                        <p class="text-muted">Data penjualan produk untuk tanggal: <span class="fw-bold">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</span></p>
                    </div>

                    @if ($rekapitulasiPenjualan->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                            <p class="fs-5 text-muted">Tidak ada penjualan yang tercatat hari ini.</p>
                        </div>
                    @else
                        <div class="alert main-bg text-white text-center mb-4">
                            <h4 class="mb-0">
                                Total Pemasukan Hari Ini:
                                <span class="fw-bold">Rp {{ number_format($totalPemasukanHariIni, 0, ',', '.') }}</span>
                            </h4>
                            <small>Sudah termasuk biaya pengiriman (jika ada).</small>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="main-bg text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center">Kuantitas Terjual</th>
                                        <th class="text-end">Harga Satuan Saat Transaksi</th>
                                        <th class="text-end">Total Pemasukan (Subtotal)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekapitulasiPenjualan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold">{{ $item->nama_produk }}</td>
                                            <td class="text-center">{{ number_format($item->total_kuantitas_terjual, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="text-end fw-bold text-success">Rp {{ number_format($item->total_pemasukan_produk, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <p class="mt-4 text-end text-muted">
                            <small>Total dalam tabel adalah total subtotal produk, tidak termasuk biaya pengiriman per transaksi. Total Pemasukan di atas adalah total harga transaksi (termasuk ongkir).</small>
                        </p>
                    @endif

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
