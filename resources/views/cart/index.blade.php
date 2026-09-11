@extends('layouts.app')

@section('title', 'Your Cart | Jupitaz')
@section('meta_description', 'Review your cart at Jupitaz.')
@section('robots', 'noindex, follow')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold">Your Cart</h1>

    @if($items->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart3 fs-1 text-muted"></i>
            <p class="text-muted mt-2">Your cart is empty.</p>
            <a href="{{ route('products.index') }}" class="btn btn-brand">Browse Products</a>
        </div>
    @else
        <div class="table-responsive bg-white border rounded p-3">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-center" style="width:140px;">Quantity</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        @php($p = $item['product'])
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $p->imageUrl() }}" alt="{{ $p->name }}" style="width:56px;height:56px;object-fit:contain;">
                                    <div>
                                        <a href="{{ route('products.show', $p->slug) }}" class="fw-semibold text-dark">{{ $p->name }}</a>
                                        <div class="small text-muted">{{ $p->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">@if($p->hasPrice()){{ $p->formattedPrice() }}@else<span class="text-muted">Call for price</span>@endif</td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="post" class="d-flex justify-content-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" class="form-control form-control-sm text-center" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-end fw-semibold">@if($item['line_total'] !== null)KSh {{ number_format($item['line_total']) }}@else<span class="text-muted">—</span>@endif</td>
                            <td class="text-end">
                                <form action="{{ route('cart.remove') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-brand">Continue Shopping</a>
            <div class="text-end">
                <div class="fs-5 fw-bold">Subtotal: KSh {{ number_format($subtotal) }}</div>
                <small class="text-muted d-block mb-2">Final total and delivery confirmed at checkout.</small>
                <a href="{{ route('checkout.index') }}" class="btn btn-accent btn-lg">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>
@endsection
