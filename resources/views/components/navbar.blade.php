<nav class="navbar navbar-expand-lg navbar-dark main-bg shadow-lg sticky-top py-3" style="z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('artikel.index') }}">
            <i class="fas fa-pills me-2"></i>
            SHANN APOTEK
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @php
                $isArtikelActive = request()->is('/') || request()->is('artikel/*');
            @endphp
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ $isArtikelActive ? 'active' : '' }}" aria-current="page" href="{{ route('artikel.index') }}">Artikel</a>
                </li>
                <li class="nav-item">
                    @php
                        $isTransaksiActive = request()->routeIs('transaksi.index') || request()->routeIs('transaksi.*');
                    @endphp
                    <a class="nav-link {{ $isTransaksiActive ? 'active' : '' }}" href="{{ route('transaksi.index') }}">Belanja</a>
                </li>
                <li class="nav-item">
                    @php
                        $isChatActive = request()->routeIs('chat.index') || request()->routeIs('chat.*');
                    @endphp
                    <a class="nav-link {{ $isChatActive ? 'active' : '' }}" href="{{ route('chat.index') }}">Chat dengan AI</a>
                </li>
                @auth
                    @if (Auth::user()->id_role === 1)
                        <li class="nav-item">
                            @php
                                $isLaporanActive = request()->routeIs('admin.pemasukan.harian');
                            @endphp
                            <a class="nav-link {{ $isLaporanActive ? 'active' : '' }}" href="{{ route('admin.pemasukan.harian') }}">
                                <i class="fas fa-chart-line me-1"></i> Laporan Penjualan
                            </a>
                        </li>
                        <li class="nav-item">
                            @php
                                $isAllHistoryActive = request()->routeIs('admin.all.history');
                            @endphp
                            <a class="nav-link {{ $isAllHistoryActive ? 'active' : '' }}" href="{{ route('admin.all.history') }}">
                                <i class="fas fa-list me-1"></i> Semua Riwayat
                            </a>
                        </li>
                        <li class="nav-item">
                            @php
                                $isOrdersActive = request()->routeIs('admin.orders.manage');
                            @endphp
                            <a class="nav-link {{ $isOrdersActive ? 'active' : '' }}" href="{{ route('admin.orders.manage') }}">
                                <i class="fas fa-tasks me-1"></i> Kelola Pesanan
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="btn btn-light fw-bold" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        @php
                            $isProfileActive = request()->is('profil*') || request()->is('edit-profil*');
                        @endphp
                        <a class="nav-link dropdown-toggle fw-bold {{ $isProfileActive ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ \Illuminate\Support\Str::limit(Auth::user()->name, 10, '..') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-id-card me-2"></i> Lihat Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></li>
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
