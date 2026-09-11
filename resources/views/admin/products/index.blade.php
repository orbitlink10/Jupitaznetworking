@extends('layouts.dashboard')

@section('title', 'Products')
@section('dashboard-title', 'Products')
@section('dashboard-subtitle', 'Manage your networking product catalogue.')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form action="{{ route('admin.products.index') }}" method="get" class="d-flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name or SKU">
        <button class="btn btn-brand">Search</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add Product</a>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Product</th><th>Brand</th><th>SKU</th><th class="text-end">Price</th><th class="text-end">Stock</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $product->imageUrl() }}" alt="" style="width:40px;height:40px;object-fit:contain;">
                                <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="fw-semibold text-dark">{{ $product->name }}</a>
                            </div>
                        </td>
                        <td>{{ $product->brand?->name ?? '—' }}</td>
                        <td class="text-muted">{{ $product->sku }}</td>
                        <td class="text-end">{{ $product->hasPrice() ? $product->formattedPrice() : 'Call for price' }}</td>
                        <td class="text-end">{{ $product->stock_quantity }}</td>
                        <td>
                            @if($product->is_active)<span class="badge text-bg-success">Active</span>@else<span class="badge text-bg-secondary">Inactive</span>@endif
                            @if($product->is_featured)<span class="badge text-bg-info">Featured</span>@endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
