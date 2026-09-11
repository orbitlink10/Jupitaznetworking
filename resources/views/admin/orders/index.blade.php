@extends('layouts.dashboard')

@section('title', 'Orders')
@section('dashboard-title', 'Orders')
@section('dashboard-subtitle', 'Manage customer orders.')

@section('content')
<div class="d-flex gap-2 mb-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-brand' : 'btn-outline-secondary' }}">All</a>
    @foreach($statuses as $status)
        <a href="{{ route('admin.orders.index', ['status' => $status]) }}" class="btn btn-sm {{ request('status') === $status ? 'btn-brand' : 'btn-outline-secondary' }}">{{ ucfirst($status) }}</a>
    @endforeach
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Order</th><th>Customer</th><th>Phone</th><th class="text-end">Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td class="text-end">KSh {{ number_format($order->total) }}</td>
                        <td><span class="badge text-bg-secondary">{{ $order->statusLabel() }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td class="text-end"><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
