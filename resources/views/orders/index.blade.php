@extends('layouts.app')

@section('title', 'My Orders | Jupitaz')
@section('meta_description', 'View your orders at Jupitaz.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold">My Orders</h1>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted">You have no orders yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-brand">Browse Products</a>
        </div>
    @else
        <div class="table-responsive bg-white border rounded p-3">
            <table class="table align-middle">
                <thead><tr><th>Order</th><th>Date</th><th>Items</th><th class="text-end">Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ $order->items->sum('quantity') }}</td>
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
@endsection
