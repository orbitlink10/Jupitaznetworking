@extends('layouts.app')

@section('title', 'My Account | Jupitaz')
@section('meta_description', 'Your Jupitaz account.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold">My Account</h1>
    <p class="text-muted">Welcome, {{ auth()->user()->name }}.</p>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="h5 fw-bold mb-3">Quick Links</h2>
                <ul class="list-unstyled d-grid gap-2">
                    <li><a href="{{ route('orders.index') }}" class="btn btn-outline-brand w-100 text-start"><i class="bi bi-box-seam me-2"></i>My Orders</a></li>
                    <li><a href="{{ route('profile') }}" class="btn btn-outline-brand w-100 text-start"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                    <li><a href="{{ route('products.index') }}" class="btn btn-outline-brand w-100 text-start"><i class="bi bi-shop me-2"></i>Browse Products</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="h5 fw-bold mb-3">Recent Orders</h2>
                @if($orders->isEmpty())
                    <p class="text-muted mb-0">You have no orders yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>Order</th><th>Date</th><th class="text-end">Total</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="fw-semibold">{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="text-end">KSh {{ number_format($order->total) }}</td>
                                        <td><span class="badge text-bg-secondary">{{ $order->statusLabel() }}</span></td>
                                        <td class="text-end"><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-brand">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
