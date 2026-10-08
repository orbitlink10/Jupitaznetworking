@extends('layouts.dashboard')
@php
    $isEdit = $product->exists;
    $selectedCategories = $product->categories;
    $selectedChild = $selectedCategories->first(fn ($category) => $category->parent_id !== null);
    $categoryId = old('category_id', $selectedChild?->parent_id ?? $selectedCategories->first()?->id);
    $subcategoryId = old('subcategory_id', $selectedChild?->id);
@endphp
@section('title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-title', $isEdit ? 'Edit Product' : 'Add Product')
@section('dashboard-subtitle', $isEdit ? 'Update the product details below' : 'Fill in the product details below to add a new item')
@section('content')
<form class="product-editor card product-form-card" action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="mb-3">
        <label for="product-name" class="form-label">Product Name</label>
        <input id="product-name" name="name" class="form-control" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="product-price" class="form-label">Price (KES)</label>
        <input id="product-price" name="price" type="number" step="0.01" min="0" class="form-control" placeholder="Enter product price" aria-description="Leave empty for Call for price." value="{{ old('price', $product->price) }}">
    </div>
    <div class="mb-3">
        <label for="product-marked-price" class="form-label">Marked Price (KES)</label>
        <input id="product-marked-price" name="marked_price" type="number" step="0.01" min="0" class="form-control" placeholder="Enter marked price" value="{{ old('marked_price', $product->marked_price) }}">
    </div>
    <div class="mb-3">
        <label for="product-quantity" class="form-label">Quantity</label>
        <input id="product-quantity" name="stock_quantity" type="number" min="0" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required>
    </div>
    <div class="mb-3">
        <label for="product-category" class="form-label">Category</label>
        <select id="product-category" name="category_id" class="form-select">
            <option value="">Select Category</option>
            @foreach($categories->whereNull('parent_id') as $category)
                <option value="{{ $category->id }}" @selected($categoryId == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="product-subcategory" class="form-label">Subcategory</label>
        <select id="product-subcategory" name="subcategory_id" class="form-select" @disabled(!$categoryId || $categories->where('parent_id', $categoryId)->isEmpty())>
            <option value="">{{ $categoryId && $categories->where('parent_id', $categoryId)->isNotEmpty() ? 'Select Subcategory' : 'No subcategories available' }}</option>
            @foreach($categories->where('parent_id', $categoryId)->filter(fn ($category) => $category->parent_id !== null) as $category)
                <option value="{{ $category->id }}" @selected($subcategoryId == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="product-meta-description" class="form-label">Meta Description</label>
        <textarea id="product-meta-description" name="meta_description" rows="4" maxlength="255" class="form-control" placeholder="Write a short search-friendly summary">{{ old('meta_description', $product->meta_description) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="product-description" class="form-label">Description</label>
        <textarea id="product-description" name="description" rows="12" class="form-control" placeholder="Write the product description here...">{{ old('description', $product->description) }}</textarea>
    </div>
    <section class="product-form-section">
        <h2>Product video (Optional)</h2>
        <div class="mb-3">
            <label for="product-video" class="form-label">YouTube video URL</label>
            <input id="product-video" type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video_url', $product->video_url) }}">
        </div>
    </section>
    <section class="product-form-section">
        <h2>Product Images</h2>
        <div class="mb-3">
            <label for="product-image" class="form-label">Featured Image</label>
            <input id="product-image" type="file" name="featured_image" class="form-control" accept="image/*">
            @if($product->featured_image)<img src="{{ $product->imageUrl() }}" alt="Current product image" class="mt-3 product-image">@endif
        </div>
        <div class="mb-3">
            <label for="product-gallery" class="form-label">Gallery Images</label>
            <input id="product-gallery" type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple>
        </div>
    </section>
    <section class="product-form-section">
        <h2>Additional Details</h2>
        <div class="mb-3">
            <label for="product-sku" class="form-label">SKU / Model</label>
            <input id="product-sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
        </div>
        <div class="mb-3">
            <label for="product-brand" class="form-label">Brand</label>
            <select id="product-brand" name="brand_id" class="form-select">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)<option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>@endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="product-extra-categories" class="form-label">Additional Categories (Optional)</label>
            <select id="product-extra-categories" name="categories[]" class="form-select" multiple size="4">
                @foreach($categories as $category)<option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', $selectedCategories->pluck('id')->reject(fn ($id) => $id == $categoryId || $id == $subcategoryId)->all())))>{{ $category->name }}</option>@endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple categories.</small>
        </div>
        <div class="mb-3">
            <label for="product-short-description" class="form-label">Short Description</label>
            <textarea id="product-short-description" name="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="product-features" class="form-label">Key Features (one per line)</label>
            <textarea id="product-features" name="key_features" rows="4" class="form-control">{{ old('key_features', implode("\n", $product->key_features ?? [])) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="product-specifications" class="form-label">Specifications (Label | Value)</label>
            <textarea id="product-specifications" name="specifications" rows="4" class="form-control">{{ old('specifications', collect($product->specifications ?? [])->map(fn ($s) => $s['label'].' | '.($s['value'] ?? ''))->implode("\n")) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="product-stock-status" class="form-label">Stock Status</label>
            <select id="product-stock-status" name="stock_status" class="form-select">
                <option value="in_stock" @selected(old('stock_status', $product->stock_status ?? 'in_stock') === 'in_stock')>In Stock</option>
                <option value="out_of_stock" @selected(old('stock_status', $product->stock_status) === 'out_of_stock')>Out of Stock</option>
            </select>
        </div>
        <div class="form-check"><input id="is_active" name="is_active" type="checkbox" value="1" class="form-check-input" @checked(old('is_active', $product->is_active ?? true))><label for="is_active" class="form-check-label">Active</label></div>
        <div class="form-check"><input id="is_featured" name="is_featured" type="checkbox" value="1" class="form-check-input" @checked(old('is_featured', $product->is_featured ?? false))><label for="is_featured" class="form-check-label">Featured</label></div>
    </section>
    <section class="product-form-section">
        <h2>Search Engine Details</h2>
        <div class="mb-3"><label for="product-meta-title" class="form-label">Meta Title</label><input id="product-meta-title" name="meta_title" maxlength="160" class="form-control" value="{{ old('meta_title', $product->meta_title) }}"></div>
        <div class="mb-3"><label for="product-canonical" class="form-label">Canonical URL</label><input id="product-canonical" name="canonical_url" class="form-control" value="{{ old('canonical_url', $product->canonical_url) }}"></div>
    </section>
    <div class="d-flex gap-3 flex-wrap"><button type="submit" class="btn btn-brand">{{ $isEdit ? 'Update Product' : 'Add Product' }}</button><a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@8.9.3/tinymce.min.js"></script>
<script>
(() => {
    const categories = @json($categories->map(fn ($category) => ['id' => $category->id, 'parent_id' => $category->parent_id, 'name' => $category->name])->values());
    const parent = document.getElementById('product-category');
    const child = document.getElementById('product-subcategory');
    parent.addEventListener('change', () => {
        const children = categories.filter(category => category.parent_id !== null && String(category.parent_id) === parent.value);
        child.replaceChildren(new Option(children.length ? 'Select Subcategory' : 'No subcategories available', ''));
        children.forEach(category => child.add(new Option(category.name, category.id)));
        child.disabled = !children.length;
    });
    if (window.tinymce) {
        tinymce.init({
            selector: '#product-description', license_key: 'gpl', height: 400,
            menubar: 'file edit view insert format tools table',
            plugins: 'link image media code fullscreen table lists',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | outdent indent | link image media | code fullscreen',
            toolbar_mode: 'wrap', branding: false, promotion: false, statusbar: false,
            placeholder: 'Write the product description here...',
            content_style: 'body { font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 15px; padding: 16px 18px; color: #111827; }',
            setup: editor => editor.on('change', () => editor.save())
        });
        document.querySelector('.product-editor').addEventListener('submit', () => tinymce.triggerSave());
    }
})();
</script>
@endpush
