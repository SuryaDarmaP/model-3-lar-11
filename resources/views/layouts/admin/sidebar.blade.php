<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">Teknik Informatika | RPL</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">RPL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{  Route::is('admin.product') ? 'active' : ''}}"><a class="nav-link"
                href="{{  route('admin.product') }}"><i class="fas fa-box"></i> <span>Produk</span></a></li>
        </ul>
    </aside>
</div>