@extends('layouts.app')

@php
    $breadcrumbs = [];
    $cat = $product->primaryCategory();
    foreach ($cat?->ancestors() ?? [] as $ancestor) {
        $breadcrumbs[] = ['name' => $ancestor->name, 'url' => route('categories.show', $ancestor->path())];
    }
    if ($cat) {
        $breadcrumbs[] = ['name' => $cat->name, 'url' => route('categories.show', $cat->path())];
    }
    if ($product->brand) {
        $breadcrumbs[] = ['name' => $product->brand->name, 'url' => route('brands.show', $product->brand->slug)];
    }
    $breadcrumbs[] = ['name' => $product->name, 'url' => null];
@endphp

@section('title', $product->seoTitle())
@section('meta_description', $product->seoDescription())
@section('canonical', $product->canonical_url ?: route('products.show', $product->slug))
@section('og_image', $product->imageUrl())

@section('schema')
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'image' => $product->imageUrl(),
        'description' => \Illuminate\Support\Str::limit(strip_tags((string) $product->short_description), 300),
        'sku' => $product->sku,
        'url' => route('products.show', $product->slug),
    ];
    if ($product->brand) {
        $schema['brand'] = ['@type' => 'Brand', 'name' => $product->brand->name];
    }
    if ($product->hasPrice()) {
        $schema['offers'] = [
            '@type' => 'Offer',
            'url' => route('products.show', $product->slug),
            'priceCurrency' => 'KES',
            'price' => (string) $product->price,
            'availability' => $product->inStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
        ];
    }

    $breadcrumbList = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [],
    ];
    $all = array_merge([['name' => 'Home', 'url' => route('home')]], $breadcrumbs);
    foreach ($all as $i => $b) {
        $breadcrumbList['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $b['name'],
            'item' => $b['url'] ?? route('products.show', $product->slug),
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
@include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="container py-4">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="bg-white border rounded p-4 d-grid" style="place-items:center;">
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="img-fluid" style="max-height:460px;object-fit:contain;">
            </div>
        </div>

        <div class="col-lg-6">
            @if($product->brand)<a href="{{ route('brands.show', $product->brand->slug) }}" class="text-uppercase small fw-bold text-primary">{{ $product->brand->name }}</a>@endif
            <h1 class="fw-bold mt-1">{{ $product->name }}</h1>

            <div class="fs-3 fw-bold text-brand my-2">
                @if($product->hasPrice())
                    {{ $product->formattedPrice() }}
                @else
                    <span class="text-muted">Call for Price</span>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
                @if($product->inStock())
                    <span class="badge badge-stock">In Stock</span>
                    <span class="small text-muted">{{ $product->stock_quantity }} units available</span>
                @else
                    <span class="badge text-bg-secondary">Out of Stock</span>
                @endif
                @if($product->sku)<span class="small text-muted">SKU: {{ $product->sku }}</span>@endif
            </div>

            @if($product->short_description)
                <p class="lead" style="font-size:1.05rem;">{{ $product->short_description }}</p>
            @endif

            <div class="d-flex flex-wrap gap-2 my-4">
                @if($product->inStock())
                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-brand btn-lg"><i class="bi bi-cart-plus me-1"></i> Add to Cart</button>
                    </form>
                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="buy_now" value="1">
                        <button type="submit" class="btn btn-accent btn-lg">Buy Now</button>
                    </form>
                @else
                    <a href="{{ route('page.contact') }}" class="btn btn-outline-brand btn-lg">Enquire About Availability</a>
                @endif
                @if($supportWhatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $supportWhatsapp) }}?text={{ urlencode('Hello, I would like to ask about '.$product->name) }}" target="_blank" rel="noopener" class="btn btn-success btn-lg"><i class="bi bi-whatsapp me-1"></i> Ask on WhatsApp</a>
                @endif
            </div>

            <div class="small text-muted">
                <i class="bi bi-truck me-1"></i> Delivery available · <i class="bi bi-shield-check me-1"></i> Warranty as provided by manufacturer · <i class="bi bi-headset me-1"></i> Product guidance from our team
            </div>
        </div>
    </div>

    <div class="row g-5 mt-2">
        <div class="col-lg-8">
            @if($product->key_features)
                <section class="mb-4">
                    <h2 class="section-heading h4">Key Features</h2>
                    <ul>
                        @foreach($product->key_features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if($product->description)
                <section class="mb-4">
                    <h2 class="section-heading h4">Product Details</h2>
                    <div>{!! $product->description !!}</div>
                </section>
            @endif

            @if($product->specifications)
                <section class="mb-4">
                    <h2 class="section-heading h4">Technical Specifications</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered spec-table bg-white">
                            <tbody>
                                @foreach($product->specifications as $spec)
                                    <tr>
                                        <th scope="row">{{ $spec['label'] ?? '' }}</th>
                                        <td>{{ $spec['value'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif

            <section class="mb-4">
                <h2 class="section-heading h4">Why Buy From Jupitaz</h2>
                <p>Jupitaz is a networking-focused equipment supplier serving customers in Kenya. We list a specialist range of routers, switches, wireless and fibre products so you can compare current pricing and availability in one place. Our team can help you choose the right equipment for home, business, ISP or FTTH projects, and delivery options are available across Kenya.</p>
            </section>

            <section class="mb-4">
                <h2 class="section-heading h4">Frequently Asked Questions</h2>
                <div class="accordion" id="productFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pf1">What is the price of {{ $product->name }} in Kenya?</button></h2>
                        <div id="pf1" class="accordion-collapse collapse show" data-bs-parent="#productFaq">
                            <div class="accordion-body">@if($product->hasPrice())The current listed price is {{ $product->formattedPrice() }}.@else Please contact us for the current price of this product.@endif</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pf2">Is {{ $product->name }} in stock?</button></h2>
                        <div id="pf2" class="accordion-collapse collapse" data-bs-parent="#productFaq">
                            <div class="accordion-body">@if($product->inStock())Yes, this product is currently in stock.@else This product is currently out of stock — please contact us for the next availability.@endif</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pf3">How do I order {{ $product->name }}?</button></h2>
                        <div id="pf3" class="accordion-collapse collapse" data-bs-parent="#productFaq">
                            <div class="accordion-body">Add the product to your cart and complete checkout, or contact our team for a quote and delivery arrangement.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            @if($related->isNotEmpty())
                <h2 class="h5 fw-bold mb-3">Related Products</h2>
                <div class="row g-3">
                    @foreach($related as $rel)
                        <div class="col-6 col-lg-12">@include('partials.product-card', ['product' => $rel])</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
