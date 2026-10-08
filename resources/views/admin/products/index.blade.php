@extends('layouts.dashboard')
@section('title', 'Products')
@section('dashboard-title', 'Products')
@section('dashboard-subtitle', 'Manage and view all products available in the system')
@section('dashboard-actions')
<a href="{{ route('admin.products.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Product</a>
@endsection
@section('content')
<div class="card product-list-card">
    <div class="product-list-header">
        <h2>Product List</h2>
        <form action="{{ route('admin.products.index') }}" method="get" class="product-search" role="search">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by product name or SKU..." aria-label="Search products">
            <button class="btn btn-brand" type="submit">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table align-middle product-table">
            <thead><tr><th scope="col">#</th><th scope="col">Image</th><th scope="col">Name</th><th scope="col">Price (KES)</th><th scope="col">Category</th><th scope="col">Stock / Status</th><th scope="col">Actions</th></tr></thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td><img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="product-image" loading="lazy"></td>
                        <td><a href="{{ route('products.show', $product->slug) }}" class="product-name">{{ $product->name }}</a><div class="small text-muted mt-1">{{ $product->sku }}</div>@if($product->brand)<div class="small text-muted">{{ $product->brand->name }}</div>@endif</td>
                        <td class="text-nowrap">{{ $product->hasPrice() ? number_format((float) $product->price, 2) : 'Call for price' }}</td>
                        <td>{{ $product->categories->pluck('name')->join(', ') ?: 'Uncategorized' }}</td>
                        <td><div class="mb-2">{{ $product->stock_quantity }} units</div><span class="badge {{ $product->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>@if($product->is_featured)<span class="badge text-bg-info">Featured</span>@endif</td>
                        <td><div class="product-actions">
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" rel="noopener" class="btn btn-outline-info">Preview</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary">Update</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" onsubmit="return confirm('Delete this product?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">{{ request('q') ? 'No products match your search.' : 'No products yet.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="product-list-footer">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
