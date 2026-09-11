@extends('layouts.dashboard')

@php($isEdit = isset($brand) && $brand->exists)

@section('title', $isEdit ? 'Edit Brand' : 'Add Brand')
@section('dashboard-title', $isEdit ? 'Edit Brand' : 'Add Brand')

@section('content')
<form action="{{ $isEdit ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" method="post">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card p-3">
                <h2 class="h6 fw-bold">Details</h2>
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $brand->description) }}</textarea>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $brand->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-3 mb-3">
                <h2 class="h6 fw-bold">SEO</h2>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $brand->meta_title) }}" class="form-control" maxlength="160">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" maxlength="255">{{ old('meta_description', $brand->meta_description) }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-brand w-100">{{ $isEdit ? 'Update Brand' : 'Create Brand' }}</button>
        </div>
    </div>
</form>
@endsection
