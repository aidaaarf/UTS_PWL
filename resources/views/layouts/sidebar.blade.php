<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed; height: 100vh; overflow-y: hidden; width: 250px; z-index: 1030;">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">MiawMart</span>
    </a>

    <div class="sidebar d-flex flex-column" style="height: calc(100vh - 57px); overflow-y: auto;">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/profile.jpeg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nama ?? 'User' }}</a>
            </div>
        </div>

        <!-- Search Form -->
        <div class="form-inline mb-3 px-2">
            <div class="input-group">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-grow-1">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ ($activeMenu ?? ' ') == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                

                <li class="nav-header">Barang</li>
                <li class="nav-item">
                    <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Data Barang</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/transaksi') }}" class="nav-link {{ ($activeMenu == 'transaksi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transaksi</p>
                    </a>
                </li>

                @if(Auth::user() && Auth::user()->role == 'admin')
                <li class="nav-header">Manage</li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('log_activity.index') }}" class="nav-link {{ ($activeMenu == 'log_activity') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Log Activity</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Logout -->
        <div class="p-3 pb-4 mt-auto">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Anda yakin ingin logout?')">
                @csrf
                <button type="submit" class="btn btn-danger btn-block text-left">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</aside>
