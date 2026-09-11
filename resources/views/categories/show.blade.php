@extends('layouts.app')

@php
    $hasFilters = request()->hasAny(['brand', 'in_stock', 'sort']);
    $base = route('categories.show', $category->path());
    $breadcrumbs = [];
    foreach ($ancestors as $ancestor) {
        $breadcrumbs[] = ['name' => $ancestor->name, 'url' => route('categories.show', $ancestor->path())];
    }
    $breadcrumbs[] = ['name' => $category->name, 'url' => null];
@endphp

@section('title', $category->meta_title ?: $category->name.' Prices in Kenya | Jupitaz')
@section('meta_description', $category->meta_description ?: 'Shop '.strtolower($category->name).' in Kenya at Jupitaz. Compare prices, specifications and stock from leading networking brands.')

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

@section('schema')
@php
    $items = [];
    $all = array_merge([['name' => 'Home', 'url' => route('home')]], $breadcrumbs);
    foreach ($all as $i => $b) {
        $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $b['name'], 'item' => $b['url'] ?? $base];
    }
@endphp
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $items,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $category->name,
    'url' => $base,
    'description' => $category->description ?: $category->name.' in Kenya from Jupitaz.',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
@include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

<div class="container py-4">
    <h1 class="fw-bold">{{ $category->name }}</h1>
    @if($category->description)
        <p class="text-muted" style="max-width:820px;">{{ $category->description }}</p>
    @endif

    @if($category->children->isNotEmpty())
        <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach($category->children as $child)
                <a href="{{ route('categories.show', $child->path()) }}" class="btn btn-outline-brand btn-sm">{{ $child->name }}</a>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        <aside class="col-lg-3">
            <form action="{{ $base }}" method="get" class="card border-0 shadow-sm p-3">
                <h2 class="h6 fw-bold">Filters</h2>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" for="f-brand">Brand</label>
                    <select name="brand" id="f-brand" class="form-select form-select-sm">
                        <option value="">All brands</option>
                        @foreach($category->products()->active()->with('brand')->get()->pluck('brand')->filter()->unique('id')->sortBy('name') as $brand)
                            <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="f-stock" @checked(request('in_stock'))>
                    <label class="form-check-label small" for="f-stock">In stock only</label>
                </div>
                <button type="submit" class="btn btn-brand btn-sm w-100">Apply filters</button>
                @if($hasFilters)<a href="{{ $base }}" class="btn btn-link btn-sm w-100 mt-1">Clear</a>@endif
            </form>
        </aside>

        <div class="col-lg-9">
            @if($products->isEmpty())
                <div class="text-center py-5"><p class="text-muted">No products in this category yet.</p></div>
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

    @if($category->content)
        <div class="mt-5 bg-white border rounded p-4" style="max-width:900px;">
            <div class="category-content">{!! $category->content !!}</div>
        </div>
    @endif
</div>
@endsection
