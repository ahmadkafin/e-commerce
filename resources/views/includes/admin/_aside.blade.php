<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/logo-white.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3">
        <span class="brand-text font-weight-light text-uppercase" style="font-size: 1.2rem;">Keeper of the Deen</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}"
                        class="nav-link {{ Request::segment('1') == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Request::segment('1') == 'produk' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment('1') == 'produk' ? 'active' : '' }}">
                        <i class="fas fa-dolly-flatbed"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.products') }}"
                                class="nav-link {{ Request::segment('1') == 'produk' && Request::segment('2') == '' ? 'active' : '' }}">
                                <i class=" far fa-circle nav-icon"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.images') }}"
                                class="nav-link {{ Request::segment('1') == 'produk' && Request::segment('2') == 'images' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Image Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.collections') }}"
                                class="nav-link {{ Request::segment('1') == 'produk' && Request::segment('2') == 'collections' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Collections</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.discount') }}"
                                class="nav-link {{ Request::segment('1') == 'produk' && Request::segment('2') == 'discounts' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Discount</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cart-arrow-down"></i>
                        <p>
                            Order
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/layout/top-nav.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- ./main sidebar -->