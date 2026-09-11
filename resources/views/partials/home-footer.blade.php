<footer class="shop-footer">
    <div class="shop-container shop-footer-grid">
        <section><h2>Get in touch</h2><ul>
            @if($supportPhone)<li><a href="tel:{{ preg_replace('/\s+/', '', $supportPhone) }}">{{ $supportPhone }}</a></li>@endif
            @if($supportEmail)<li><a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></li>@endif
            <li><a href="{{ route('page.contact') }}">Contact Jupitaz</a></li>
        </ul></section>
        <section><h2>Shop</h2><ul>@foreach(['range-extenders' => 'Range Extenders', 'routers' => 'Routers', 'wireless-access-points' => 'Wireless Access Points', 'network-switches' => 'Network Switches', 'fibre-optic' => 'Fibre Optic Solutions'] as $slug => $label)<li><a href="{{ route('categories.show', $slug) }}">{{ $label }}</a></li>@endforeach</ul></section>
        <section><h2>Our Company</h2><ul><li><a href="{{ route('page.about') }}">About Us</a></li><li><a href="{{ route('brands.index') }}">Our Brands</a></li><li><a href="{{ route('blog.index') }}">Blog</a></li></ul></section>
        <section><h2>Account Info</h2><ul><li><a href="{{ auth()->check() ? route('dashboard') : route('login') }}">My Account</a></li>@foreach(['terms' => 'Terms And Conditions', 'delivery' => 'Delivery Policy', 'returns' => 'Returns And Refunds Policy', 'privacy' => 'Privacy Policy'] as $page => $label)<li><a href="{{ route('page.'.$page) }}">{{ $label }}</a></li>@endforeach</ul></section>
    </div>
    <div class="shop-copyright">© {{ date('Y') }} Jupitaz. All rights reserved.</div>
</footer>
