@extends('layouts.app')

@section('title', 'Order Received | Jupitaz')
@section('meta_description', 'Your Jupitaz order has been received.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-5" style="max-width:760px;">
    <div class="text-center mb-4">
        <i class="bi bi-check-circle-fill text-success" style="font-size:3rem;"></i>
        <h1 class="fw-bold mt-2">Order Received</h1>
        <p class="text-muted">Thank you. Your order reference is <strong>{{ $order->order_number }}</strong>.</p>
    </div>

    <div class="card border-0 shadow-sm p-4 mb-4">
        <h2 class="h5 fw-bold">Order Summary</h2>
        @foreach($order->items as $item)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-semibold">{{ $item->product_name }}</div>
                    <small class="text-muted">Qty {{ $item->quantity }}</small>
                </div>
                <div class="fw-semibold">@if($item->price)KSh {{ number_format($item->price) }}@else<span class="text-muted">Quote</span>@endif</div>
            </div>
        @endforeach
        <div class="d-flex justify-content-between py-2 fs-5 fw-bold mt-2"><span>Total</span><span>KSh {{ number_format($order->total) }}</span></div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <h2 class="h5 fw-bold">What happens next?</h2>
        <p class="mb-0 small text-muted">Our team will contact you to confirm pricing, availability and delivery details.</p>
        @if($supportWhatsapp)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $supportWhatsapp) }}?text={{ urlencode('Hello, I have just placed order '.$order->order_number.' and would like to confirm it.') }}" target="_blank" rel="noopener" class="btn btn-success mt-3"><i class="bi bi-whatsapp me-1"></i> Confirm on WhatsApp</a>
        @endif
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-brand">Continue Shopping</a>
    </div>
</div>
@endsection
