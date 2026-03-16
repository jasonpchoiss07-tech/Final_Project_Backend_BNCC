<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ChipiChapa Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .sidebar { min-height: calc(100vh - 56px); background: #2c3e50; }
        .sidebar .nav-link { color: #bdc3c7; padding: .6rem 1.2rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #3498db; color: #fff; }
        .sidebar .nav-link i { width: 20px; }
        .sidebar-heading { color: #7f8c8d; font-size: .72rem; text-transform: uppercase; letter-spacing: 1px; padding: .8rem 1.4rem .3rem; }
        .content-area { padding: 2rem; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); border-radius: 10px; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; font-weight: 600; border-radius: 10px 10px 0 0 !important; }
        .btn-primary { background: #3498db; border-color: #3498db; }
        .btn-primary:hover { background: #2980b9; border-color: #2980b9; }
        .badge-kategori { background: #e8f4fd; color: #2980b9; font-size: .78rem; padding: 4px 10px; border-radius: 20px; }
        .table th { background: #f8f9fa; font-weight: 600; font-size: .88rem; }
        .img-thumbnail-sm { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; }
        @media print { .no-print { display: none !important; } }
    </style>
    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#2c3e50;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">
            <i class="bi bi-shop me-2"></i>ChipiChapa
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    @if(auth()->user()->role === 'user')
                    <li class="nav-item me-2">
                        <a class="nav-link text-white" href="{{ route('user.keranjang') }}">
                            <i class="bi bi-cart3"></i>
                            @php $keranjangCount = count(session()->get('keranjang', [])); @endphp
                            @if($keranjangCount > 0)
                                <span class="badge bg-danger rounded-pill">{{ $keranjangCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->nama_lengkap }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">{{ ucfirst(auth()->user()->role) }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
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

<div class="d-flex">
    {{-- Sidebar --}}
    <div class="sidebar no-print" style="width:230px; min-width:230px;">
        <nav class="pt-3">
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="sidebar-heading">Admin Panel</div>
                    <a href="{{ route('admin.barang.index') }}" class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-2"></i>Kelola Barang
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="bi bi-tags me-2"></i>Kelola Kategori
                    </a>
                @else
                    <div class="sidebar-heading">Menu</div>
                    <a href="{{ route('user.katalog') }}" class="nav-link {{ request()->routeIs('user.katalog') ? 'active' : '' }}">
                        <i class="bi bi-grid me-2"></i>Katalog Barang
                    </a>
                    <a href="{{ route('user.keranjang') }}" class="nav-link {{ request()->routeIs('user.keranjang') ? 'active' : '' }}">
                        <i class="bi bi-cart3 me-2"></i>Keranjang
                    </a>
                    <a href="{{ route('user.faktur.history') }}" class="nav-link {{ request()->routeIs('user.faktur.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt me-2"></i>Riwayat Faktur
                    </a>
                @endif
            @endauth
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="flex-grow-1 content-area">
        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
