<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') - Jupitaz Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/dashboard.css') }}?v={{ filemtime(public_path('css/dashboard.css')) }}" rel="stylesheet">
</head>
<body>
@php($user = auth()->user())
<div class="dashboard-shell">
    <aside class="dashboard-sidebar">
        <a class="dashboard-brand" href="{{ route('admin.dashboard') }}"><span class="dashboard-logo">J</span><span>Jupitaz Networking<small>Admin Panel</small></span></a>

        <div class="sidebar-section">
            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="sidebar-icon"><i class="bi bi-speedometer2"></i></span><span>Dashboard</span>
            </a>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-heading">Content Management</p>
            <a class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <span class="sidebar-icon"><i class="bi bi-grid-3x3-gap"></i></span><span>Categories</span>
            </a>
            <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <span class="sidebar-icon"><i class="bi bi-box-seam"></i></span><span>Products</span>
            </a>
            <a class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                <span class="sidebar-icon"><i class="bi bi-tags"></i></span><span>Brands</span>
            </a>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-heading">Sales</p>
            <a class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <span class="sidebar-icon"><i class="bi bi-cart3"></i></span><span>Orders</span>
            </a>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-heading">Account</p>
            <a class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                <span class="sidebar-icon"><i class="bi bi-person-circle"></i></span><span>Profile</span>
            </a>
            <a class="sidebar-link" href="{{ route('home') }}">
                <span class="sidebar-icon"><i class="bi bi-house-door"></i></span><span>View Website</span>
            </a>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="sidebar-link w-100 border-0 text-start" type="submit">
                    <span class="sidebar-icon"><i class="bi bi-box-arrow-right"></i></span><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="dashboard-main">
        <div class="dashboard-page-header">
            <div>
            @hasSection('dashboard-title')
                <h1 class="dashboard-title">@yield('dashboard-title')</h1>
            @endif
            @hasSection('dashboard-subtitle')
                <p class="text-muted mb-0">@yield('dashboard-subtitle')</p>
            @endif
            </div>
            @yield('dashboard-actions')
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
