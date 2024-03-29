    <!-- Main Menu -->
    <div data-simplebar class="nicescroll-bar">
        <div class="menu-content-wrap">
            <div class="menu-group">
                <ul class="navbar-nav flex-column">
                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                        <li class="nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard.index') }}">
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'superadmin')
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                                    data-bs-target="#masterdata">
                                    <span class="nav-link-text">Master Data</span>
                                </a>
                                <ul id="masterdata" class="nav flex-column collapse nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            <li class="nav-item {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                                                <a class="nav-link" href="{{ route('user.index') }}"><span
                                                        class="nav-link-text">User</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                                data-bs-target="#transaksidata">
                                <span class="nav-link-text">Transaksi</span>
                            </a>
                            <ul id="transaksidata" class="nav flex-column collapse nav-children">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ request()->segment(1) == 'order' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('order.index') }}"><span
                                                    class="nav-link-text">Order</span></a>
                                        </li>
                                        <li class="nav-item {{ request()->segment(1) == 'manifest' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('manifest.index') }}"><span
                                                    class="nav-link-text">Manifest Order</span></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->city == 'makassar' || Auth::user()->role == 'superadmin')
                            <li class="nav-item {{ request()->segment(1) == 'pengeluaran' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('pengeluaran.index') }}">
                                    <span class="nav-link-text">Pengeluaran</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->city == 'surabaya' || Auth::user()->role == 'superadmin')
                            <li class="nav-item {{ request()->segment(1) == 'laporan' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('laporan.index') }}">
                                    <span class="nav-link-text">Laporan</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- /Main Menu -->
