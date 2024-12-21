<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Teknik Informatika | KSI</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">KSI</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('admin.product') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.product') }}"><i class="fas fa-box">
                    </i><span>Produk</span></a>
            </li>
            <li class="{{ Request::is('admin.distributor*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.distributor') }}">
                    <i class="fas fa-truck"></i><span>Distributor</span>
                </a>
            </li>
            </ul>
    </aside>
</div>