@extends('layouts.app')

@php
    $base = route('brands.show', $brand->slug);
@endphp

@section('title', $brand->meta_title ?: $brand->name.' Products & Prices in Kenya | Jupitaz')
@section('meta_description', $brand->meta_description ?: 'Shop '.$brand->name.' networking products in Kenya at Jupitaz. Compare current prices, specifications and availability.')

@if(request()->hasAny(['sort']))
    @section('robots', 'noindex, follow')
    @section('canonical', $base)
@elseif($products->currentPage() > 1)
    @section('canonical', $base.'?page='.$products->currentPage())
@endif

@section('schema')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Brand',
    'name' => $brand->name,
    'url' => $base,
    'description' => $brand->description,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
<div class="container py-4">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
            <li class="breadcrumb-item active">{{ $brand->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="fw-bold">{{ $brand->name }} Networking Products in Kenya</h1>
            <p class="text-muted mb-0" style="max-width:760px;">{{ $brand->description }}</p>
        </div>
        <form action="{{ $base }}" method="get" class="d-flex align-items-center gap-2">
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Sort: Featured</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low to High</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High to Low</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Name: A to Z</option>
            </select>
        </form>
    </div>

    @if($products->isEmpty())
        <p class="text-muted">No products for this brand yet.</p>
    @else
        <div class="row g-3">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">@include('partials.product-card', ['product' => $product])</div>
            @endforeach
        </div>
        <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
