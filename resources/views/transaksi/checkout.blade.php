@extends('layouts.app')

@section('title', 'Finalisasi Pembelian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg p-4" style="border-left: 6px solid #1abc9c; border-radius: 1rem;">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-1 main-color">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Finalisasi Pembelian
                        </h2>
                        <p class="text-muted">Pilih opsi pengiriman dan metode pembayaran.</p>
                    </div>

                    <form method="POST" action="{{ route('transaksi.checkout') }}">
                        @csrf

                        <div class="mb-5">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">Rincian Keranjang</h5>
                            <ul class="list-group mb-3">
                                @foreach ($cart as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $item['nama_produk'] }}</h6>
                                            <small class="text-muted">{{ $item['quantity'] }} {{ $item['satuan'] }} x Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</small>
                                        </div>
                                        <span class="fw-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between fw-bold pt-2">
                                <span>Subtotal Produk:</span>
                                <span class="main-color">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">Opsi Pengiriman</h5>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="tipe_pengiriman" id="ambilApotek" value="Diambil di Apotek" checked required onchange="toggleDeliveryForm()">
                                <label class="form-check-label fw-bold" for="ambilApotek">
                                    <i class="fas fa-store me-1"></i> Diambil di Apotek (Gratis)
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="tipe_pengiriman" id="diantar" value="Diantar" required onchange="toggleDeliveryForm()">
                                <label class="form-check-label fw-bold" for="diantar">
                                    <i class="fas fa-truck me-1"></i> Diantar ke Alamat (+ Rp 10.000)
                                </label>
                            </div>

                            <div id="alamatForm" style="display:none;">
                                <label for="alamat_pengiriman" class="form-label fw-bold mt-3">Alamat Pengiriman</label>
                                <textarea id="alamat_pengiriman" class="form-control @error('alamat_pengiriman') is-invalid @enderror" name="alamat_pengiriman" rows="3" placeholder="Masukkan alamat lengkap Anda...">{{ old('alamat_pengiriman') }}</textarea>
                                @error('alamat_pengiriman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kami akan menggunakan alamat ini untuk mengirim pesanan Anda.</small>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">Metode Pembayaran</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="cash" value="Cash" checked required>
                                <label class="form-check-label fw-bold" for="cash">
                                    <i class="fas fa-money-bill-wave me-1"></i> Cash (Bayar di tempat/saat ambil)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="transfer" value="Transfer" required>
                                <label class="form-check-label fw-bold" for="transfer">
                                    <i class="fas fa-credit-card me-1"></i> Transfer Bank
                                </label>
                            </div>
                            @error('metode_pembayaran')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card bg-light p-3 mb-4">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal Produk:</span>
                                <span>Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                <span>Biaya Pengiriman (<span id="biayaPengirimanText">Gratis</span>):</span>
                                <span id="biayaPengirimanValue">Rp {{ number_format(0, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between fw-bold fs-5 pt-2">
                                <span>Total Keseluruhan:</span>
                                <span class="main-color" id="grandTotalText">Rp {{ number_format($subtotalProduk, 0, ',', '.') }}</span>
                            </div>

                            <input type="hidden" id="subtotalProdukInput" value="{{ $subtotalProduk }}">
                            <input type="hidden" id="deliveryFeeValue" value="0">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" id="btn-checkout" class="btn main-bg text-white btn-lg fw-bold">
                                <i class="fas fa-cash-register me-2"></i> PESAN SEKARANG
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('transaksi.index') }}" class="text-decoration-none fw-bold main-color">
                            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }

    function toggleDeliveryForm() {
        const diantarRadio = document.getElementById('diantar');
        const alamatForm = document.getElementById('alamatForm');
        const biayaPengirimanText = document.getElementById('biayaPengirimanText');
        const biayaPengirimanValueSpan = document.getElementById('biayaPengirimanValue');
        const grandTotalText = document.getElementById('grandTotalText');
        const subtotalProduk = parseInt(document.getElementById('subtotalProdukInput').value);
        const deliveryFee = 10000;

        if (diantarRadio.checked) {
            alamatForm.style.display = 'block';
            biayaPengirimanText.textContent = 'Rp 10.000';
            biayaPengirimanValueSpan.textContent = formatRupiah(deliveryFee);
            grandTotalText.textContent = formatRupiah(subtotalProduk + deliveryFee);
            document.getElementById('alamat_pengiriman').setAttribute('required', 'required');
        } else {
            alamatForm.style.display = 'none';
            biayaPengirimanText.textContent = 'Gratis';
            biayaPengirimanValueSpan.textContent = formatRupiah(0);
            grandTotalText.textContent = formatRupiah(subtotalProduk);
            document.getElementById('alamat_pengiriman').removeAttribute('required');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleDeliveryForm);

    document.getElementById('btn-checkout').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Pesanan',
            text: "Pastikan semua data dan pesanan sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1abc9c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses Pesanan!',
            cancelButtonText: 'Periksa Lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection
