@extends('layouts.dashboard')

@php($isEdit = isset($product) && $product->exists)

@section('title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-subtitle', $isEdit ? 'Update product details.' : 'Create a new product.')

@section('content')
<form action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card p-3">
                <h2 class="h6 fw-bold">Basic Information</h2>
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">SKU / Model</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select">
                            <option value="">— None —</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Categories</label>
                    <select name="categories[]" class="form-select" multiple size="6">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', $product->categories->pluck('id')->all())))>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl/Cmd to select multiple categories.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description (HTML)</label>
                    <textarea name="description" rows="6" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Key Features (one per line)</label>
                    <textarea name="key_features" rows="5" class="form-control">{{ old('key_features', implode("\n", $product->key_features ?? [])) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Specifications (one per line, format: Label | Value)</label>
                    <textarea name="specifications" rows="6" class="form-control" placeholder="CPU | Marvell 88F7040&#10;Ports | 7x Gigabit Ethernet">{{ old('specifications', collect($product->specifications ?? [])->map(fn ($s) => $s['label'].' | '.($s['value'] ?? ''))->implode("\n")) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-3 mb-3">
                <h2 class="h6 fw-bold">Pricing &amp; Stock</h2>
                <div class="mb-3">
                    <label class="form-label">Price (KSh, leave empty for "Call for price")</label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 10) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-select">
                        <option value="in_stock" @selected(old('stock_status', $product->stock_status) === 'in_stock')>In Stock</option>
                        <option value="out_of_stock" @selected(old('stock_status', $product->stock_status) === 'out_of_stock')>Out of Stock</option>
                    </select>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $product->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $product->is_featured ?? false))>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h2 class="h6 fw-bold">Images</h2>
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    @if($product->featured_image)<img src="{{ $product->imageUrl() }}" class="mt-2 img-thumbnail" style="max-height:120px;">@endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Gallery Images (multiple)</label>
                    <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple>
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h2 class="h6 fw-bold">SEO</h2>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="form-control" maxlength="160">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" maxlength="255">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Canonical URL</label>
                    <input type="text" name="canonical_url" value="{{ old('canonical_url', $product->canonical_url) }}" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-brand w-100">{{ $isEdit ? 'Update Product' : 'Create Product' }}</button>
        </div>
    </div>
</form>
@endsection
