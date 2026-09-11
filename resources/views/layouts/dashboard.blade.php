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
    <style>
        :root {
            --dash-bg:#eef3f9;
            --dash-green:#0d6efd;
            --dash-navy:#0b1f3a;
        }
        body, button, input, select, textarea { font-family:'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; }
        body { margin:0; background:#f4f6fb; color:#212529; }
        .dashboard-shell { min-height:100vh; display:grid; grid-template-columns:250px minmax(0,1fr); }
        .dashboard-sidebar { background:var(--dash-navy); padding:24px 16px; position:sticky; top:0; height:100vh; overflow-y:auto; }
        .dashboard-brand { display:flex; align-items:center; gap:10px; color:#fff; font-size:1.15rem; font-weight:700; text-decoration:none; padding:4px 8px 20px; }
        .sidebar-heading { color:#8fa6c4; font-size:.74rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; margin:18px 10px 8px; }
        .sidebar-link { display:grid; grid-template-columns:30px 1fr; align-items:center; gap:10px; padding:9px 12px; color:#c9d6e8; text-decoration:none; font-size:.95rem; border-radius:8px; margin-bottom:2px; }
        .sidebar-link:hover, .sidebar-link.active { background:#1d3a63; color:#fff; }
        .sidebar-icon { color:#8fa6c4; }
        .sidebar-link:hover .sidebar-icon, .sidebar-link.active .sidebar-icon { color:#fff; }
        .dashboard-main { min-width:0; padding:24px; }
        .dashboard-title { margin:0 0 4px; font-size:1.6rem; font-weight:700; color:#0f172a; }
        .card { border:0; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,.06); }
        .metric .card-body { display:flex; flex-direction:column; justify-content:center; min-height:86px; }
        .btn-brand { background:var(--dash-green); color:#fff; border:0; }
        .btn-brand:hover { background:#0b5ed7; color:#fff; }
        @media (max-width: 991.98px) {
            .dashboard-shell { display:block; }
            .dashboard-sidebar { position:relative; width:100%; height:auto; }
            .dashboard-main { padding:16px; }
        }
    </style>
</head>
<body>
@php($user = auth()->user())
<div class="dashboard-shell">
    <aside class="dashboard-sidebar">
        <a class="dashboard-brand" href="{{ route('admin.dashboard') }}"><span>Jupitaz</span> <span class="badge text-bg-light">Admin</span></a>

        <div class="sidebar-section">
            <p class="sidebar-heading">Overview</p>
            <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="sidebar-icon"><i class="bi bi-speedometer2"></i></span><span>Dashboard</span>
            </a>
        </div>

        <div class="sidebar-section">
            <p class="sidebar-heading">Catalogue</p>
            <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <span class="sidebar-icon"><i class="bi bi-box-seam"></i></span><span>Products</span>
            </a>
            <a class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <span class="sidebar-icon"><i class="bi bi-grid-3x3-gap"></i></span><span>Categories</span>
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
        <div class="mb-4">
            @hasSection('dashboard-title')
                <h1 class="dashboard-title">@yield('dashboard-title')</h1>
            @endif
            @hasSection('dashboard-subtitle')
                <p class="text-muted mb-0">@yield('dashboard-subtitle')</p>
            @endif
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
