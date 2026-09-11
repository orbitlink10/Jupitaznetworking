@extends('layouts.dashboard')

@section('title', 'Categories')
@section('dashboard-title', 'Categories')
@section('dashboard-subtitle', 'Manage your category taxonomy.')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add Category</a>
</div>

<div class="card p-3">
    <table class="table align-middle">
        <thead><tr><th>Category</th><th>Slug</th><th>Subcategories</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-muted">/{{ $category->slug }}/</td>
                    <td>
                        @foreach($category->children as $child)
                            <span class="badge text-bg-light border me-1">{{ $child->name }}</span>
                        @endforeach
                    </td>
                    <td>@if($category->is_active)<span class="badge text-bg-success">Active</span>@else<span class="badge text-bg-secondary">Inactive</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this category?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @foreach($category->children as $child)
                    <tr class="table-light">
                        <td class="ps-4">↳ {{ $child->name }}</td>
                        <td class="text-muted">/{{ $category->slug }}/{{ $child->slug }}/</td>
                        <td></td>
                        <td>@if($child->is_active)<span class="badge text-bg-success">Active</span>@else<span class="badge text-bg-secondary">Inactive</span>@endif</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $child->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr><td colspan="5" class="text-muted">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
