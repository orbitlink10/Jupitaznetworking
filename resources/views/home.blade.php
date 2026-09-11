@extends('layouts.app')
@section('title', 'Networking Tools & Accessories | Jupitaz Kenya')
@section('meta_description', 'Shop Ubiquiti, MikroTik, TP-Link and D-Link networking equipment at Jupitaz Kenya. Routers, wireless devices, switches and fibre optic solutions.')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}?v=1">
@endpush
@section('content')
<div class="shop-container shop-catalogue">
    <h1 class="visually-hidden">Networking Tools &amp; Accessories</h1>
    @foreach($brandShowcase as $slug => $entry)
        <section class="shop-brand-section" aria-labelledby="heading-{{ $slug }}">
            <div class="shop-section-heading">
                <h2 id="heading-{{ $slug }}">{{ ['ubiquiti' => 'Ubiquiti Networking Devices', 'mikrotik' => 'Mikrotik', 'tp-link' => 'Tp-Link', 'd-link' => 'D-link'][$slug] ?? $entry['brand']->name }}</h2>
                <a class="shop-more" href="{{ route('brands.show', $slug) }}" aria-label="Browse all {{ $entry['brand']->name }} products"><i class="bi bi-chevron-right"></i></a>
            </div>
            <div class="shop-product-grid">
                @foreach($entry['products'] as $product)
                    <article class="shop-product">
                        <a class="shop-product-image" href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" width="300" height="300" loading="{{ $loop->parent->first ? 'eager' : 'lazy' }}">
                            @if(!$product->inStock())<span class="shop-stock-label">Out Of Stock</span>@elseif($product->is_featured)<span class="shop-hot-label">Hot</span>@endif
                        </a>
                        <h3><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        <div class="shop-product-price">{{ $product->formattedPrice() ?: 'Call for price' }}</div>
                        <div class="shop-product-action">
                            @if($product->inStock() && $product->hasPrice())
                                <form action="{{ route('cart.add') }}" method="post">@csrf<input type="hidden" name="product_id" value="{{ $product->id }}"><input type="hidden" name="quantity" value="1"><button type="submit"><i class="bi bi-bag-plus"></i> Add to cart</button></form>
                            @else
                                <a href="{{ route('products.show', $product->slug) }}">View product <i class="bi bi-arrow-right"></i></a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach
    <section class="shop-about">
        <h2>About Jupitaz</h2>
        <p>Jupitaz supplies networking equipment in Kenya, with routers, switches, wireless access points and surveillance systems from brands including MikroTik, Ubiquiti, TP-Link and D-Link. Explore products for home networks, businesses, installers and internet service providers.</p>
        <p>Browse our range of fibre optic equipment, structured cabling and wireless networking devices, or contact our team for help choosing the right equipment and arranging delivery.</p>
    </section>
</div>
@endsection
@push('scripts')
<script>
const shopMenus = document.querySelectorAll('.shop-menu');
shopMenus.forEach(menu => menu.addEventListener('toggle', () => {
    if (menu.open) shopMenus.forEach(other => { if (other !== menu) other.open = false; });
}));
document.addEventListener('click', event => {
    if (!event.target.closest('.shop-menu')) shopMenus.forEach(menu => menu.open = false);
});
document.addEventListener('keydown', event => {
    if (event.key === 'Escape') shopMenus.forEach(menu => { if (menu.open) { menu.open = false; menu.querySelector('summary').focus(); } });
});
</script>
@endpush
