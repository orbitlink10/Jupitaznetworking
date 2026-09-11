@extends('layouts.app')

@php
    $hasFilters = request()->hasAny(['q', 'brand', 'category', 'sort', 'min_price', 'max_price', 'in_stock']);
    $base = route('products.index');
@endphp

@section('title', request('q') ? 'Search: '.request('q').' | Jupitaz' : 'Networking Products in Kenya | Jupitaz')
@section('meta_description', request('q') ? 'Search results for '.request('q').' at Jupitaz — networking equipment in Kenya.' : 'Browse networking products in Kenya at Jupitaz. Routers, switches, wireless access points, fibre optic and ISP equipment from MikroTik, Ubiquiti, TP-Link and more.')

@if($hasFilters)
    @section('robots', 'noindex, follow')
    @section('canonical', $base)
@elseif($products->currentPage() > 1)
    @section('canonical', $base.'?page='.$products->currentPage())
@endif

@push('head')
    @if(!$hasFilters)
        @if($products->previousPageUrl())<link rel="prev" href="{{ $products->previousPageUrl() }}">@endif
        @if($products->nextPageUrl())<link rel="next" href="{{ $products->nextPageUrl() }}">@endif
    @endif
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-0">{{ request('q') ? 'Search results for "'.e(request('q')).'"' : 'Networking Products in Kenya' }}</h1>
            <p class="text-muted mb-0">{{ $products->total() }} product(s)</p>
        </div>
        <form action="{{ route('products.index') }}" method="get" class="d-flex align-items-center gap-2">
            @foreach(request()->except(['sort', 'page']) as $k => $v)
                @if(!is_array($v))<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endif
            @endforeach
            <label class="text-nowrap small text-muted" for="sort">Sort</label>
            <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Featured</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low to High</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High to Low</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Name: A to Z</option>
            </select>
        </form>
    </div>

    <div class="row g-4">
        <aside class="col-lg-3">
            <form action="{{ route('products.index') }}" method="get" class="card border-0 shadow-sm p-3">
                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                <h2 class="h6 fw-bold">Filters</h2>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" for="f-cat">Category</label>
                    <select name="category" id="f-cat" class="form-select form-select-sm">
                        <option value="">All categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" for="f-brand">Brand</label>
                    <select name="brand" id="f-brand" class="form-select form-select-sm">
                        <option value="">All brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Price (KSh)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control form-control-sm" placeholder="Min">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control form-control-sm" placeholder="Max">
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="f-stock" @checked(request('in_stock'))>
                    <label class="form-check-label small" for="f-stock">In stock only</label>
                </div>
                <button type="submit" class="btn btn-brand btn-sm w-100">Apply filters</button>
                @if($hasFilters)<a href="{{ route('products.index') }}" class="btn btn-link btn-sm w-100 mt-1">Clear</a>@endif
            </form>
        </aside>

        <div class="col-lg-9">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No products found. Try a different search term or filter.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($products as $product)
                        <div class="col-6 col-md-4">@include('partials.product-card', ['product' => $product])</div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
