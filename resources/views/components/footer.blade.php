<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container text-center text-md-start">
        <div class="row text-center text-md-start">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Shann Apotek</h5>
                <p>
                    Solusi kesehatan terpercaya untuk keluarga Anda. Kami menyediakan obat-obatan berkualitas, artikel kesehatan, dan pelayanan terbaik.
                </p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Menu</h5>
                <p>
                    <a href="{{ route('transaksi.index') ?? '#' }}" class="text-white" style="text-decoration: none;">Produk</a>
                </p>
                <p>
                    <a href="{{ route('artikel.index') ?? '#' }}" class="text-white" style="text-decoration: none;">Artikel</a>
                </p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Kontak</h5>
                <p>
                    <i class="fas fa-home mr-3"></i> Jl. Sehat Makmur No. 123
                </p>
                <p>
                    <i class="fas fa-envelope mr-3"></i> info@Shann.apotek.com
                </p>
                <p>
                    <i class="fas fa-phone mr-3"></i> +62 812 3456 7890
                </p>
            </div>

        </div>

        <hr class="mb-4">

        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="mb-0">
                    &copy; {{ date('Y') }} <strong>Shann Apotek</strong>. Hak Cipta Dilindungi.
                    <small class="d-block d-md-inline ml-md-2">Dibuat dengan semangat hidup sehat.</small>
                </p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-end">
                    <ul class="list-unstyled list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="http://web.facebook.com/Jokowi/?locale=id_ID&_rdc=1&_rdr#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://x.com/jokowi" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/sandiiaap_/" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
