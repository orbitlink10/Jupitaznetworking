@extends('layouts.app')

@section('title', 'Order '.$order->order_number.' | Jupitaz')
@section('meta_description', 'Order details for '.$order->order_number.' at Jupitaz.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4" style="max-width:860px;">
    <nav aria-label="Breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <h1 class="fw-bold">Order {{ $order->order_number }}</h1>
    <p class="text-muted">Placed {{ $order->created_at->format('d M Y, H:i') }} · <span class="badge text-bg-secondary">{{ $order->statusLabel() }}</span></p>

    <div class="card border-0 shadow-sm p-4 mb-4">
        <h2 class="h5 fw-bold">Items</h2>
        @foreach($order->items as $item)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-semibold">{{ $item->product_name }}</div>
                    <small class="text-muted">{{ $item->sku }} · Qty {{ $item->quantity }}</small>
                </div>
                <div class="fw-semibold">@if($item->price)KSh {{ number_format($item->price) }}@else<span class="text-muted">Quote</span>@endif</div>
            </div>
        @endforeach
        <div class="d-flex justify-content-between py-2 mt-2"><span>Subtotal</span><span class="fw-semibold">KSh {{ number_format($order->subtotal) }}</span></div>
        <div class="d-flex justify-content-between py-2"><span>Delivery</span><span class="fw-semibold">KSh {{ number_format($order->delivery_fee) }}</span></div>
        <div class="d-flex justify-content-between py-2 fs-5 fw-bold"><span>Total</span><span>KSh {{ number_format($order->total) }}</span></div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <h2 class="h5 fw-bold">Delivery Details</h2>
        <div class="small">
            <div><strong>{{ $order->name }}</strong></div>
            @if($order->phone)<div>Phone: {{ $order->phone }}</div>@endif
            @if($order->email)<div>Email: {{ $order->email }}</div>@endif
            @if($order->location)<div>Location: {{ $order->location }}{{ $order->county ? ', '.$order->county : '' }}</div>@endif
            @if($order->address)<div>Address: {{ $order->address }}</div>@endif
        </div>
    </div>
</div>
@endsection
