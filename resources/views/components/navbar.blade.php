<nav class="navbar navbar-expand-lg navbar-dark main-bg shadow-lg sticky-top py-3" style="z-index: 1030;">
    <div class="container-fluid">
        {{-- Brand/Logo --}}
        <a class="navbar-brand fw-bold" href="{{ route('artikel.index') }}">
            <i class="fas fa-pills me-2"></i>
            SHANN APOTEK
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Main Navigation Links (Left/Center) --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    {{-- Active logic: Jika URI saat ini adalah root ('/') atau 'artikel' --}}
                    @php
                        $isArtikelActive = request()->is('/') || request()->is('artikel/*');
                    @endphp
                    <a class="nav-link {{ $isArtikelActive ? 'active' : '' }}" aria-current="page" href="{{ route('artikel.index') }}">Artikel</a>
                </li>
                <li class="nav-item">
                    {{-- Active logic: Placeholder untuk Transaksi Obat. Gunakan rute yang mungkin di masa depan --}}
                    @php
                        // Memeriksa rute transaksi/produk
                        $isTransaksiActive = request()->routeIs('transaksi.index') || request()->routeIs('transaksi.*');
                    @endphp
                    {{-- Ganti teks menjadi 'Transaksi Produk' atau 'Toko' --}}
                    <a class="nav-link {{ $isTransaksiActive ? 'active' : '' }}" href="{{ route('transaksi.index') }}">Belanja</a>
                </li>
                <li class="nav-item">
                    {{-- Active logic: Placeholder untuk Chat dengan Dokter. Gunakan rute yang mungkin di masa depan --}}
                    @php
                        $isChatActive = request()->is('chat*');
                    @endphp
                    <a class="nav-link {{ $isChatActive ? 'active' : '' }}" href="#chat">Chat dengan Dokter</a>
                </li>
            </ul>

            {{-- Auth Buttons / Profile (Right) --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    {{-- TAMPILKAN: Tombol Login untuk Guest. Menggunakan btn-light (putih) agar kontras --}}
                    <li class="nav-item">
                        <a class="btn btn-light fw-bold" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                    </li>
                @endguest

                @auth
                    {{-- TAMPILKAN: Dropdown Profile untuk User yang sudah login --}}
                    <li class="nav-item dropdown">
                        {{-- Tambahkan kelas active jika sedang berada di halaman yang berhubungan dengan profil (misal: profil, edit, logout) --}}
                        @php
                            $isProfileActive = request()->is('profil*') || request()->is('edit-profil*');
                        @endphp
                        <a class="nav-link dropdown-toggle fw-bold {{ $isProfileActive ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> Halo, {{ \Illuminate\Support\Str::limit(Auth::user()->name, 10, '..') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-id-card me-2"></i> Lihat Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></li>
                            {{-- UBAH INI --}}
                            <li><a class="dropdown-item" href="{{ route('profile.history') }}"><i class="fas fa-history me-2"></i> Riwayat Pembelian</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
