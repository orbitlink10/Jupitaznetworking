@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('dashboard-title', 'Dashboard')
@section('dashboard-subtitle', 'View and manage customer orders, products, and your networking catalogue.')
@section('dashboard-eyebrow')
    <span class="dashboard-pill">Admin Overview</span>
@endsection
@section('dashboard-actions')
    <div class="dashboard-actions">
        <a class="btn btn-brand" href="{{ route('admin.products.create') }}">+ New Product</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.products.index') }}">Manage Products</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.orders.index') }}">Manage Orders</a>
    </div>
@endsection
@section('content')
<div class="dashboard-breadcrumb">Admin <span class="mx-2">/</span> Overview</div>
<div class="dashboard-metrics">
    <article class="card overview-card metric-blue">
        <span class="overview-icon">OR</span><p class="overview-label">Orders</p>
        <h2 class="overview-number">{{ $orderCount }}</h2><small>{{ $pendingOrderCount }} pending orders</small>
        <a class="overview-link" href="{{ route('admin.orders.index') }}">View orders <span aria-hidden="true">›</span></a>
    </article>
    <article class="card overview-card metric-teal">
        <span class="overview-icon">PR</span><p class="overview-label">Products</p>
        <h2 class="overview-number">{{ $productCount }}</h2><small>{{ $activeProductCount }} active products</small>
        <a class="overview-link" href="{{ route('admin.products.index') }}">View products <span aria-hidden="true">›</span></a>
    </article>
    <article class="card overview-card metric-dark">
        <span class="overview-icon">CA</span><p class="overview-label">Categories</p>
        <h2 class="overview-number">{{ $categoryCount }}</h2><small>Product categories and subcategories</small>
        <a class="overview-link" href="{{ route('admin.categories.index') }}">View categories <span aria-hidden="true">›</span></a>
    </article>
    <article class="card overview-card metric-red">
        <span class="overview-icon">BR</span><p class="overview-label">Brands</p>
        <h2 class="overview-number">{{ $brandCount }}</h2><small>Networking brands in your catalogue</small>
        <a class="overview-link" href="{{ route('admin.brands.index') }}">View brands <span aria-hidden="true">›</span></a>
    </article>
</div>
<div class="dashboard-metrics">
    <article class="card summary-card metric-dark"><p class="overview-label">Total Revenue</p><h2 class="overview-number">KSh {{ number_format($revenue) }}</h2><small>Confirmed, processing and completed orders</small></article>
    <article class="card summary-card metric-blue"><p class="overview-label">Recent Orders</p><h2 class="overview-number">{{ $recentOrders->count() }}</h2><small>Latest orders received</small></article>
    <article class="card summary-card metric-red"><p class="overview-label">Customers</p><h2 class="overview-number">{{ $customerCount }}</h2><small>Registered customer accounts</small></article>
    <article class="card summary-card metric-teal"><p class="overview-label">Active Products</p><h2 class="overview-number">{{ $activeProductCount }}</h2><small>Products available on the website</small></article>
</div>
<div class="dashboard-ops">
    <section class="card dashboard-section">
        <div class="dashboard-section-head"><div><p class="dashboard-section-kicker">Orders Desk</p><h2>Recent Orders</h2></div><a href="{{ route('admin.orders.index') }}" class="dashboard-section-meta">View all</a></div>
        <div class="table-responsive">
            <table class="table align-middle"><thead><tr><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Total</th><th scope="col">Status</th></tr></thead><tbody>
                @forelse($recentOrders as $order)
                    <tr><td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td><td>{{ $order->name }}</td><td class="text-nowrap">KSh {{ number_format($order->total) }}</td><td><span class="badge text-bg-secondary">{{ $order->statusLabel() }}</span></td></tr>
                @empty
                    <tr><td colspan="4" class="text-muted py-4">No orders yet.</td></tr>
                @endforelse
            </tbody></table>
        </div>
    </section>
    <section class="card dashboard-section">
        <div class="dashboard-section-head"><div><p class="dashboard-section-kicker">Catalog</p><h2>Latest Products</h2></div><a href="{{ route('admin.products.index') }}" class="dashboard-section-meta">View all</a></div>
        <div class="table-responsive">
            <table class="table align-middle"><thead><tr><th scope="col">Product</th><th scope="col">Price</th><th scope="col">Action</th></tr></thead><tbody>
                @forelse($recentProducts as $product)
                    <tr><td><div class="d-flex align-items-center gap-2"><img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" width="44" height="40" style="object-fit:contain" loading="lazy"><div>{{ $product->name }}<small class="d-block text-muted">{{ $product->brand?->name ?? 'No brand' }}</small></div></div></td><td>{{ $product->hasPrice() ? $product->formattedPrice() : 'Call for price' }}</td><td><a href="{{ route('admin.products.edit', $product->id) }}">Update</a></td></tr>
                @empty
                    <tr><td colspan="3" class="text-muted py-4">No products yet.</td></tr>
                @endforelse
            </tbody></table>
        </div>
    </section>
</div>
@endsection
