@extends('layouts.dashboard')

@section('title', 'Brands')
@section('dashboard-title', 'Brands')
@section('dashboard-subtitle', 'Manage product brands.')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.brands.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add Brand</a>
</div>

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Brand</th><th>Slug</th><th>Products</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($brands as $brand)
                <tr>
                    <td class="fw-semibold">{{ $brand->name }}</td>
                    <td class="text-muted">/brands/{{ $brand->slug }}/</td>
                    <td>{{ $brand->products_count }}</td>
                    <td>@if($brand->is_active)<span class="badge text-bg-success">Active</span>@else<span class="badge text-bg-secondary">Inactive</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this brand?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted">No brands yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
