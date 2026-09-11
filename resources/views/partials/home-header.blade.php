<header class="shop-header">
    <div class="shop-header-inner">
        <a class="shop-logo" href="{{ route('home') }}" aria-label="Jupitaz home"><span class="shop-logo-mark">J</span><span>JUPITAZ<small>NETWORKING SOLUTIONS</small></span></a>
        <form class="shop-search" action="{{ route('products.index') }}" method="get" role="search">
            <input type="search" name="q" placeholder="Search products…" aria-label="Search products" required>
            <button type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
        </form>
        <div class="shop-actions">
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"><i class="bi bi-person"></i><span>Account</span></a>
            <a href="{{ route('cart.index') }}"><i class="bi bi-bag"></i><span>Cart ({{ $cartCount }})</span></a>
        </div>
    </div>
    <nav class="shop-navigation" aria-label="Main navigation">
        <div class="shop-nav-inner">
            <details class="shop-menu"><summary>Our Brands</summary><div class="shop-dropdown">@foreach($navBrands as $brand)<a href="{{ route('brands.show', $brand->slug) }}">{{ $brand->name }}</a>@endforeach</div></details>
            @php($menus = [
                'Wireless Devices' => ['wireless-cpe' => 'Wireless Outdoor CPE', 'wireless-access-points' => 'Wireless Access Points', 'routers' => 'Routers', 'network-switches' => 'Network Switches', 'range-extenders' => 'Range Extenders', 'point-to-point-antennas' => 'Point to point Antennas'],
                'Structured Cabling' => ['structured-cabling' => 'Structured Cabling', 'ethernet-cables' => 'Ethernet Cables', 'network-cabinets' => 'Network Cabinets', 'media-converters' => 'Media Converters', 'poe-equipment' => 'POE Injectors'],
                'Fibre Optic Solutions' => ['fibre-optic' => 'Fibre Optic Solutions', 'fibre-optic-cables' => 'Fibre Optic Cables', 'plc-splitters' => 'PLC Splitters', 'fibre-patch-cords' => 'Patch Cords & Pigtails'],
                'Security Cameras' => ['cctv-security' => 'CCTV Security Cameras', 'access-control' => 'Access Control'],
                'PBX + Phones' => ['ip-telephony' => 'PBX + Phones'],
            ])
            @foreach($menus as $label => $items)
                <details class="shop-menu"><summary>{{ $label }}</summary><div class="shop-dropdown">@foreach($items as $slug => $name)
                    @php($category = $navCategories->concat($navCategories->flatMap->children)->firstWhere('slug', $slug))
                    <a href="{{ $category ? route('categories.show', $category->slug) : route('products.index', ['q' => $name]) }}">{{ $name }}</a>
                @endforeach</div></details>
            @endforeach
        </div>
    </nav>
</header>
