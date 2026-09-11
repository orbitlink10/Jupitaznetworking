@extends('layouts.dashboard')

@php($isEdit = isset($category) && $category->exists)

@section('title', $isEdit ? 'Edit Category' : 'Add Category')
@section('dashboard-title', $isEdit ? 'Edit Category' : 'Add Category')

@section('content')
<form action="{{ $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="post">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card p-3">
                <h2 class="h6 fw-bold">Details</h2>
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">— Root category —</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="description" rows="2" class="form-control">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Supporting Content (HTML, shown below products)</label>
                    <textarea name="content" rows="10" class="form-control">{{ old('content', $category->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon (Bootstrap icon name, e.g. "wifi")</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-3 mb-3">
                <h2 class="h6 fw-bold">SEO</h2>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="form-control" maxlength="160">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" maxlength="255">{{ old('meta_description', $category->meta_description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-control">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $category->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-brand w-100">{{ $isEdit ? 'Update Category' : 'Create Category' }}</button>
        </div>
    </div>
</form>
@endsection
