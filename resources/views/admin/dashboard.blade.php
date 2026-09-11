@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('dashboard-title', 'Dashboard')
@section('dashboard-subtitle', 'Jupitaz networking store overview.')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card metric"><div class="card-body"><span class="text-muted small">Products</span><span class="fs-4 fw-bold">{{ $productCount }}</span><span class="small text-muted">{{ $activeProductCount }} active</span></div></div></div>
    <div class="col-6 col-md-3"><div class="card metric"><div class="card-body"><span class="text-muted small">Categories</span><span class="fs-4 fw-bold">{{ $categoryCount }}</span></div></div></div>
    <div class="col-6 col-md-3"><div class="card metric"><div class="card-body"><span class="text-muted small">Brands</span><span class="fs-4 fw-bold">{{ $brandCount }}</span></div></div></div>
    <div class="col-6 col-md-3"><div class="card metric"><div class="card-body"><span class="text-muted small">Orders</span><span class="fs-4 fw-bold">{{ $orderCount }}</span><span class="small text-muted">{{ $pendingOrderCount }} pending</span></div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h6 fw-bold mb-0">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="small">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead><tr><th>Order</th><th>Customer</th><th class="text-end">Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td>
                                <td>{{ $order->name }}</td>
                                <td class="text-end">KSh {{ number_format($order->total) }}</td>
                                <td><span class="badge text-bg-secondary">{{ $order->statusLabel() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h6 fw-bold mb-0">Latest Products</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-brand">Add Product</a>
            </div>
            <ul class="list-unstyled mb-0">
                @foreach($recentProducts as $product)
                    <li class="py-2 border-bottom">
                        <div class="fw-semibold">{{ $product->name }}</div>
                        <small class="text-muted">{{ $product->brand?->name ?? 'No brand' }} · {{ $product->hasPrice() ? $product->formattedPrice() : 'Call for price' }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
