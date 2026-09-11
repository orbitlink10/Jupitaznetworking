@php
    $product = $product ?? null;
@endphp
@if($product)
    <div class="product-card h-100 d-flex flex-column">
        <a href="{{ route('products.show', $product->slug) }}" class="thumb">
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy" width="400" height="400">
        </a>
        <div class="p-3 d-flex flex-column flex-grow-1">
            @if($product->brand)
                <span class="pbrand">{{ $product->brand->name }}</span>
            @endif
            <a href="{{ route('products.show', $product->slug) }}" class="pname mt-1">{{ $product->name }}</a>
            <div class="mt-2 mb-2">
                @if($product->hasPrice())
                    <span class="pprice">{{ $product->formattedPrice() }}</span>
                @else
                    <span class="text-muted fw-semibold">Call for price</span>
                @endif
            </div>
            <div class="mt-auto d-flex align-items-center justify-content-between">
                @if($product->inStock())
                    <span class="badge badge-stock">In Stock</span>
                @else
                    <span class="badge text-bg-secondary">Out of Stock</span>
                @endif
                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-brand">View</a>
            </div>
            @if($product->inStock())
                <form action="{{ route('cart.add') }}" method="post" class="mt-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-sm btn-outline-brand w-100">Add to Cart</button>
                </form>
            @endif
        </div>
    </div>
@endif
