@extends('layouts.app')

@section('title', 'Checkout | Jupitaz')
@section('meta_description', 'Complete your order at Jupitaz.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold">Checkout</h1>

    <div class="row g-4">
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="post" class="card border-0 shadow-sm p-4">
                @csrf
                <h2 class="h5 fw-bold mb-3">Contact &amp; Delivery Details</h2>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">County</label>
                        <input type="text" name="county" value="{{ old('county', auth()->user()->county ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Town / Location</label>
                        <input type="text" name="location" value="{{ old('location', auth()->user()->location ?? '') }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Order Notes (optional)</label>
                        <textarea name="notes" rows="2" class="form-control" placeholder="Any specific requirements, delivery instructions, or questions.">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-accent btn-lg mt-4">Place Order</button>
                <p class="small text-muted mt-3 mb-0">By placing an order you agree to be contacted to confirm pricing, availability and delivery. No payment is taken online at this stage.</p>
            </form>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="h5 fw-bold mb-3">Order Summary</h2>
                @foreach($items as $item)
                    @php($p = $item['product'])
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-semibold">{{ $p->name }}</div>
                            <small class="text-muted">Qty {{ $item['quantity'] }}</small>
                        </div>
                        <div class="fw-semibold">@if($item['line_total'] !== null)KSh {{ number_format($item['line_total']) }}@else<span class="text-muted">Quote</span>@endif</div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between py-2"><span>Subtotal</span><span class="fw-semibold">KSh {{ number_format($subtotal) }}</span></div>
                <div class="d-flex justify-content-between py-2"><span>Delivery</span><span class="fw-semibold">{{ $deliveryFee > 0 ? 'KSh '.number_format($deliveryFee) : 'To be confirmed' }}</span></div>
                <div class="d-flex justify-content-between py-2 fs-5 fw-bold"><span>Total</span><span>KSh {{ number_format($subtotal + $deliveryFee) }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
