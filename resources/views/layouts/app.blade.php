<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Networking Equipment in Kenya | Jupitaz')</title>
    <meta name="description" content="@yield('meta_description', 'Shop networking equipment in Kenya from Jupitaz — routers, switches, wireless access points, fibre optic, structured cabling and ISP equipment from MikroTik, Ubiquiti, TP-Link and more.')">
    @hasSection('canonical')
        <link rel="canonical" href="@yield('canonical')">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif
    @hasSection('robots')
        <meta name="robots" content="@yield('robots')">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Jupitaz">
    <meta property="og:title" content="@yield('title', 'Networking Equipment in Kenya | Jupitaz')">
    <meta property="og:description" content="@yield('meta_description', 'Shop networking equipment in Kenya from Jupitaz.')">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Networking Equipment in Kenya | Jupitaz')">
    <meta name="twitter:description" content="@yield('meta_description', 'Shop networking equipment in Kenya from Jupitaz.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Cardo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @stack('head')
    @stack('styles')
    <style>
        :root {
            --jp-primary:#A7144C;
            --jp-primary-2:#8a0f3e;
            --jp-accent:#FF9803;
            --jp-accent-2:#e08600;
            --jp-blue:#066aab;
            --jp-green:#5fbd74;
            --jp-dark:#32373c;
            --jp-ink:#434343;
            --jp-muted:#6b7280;
            --jp-soft:#f7f7f9;
            --jp-line:#e7e7ec;
        }
        body { background:#ffffff; color:var(--jp-ink); font-family:'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; font-size:1rem; }
        a { text-decoration:none; }
        h1, h2, h3, h4, h5, .section-heading { font-family:'Cardo', 'Inter', serif; letter-spacing:.01em; }
        .text-brand { color:var(--jp-primary); }
        .bg-brand { background:var(--jp-primary); }
        .btn-brand { background:var(--jp-accent); color:#1a1a1a; border:0; font-weight:700; }
        .btn-brand:hover { background:var(--jp-accent-2); color:#1a1a1a; }
        .btn-accent { background:var(--jp-accent); color:#1a1a1a; border:0; font-weight:700; }
        .btn-accent:hover { background:var(--jp-accent-2); color:#1a1a1a; }
        .btn-outline-brand { border:1px solid var(--jp-primary); color:var(--jp-primary); font-weight:600; }
        .btn-outline-brand:hover { background:var(--jp-primary); color:#fff; }

        .topbar { background:var(--jp-dark); color:#d5d9dd; font-size:.85rem; }
        .topbar a { color:#d5d9dd; }
        .topbar a:hover { color:#fff; }

        .main-header { background:#fff; border-bottom:1px solid var(--jp-line); }
        .logo-mark { width:42px; height:42px; border-radius:10px; background:linear-gradient(135deg,var(--jp-primary),var(--jp-accent)); display:grid; place-items:center; color:#fff; font-weight:800; font-size:1.2rem; }
        .brand-name { font-family:'Cardo', serif; font-weight:700; color:var(--jp-primary); font-size:1.5rem; letter-spacing:.01em; }
        .search-form { max-width:520px; }
        .search-form input { border-radius:.5rem 0 0 .5rem; border:1px solid var(--jp-line); border-right:0; }
        .search-form button { border-radius:0 .5rem .5rem 0; background:var(--jp-primary); color:#fff; border:0; }

        .nav-main { background:#fff; border-bottom:1px solid var(--jp-line); }
        .nav-main .navbar-toggler { border-color:var(--jp-line); }
        .nav-main .nav-link { color:var(--jp-ink); font-weight:600; font-size:.95rem; padding:.8rem .9rem; }
        .nav-main .nav-link:hover, .nav-main .nav-link.active { color:var(--jp-primary); }
        .nav-main .nav-link.active { border-bottom:2px solid var(--jp-primary); }
        .nav-main .dropdown-menu { border:0; box-shadow:0 18px 40px rgba(50,55,60,.18); border-radius:.6rem; padding:.5rem; }
        .nav-main .dropdown-item { border-radius:.4rem; font-size:.92rem; padding:.5rem .75rem; color:var(--jp-ink); }
        .nav-main .dropdown-item:hover { background:var(--jp-soft); color:var(--jp-primary); }
        .mega-menu { min-width:520px; }

        .product-card { border:1px solid var(--jp-line); border-radius:.8rem; background:#fff; height:100%; transition:transform .15s ease, box-shadow .15s ease; }
        .product-card:hover { transform:translateY(-3px); box-shadow:0 14px 30px rgba(50,55,60,.10); }
        .product-card .thumb { aspect-ratio:1/1; background:#fff; display:grid; place-items:center; padding:1rem; border-bottom:1px solid var(--jp-line); }
        .product-card .thumb img { max-width:100%; max-height:100%; object-fit:contain; }
        .product-card .pname { color:var(--jp-ink); font-weight:600; font-size:.98rem; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:2.7rem; }
        .product-card .pbrand { font-size:.78rem; color:var(--jp-primary); text-transform:uppercase; letter-spacing:.04em; font-weight:700; }
        .product-card .pprice { font-weight:800; color:var(--jp-primary); font-size:1.05rem; }
        .badge-stock { background:#e8f6ee; color:#2f7d4f; font-weight:600; }
        .badge-enquire { background:#fff4e5; color:#a96400; font-weight:600; }

        .section { padding:52px 0; }
        .section-heading { font-weight:700; color:var(--jp-ink); }
        .hero { background:linear-gradient(115deg, rgba(167,20,76,.97), rgba(138,15,62,.94)), radial-gradient(circle at 80% 20%, rgba(255,152,3,.35), transparent 55%); color:#fff; }
        .hero h1 { font-family:'Cardo', serif; font-weight:700; font-size:clamp(2.1rem, 4vw, 3.4rem); }
        .hero .lead { color:#ffe4ee; max-width:640px; }

        .brand-band { background:var(--jp-dark); color:#fff; }
        .brand-band .brand-chip { display:inline-block; padding:.45rem 1rem; border:1px solid rgba(255,255,255,.25); border-radius:2rem; color:#fff; font-size:.9rem; font-weight:600; transition:all .15s ease; }
        .brand-band .brand-chip:hover { background:var(--jp-accent); border-color:var(--jp-accent); color:#1a1a1a; }

        .cat-tile { background:#fff; border:1px solid var(--jp-line); border-radius:.8rem; padding:1.2rem; height:100%; display:flex; align-items:center; gap:.9rem; transition:transform .15s ease, box-shadow .15s ease; }
        .cat-tile:hover { transform:translateY(-3px); box-shadow:0 12px 26px rgba(50,55,60,.10); border-color:var(--jp-primary); }
        .cat-tile .ico { width:48px; height:48px; border-radius:.7rem; background:var(--jp-soft); color:var(--jp-primary); display:grid; place-items:center; font-size:1.4rem; flex:0 0 auto; }

        .breadcrumb { --bs-breadcrumb-divider:'›'; font-size:.88rem; margin:0; }
        .breadcrumb a { color:var(--jp-primary); }

        .feature-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; }
        .feature-item { background:#fff; border:1px solid var(--jp-line); border-radius:.8rem; padding:1.2rem; }

        .spec-table td, .spec-table th { font-size:.94rem; }
        .spec-table th { width:40%; }

        .site-footer { background:var(--jp-dark); color:#c7cdd3; margin-top:64px; }
        .site-footer a { color:#c7cdd3; }
        .site-footer a:hover { color:var(--jp-accent); }
        .site-footer .ftitle { color:#fff; font-weight:700; font-size:1rem; margin-bottom:1rem; }
        .site-footer .list-unstyled a { font-size:.9rem; }
        .footer-bottom { border-top:1px solid rgba(255,255,255,.12); }
        .whatsapp-float { position:fixed; right:18px; bottom:18px; z-index:1050; width:52px; height:52px; border-radius:50%; background:#25d366; color:#fff; display:grid; place-items:center; font-size:1.7rem; box-shadow:0 8px 20px rgba(0,0,0,.25); }
    </style>
</head>
<body class="{{ request()->routeIs('home') ? 'storefront-home' : '' }}">
@if(request()->routeIs('home'))
    @include('partials.home-header')
@else
<header>
    <div class="topbar py-2">
        <div class="container d-flex justify-content-between flex-wrap gap-2">
            <div class="d-flex gap-3">
                @if($supportPhone)<a href="tel:{{ preg_replace('/\s+/', '', $supportPhone) }}"><i class="bi bi-telephone-fill me-1"></i>{{ $supportPhone }}</a>@endif
                @if($supportEmail)<a href="mailto:{{ $supportEmail }}"><i class="bi bi-envelope-fill me-1"></i>{{ $supportEmail }}</a>@endif
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('page.delivery') }}">Delivery</a>
                <a href="{{ route('page.contact') }}">Contact</a>
            </div>
        </div>
    </div>

    <div class="main-header py-3">
        <div class="container">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('home') }}" class="d-flex align-items-center gap-2">
                    <span class="logo-mark">J</span>
                    <span class="brand-name">Jupitaz</span>
                </a>

                <form class="search-form flex-grow-1 d-none d-md-flex" action="{{ route('products.index') }}" method="get" role="search">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by product, model or brand (e.g. RB5009, CPE510, Cat6)" aria-label="Search products">
                    <button type="submit" class="btn px-3" aria-label="Search"><i class="bi bi-search"></i></button>
                </form>

                <div class="ms-auto d-flex align-items-center gap-2">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-brand position-relative">
                        <i class="bi bi-cart3 me-1"></i> Cart
                        @if($cartCount > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>@endif
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-brand"><i class="bi bi-person me-1"></i> Account</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-brand"><i class="bi bi-person me-1"></i> Login</a>
                    @endauth
                </div>
            </div>
            <form class="search-form d-md-none mt-2" action="{{ route('products.index') }}" method="get">
                <div class="d-flex">
                    <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search products, models, brands" aria-label="Search products">
                    <button type="submit" class="btn btn-brand" aria-label="Search"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <nav class="nav-main navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav align-items-lg-center gap-lg-1 flex-wrap">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">All Products</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('brands.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Our Brands</a>
                        <ul class="dropdown-menu">
                            @foreach($navBrands as $brand)
                                <li><a class="dropdown-item" href="{{ route('brands.show', $brand->slug) }}">{{ $brand->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @foreach($navCategories as $cat)
                        @if($cat->children->isNotEmpty())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ route('categories.show', $cat->slug) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $cat->name }}</a>
                                <ul class="dropdown-menu mega-menu">
                                    <li><a class="dropdown-item fw-semibold" href="{{ route('categories.show', $cat->slug) }}">All {{ $cat->name }}</a></li>
                                    @foreach($cat->children as $child)
                                        <li><a class="dropdown-item" href="{{ route('categories.show', $cat->slug.'/'.$child->slug) }}">{{ $child->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endif
                    @endforeach
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
@endif

<main>
    @if(session('success'))
        <div class="container mt-3"><div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>
    @endif
    @if($errors->any())
        <div class="container mt-3"><div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $errors->first() }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div>
    @endif
    @yield('content')
</main>

@if(request()->routeIs('home'))
    @include('partials.home-footer')
@else
<footer class="site-footer pt-5">
    <div class="container">
        <div class="row g-4 pb-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="logo-mark">J</span>
                    <span class="fs-4 fw-bold text-white">Jupitaz</span>
                </div>
                <p class="small">Networking equipment supplier in Kenya. Routers, switches, wireless access points, fibre optic, structured cabling, CCTV and ISP networking products from leading global brands.</p>
                @if($supportWhatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $supportWhatsapp) }}" class="btn btn-success btn-sm"><i class="bi bi-whatsapp me-1"></i> Chat on WhatsApp</a>
                @endif
            </div>
            <div class="col-lg-2 col-6">
                <div class="ftitle">Shop</div>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('products.index') }}">All Products</a></li>
                    <li><a href="{{ route('categories.show', 'routers') }}">Routers</a></li>
                    <li><a href="{{ route('categories.show', 'network-switches') }}">Network Switches</a></li>
                    <li><a href="{{ route('categories.show', 'wireless-access-points') }}">Access Points</a></li>
                    <li><a href="{{ route('categories.show', 'fibre-optic') }}">Fibre Optic</a></li>
                    <li><a href="{{ route('categories.show', 'structured-cabling') }}">Structured Cabling</a></li>
                    <li><a href="{{ route('categories.show', 'isp-equipment') }}">ISP Equipment</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <div class="ftitle">Brands</div>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('brands.show', 'mikrotik') }}">MikroTik</a></li>
                    <li><a href="{{ route('brands.show', 'ubiquiti') }}">Ubiquiti</a></li>
                    <li><a href="{{ route('brands.show', 'tp-link') }}">TP-Link</a></li>
                    <li><a href="{{ route('brands.show', 'd-link') }}">D-Link</a></li>
                    <li><a href="{{ route('brands.show', 'tenda') }}">Tenda</a></li>
                    <li><a href="{{ route('brands.index') }}">All Brands</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <div class="ftitle">Company</div>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('page.about') }}">About Us</a></li>
                    <li><a href="{{ route('page.contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('page.faq') }}">FAQ</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <div class="ftitle">Information</div>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('page.delivery') }}">Delivery</a></li>
                    <li><a href="{{ route('page.returns') }}">Returns &amp; Refunds</a></li>
                    <li><a href="{{ route('page.warranty') }}">Warranty</a></li>
                    <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('page.terms') }}">Terms &amp; Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom py-3 d-flex flex-wrap justify-content-between gap-2 small">
            <span>© {{ date('Y') }} Jupitaz. Networking equipment in Kenya.</span>
            <span>Routers · Switches · Wireless · Fibre Optic · CCTV · ISP Equipment</span>
        </div>
    </div>
</footer>
@endif

@if($supportWhatsapp)
    <a class="whatsapp-float" href="https://wa.me/{{ preg_replace('/\D/', '', $supportWhatsapp) }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

@if(!trim($__env->yieldContent('schema')))
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Jupitaz',
        'url' => url('/'),
        'description' => 'Networking equipment supplier in Kenya: routers, switches, wireless access points, fibre optic and ISP equipment.',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endif
@yield('schema')
</body>
</html>
