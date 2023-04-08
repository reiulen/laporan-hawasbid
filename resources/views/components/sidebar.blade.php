<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex justify-content-center align-items-center">
        <div class="brand-text text-center align-middle">
            <div class="brand-text h5">PENGADILAN AGAMA <br/> CIREBON</div>
        </div>
    </a>

    <!-- Sidebar -->
    <div
        class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pt-4 pb-3 mb-3 d-flex align-items-start" style="gap: 5px;">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2"
                    style="width: 40px; height: 40px; object-fit: cover;" alt="User Image" />
            </div>
            <div class="dropdown">
                <a class="user-nama" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <p>
                        {{ Str::substr(Auth::user()->name, 0, 18) }}
                    </p>
                    <p class="level text-muted">
                        {{ Auth::user()->jabatan ? Auth::user()->jabatan : nameRole(Auth::user()->role) }}
                    </p>
                </a>
                <div class="dropdown-menu bg-dark border-0 shadow-lg" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/user/profile') }}"><i
                            class="fa fa-user text-primary pr-1"></i> Profil</a>
                    @can('ubahpassword')
                        <a class="dropdown-item" href="#"><i class="fa fa-lock text-success pr-1"></i> Ubah
                            Password</a>
                    @endcan
                    <div class="dropdown-divider"></div>
                    <a role="button" class="dropdown-item logout" data-nama=""><i
                            class="fa fa-sign-out-alt text-danger pr-1"></i> Keluar</a>

                    <form id="logoutForm" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search..."
                    aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-header">Sistem</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ set_active(['dashboard']) }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li
                    class="nav-item nav-item {{ set_menu_open(['user.index', 'user.create', 'user.edit']) }}">
                    <a href="#" class="nav-link {{ set_active(['user.index', 'user.create', 'user.edit']) }}">
                        <i class="fas fa-save nav-icon"></i>
                        <p>
                            {{ __('Master') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ set_active_sub(['user.index']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Pengguna') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user()->role != 3)
                <li
                    class="nav-item nav-item {{ set_menu_open(['temuan.index', 'temuan.create']) }}">
                    <a href="#" class="nav-link {{ set_active(['temuan.index', 'temuan.create']) }}">
                        <i class="fas fa-file nav-icon"></i>
                        <p>
                            {{ __('Temuan') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('temuan.index') }}" class="nav-link {{ set_active_sub(['temuan.index']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('temuan.create') }}" class="nav-link {{ set_active_sub(['temuan.create']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Tambah Temuan') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li
                    class="nav-item nav-item {{ set_menu_open(['tindak-lanjut.index', 'tindak-lanjut.temuan']) }}">
                    <a href="#" class="nav-link {{ set_active(['tindak-lanjut.index', 'tindak-lanjut.temuan']) }}">
                        <i class="fas fa-file nav-icon"></i>
                        <p>
                            {{ __('Tindak Lanjut') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tindak-lanjut.index') }}" class="nav-link {{ set_active_sub(['tindak-lanjut.index']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('List') }}</p>
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
