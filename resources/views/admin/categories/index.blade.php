@extends('layouts.dashboard')
@section('title', 'Categories')
@section('dashboard-title', 'Categories')
@section('dashboard-actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-brand">Create New Category</a>
@endsection
@section('content')
<div class="card category-list-panel">
    <div class="table-responsive">
        <table class="table align-middle category-table">
            <thead><tr><th scope="col">ID</th><th scope="col">Name</th><th scope="col">Slug</th><th scope="col">Photo</th><th scope="col">Actions</th></tr></thead>
            <tbody>
                @forelse($categories as $root)
                    @foreach(collect([$root])->concat($root->children) as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}@if($category->parent_id)<small class="d-block text-muted mt-1">Subcategory of {{ $root->name }}</small>@endif @if(!$category->is_active)<span class="badge text-bg-secondary mt-1">Inactive</span>@endif</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="category-photo" loading="lazy">
                                @else
                                    <div class="category-photo category-photo-empty">No Image</div>
                                @endif
                            </td>
                            <td><div class="category-actions">
                                <a href="{{ route('categories.show', $category->path()) }}" target="_blank" rel="noopener" class="btn category-preview">Preview</a>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn category-update">Update</a>
                                <form method="post" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Delete this category?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn category-delete">Delete</button>
                                </form>
                            </div></td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
