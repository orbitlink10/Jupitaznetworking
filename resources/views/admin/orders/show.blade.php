@extends('layouts.dashboard')

@section('title', 'Order '.$order->order_number)
@section('dashboard-title', 'Order '.$order->order_number)
@section('dashboard-subtitle', 'Placed '.$order->created_at->format('d M Y, H:i'))

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-3 mb-3">
            <h2 class="h6 fw-bold">Items</h2>
            <table class="table align-middle">
                <thead><tr><th>Product</th><th>SKU</th><th class="text-center">Qty</th><th class="text-end">Price</th><th class="text-end">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product)
                                    <a href="{{ route('products.show', $item->product->slug) }}" target="_blank">{{ $item->product_name }}</a>
                                @else
                                    {{ $item->product_name }}
                                @endif
                            </td>
                            <td class="text-muted">{{ $item->sku }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">@if($item->price)KSh {{ number_format($item->price) }}@else<span class="text-muted">Quote</span>@endif</td>
                            <td class="text-end fw-semibold">KSh {{ number_format($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <div>Subtotal: KSh {{ number_format($order->subtotal) }}</div>
                <div>Delivery: KSh {{ number_format($order->delivery_fee) }}</div>
                <div class="fs-5 fw-bold">Total: KSh {{ number_format($order->total) }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-3 mb-3">
            <h2 class="h6 fw-bold">Customer</h2>
            <div class="small">
                <div><strong>{{ $order->name }}</strong></div>
                @if($order->email)<div>{{ $order->email }}</div>@endif
                <div>{{ $order->phone }}</div>
                @if($order->location)<div>{{ $order->location }}{{ $order->county ? ', '.$order->county : '' }}</div>@endif
                @if($order->address)<div>{{ $order->address }}</div>@endif
                @if($order->notes)<div class="mt-2 text-muted">Notes: {{ $order->notes }}</div>@endif
            </div>
        </div>
        <div class="card p-3">
            <h2 class="h6 fw-bold">Update Status</h2>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
                @csrf @method('PATCH')
                <select name="status" class="form-select mb-2">
                    @foreach(['pending', 'confirmed', 'processing', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-brand w-100">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
