@extends('layouts.dashboard')

@php($isEdit = isset($product) && $product->exists)

@section('title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-subtitle', $isEdit ? 'Update the product details below.' : 'Fill in the product details below to add a new item.')

@section('content')
<form class="product-editor" action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="product-form-layout">
        <div>
            <div class="card product-form-card">

                <div class="mb-3">
                    <label class="form-label" for="product-name">Product Name *</label>
                    <input type="text" placeholder="Enter product name" id="product-name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-price">Price (KES, leave empty for "Call for price")</label>
                    <input type="number" step="0.01" min="0" id="product-price" name="price" value="{{ old('price', $product->price) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-stock_quantity">Quantity</label>
                    <input type="number" id="product-stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 10) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-stock_status">Stock Status</label>
                    <select id="product-stock_status" name="stock_status" class="form-select">
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
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="product-sku">SKU / Model</label>
                    <input type="text" id="product-sku" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="product-brand_id">Brand</label>
                    <select id="product-brand_id" name="brand_id" class="form-select">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-categories">Categories</label>
                    <select id="product-categories" name="categories[]" class="form-select" multiple size="6">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', $product->categories->pluck('id')->all())))>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl/Cmd to select multiple categories.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-short_description">Short Description</label>
                    <textarea id="product-short_description" name="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-description">Description (HTML)</label>
                    <textarea id="product-description" name="description" rows="6" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-key_features">Key Features (one per line)</label>
                    <textarea id="product-key_features" name="key_features" rows="5" class="form-control">{{ old('key_features', implode("\n", $product->key_features ?? [])) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-specifications">Specifications (one per line, format: Label | Value)</label>
                    <textarea id="product-specifications" name="specifications" rows="6" class="form-control" placeholder="CPU | Marvell 88F7040&#10;Ports | 7x Gigabit Ethernet">{{ old('specifications', collect($product->specifications ?? [])->map(fn ($s) => $s['label'].' | '.($s['value'] ?? ''))->implode("\n")) }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <div class="card product-form-card mb-4">
                <h2 class="h6 fw-bold">Images</h2>
                <div class="mb-3">
                    <label class="form-label" for="product-featured_image">Featured Image</label>
                    <input type="file" id="product-featured_image" name="featured_image" class="form-control" accept="image/*">
                    @if($product->featured_image)<img src="{{ $product->imageUrl() }}" class="mt-2 img-thumbnail" style="max-height:120px;">@endif
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-gallery_files">Gallery Images (multiple)</label>
                    <input type="file" id="product-gallery_files" name="gallery_files[]" class="form-control" accept="image/*" multiple>
                </div>
            </div>

            <div class="card product-form-card mb-4">
                <h2 class="h6 fw-bold">SEO</h2>
                <div class="mb-3">
                    <label class="form-label" for="product-meta_title">Meta Title</label>
                    <input type="text" id="product-meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="form-control" maxlength="160">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-meta_description">Meta Description</label>
                    <textarea id="product-meta_description" name="meta_description" rows="3" class="form-control" maxlength="255">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="product-canonical_url">Canonical URL</label>
                    <input type="text" id="product-canonical_url" name="canonical_url" value="{{ old('canonical_url', $product->canonical_url) }}" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-brand w-100">{{ $isEdit ? 'Update Product' : 'Create Product' }}</button>
        </div>
    </div>
</form>
@endsection
