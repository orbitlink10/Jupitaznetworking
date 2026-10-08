@extends('layouts.dashboard')
@php($isEdit = $category->exists)
@section('title', $isEdit ? 'Edit Category' : 'Create Category')
@section('dashboard-title', $isEdit ? 'Edit Category' : 'Create Category')
@section('content')
<form class="card product-form-card product-editor category-editor" action="{{ $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="mb-3">
        <label for="category-name" class="form-label">Name <span class="text-danger">*</span></label>
        <input id="category-name" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter category name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="category-meta-description" class="form-label">Meta description</label>
        <textarea id="category-meta-description" name="meta_description" rows="4" class="form-control" placeholder="Enter category meta description" maxlength="255">{{ old('meta_description', $category->meta_description) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="category-content" class="form-label">Description (Optional)</label>
        <textarea id="category-content" name="content" rows="12" class="form-control" placeholder="Write the category description here...">{{ old('content', $category->content) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="category-image" class="form-label">Photo (Optional)</label>
        <input id="category-image" name="image" type="file" class="form-control" accept="image/*">
        @if($category->image)<img src="{{ $category->imageUrl() }}" alt="Current category photo" class="category-photo mt-3">@endif
        <small class="text-muted">Maximum image size: 4 MB.</small>
    </div>
    <section class="product-form-section">
        <h2>Additional Details</h2>
        <div class="mb-3">
            <label for="category-parent" class="form-label">Parent Category</label>
            <select id="category-parent" name="parent_id" class="form-select">
                <option value="">Root category</option>
                @foreach($parents as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>@endforeach
            </select>
        </div>
        <div class="mb-3"><label for="category-short-description" class="form-label">Short Description</label><textarea id="category-short-description" name="description" rows="2" class="form-control">{{ old('description', $category->description) }}</textarea></div>
        <div class="mb-3"><label for="category-meta-title" class="form-label">Meta Title</label><input id="category-meta-title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="form-control" maxlength="160"></div>
        <div class="mb-3"><label for="category-icon" class="form-label">Icon</label><input id="category-icon" name="icon" value="{{ old('icon', $category->icon) }}" class="form-control" placeholder="Bootstrap icon name, e.g. wifi"></div>
        <div class="mb-3"><label for="category-sort" class="form-label">Sort Order</label><input id="category-sort" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-control"></div>
        <div class="form-check"><input id="category-active" type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $category->is_active ?? true))><label for="category-active" class="form-check-label">Active</label></div>
    </section>
    <div class="d-flex gap-3 flex-wrap"><button type="submit" class="btn btn-brand">{{ $isEdit ? 'Update Category' : 'Create Category' }}</button><a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@8.9.3/tinymce.min.js"></script>
<script>
if (window.tinymce) {
    tinymce.init({
        selector: '#category-content', license_key: 'gpl', height: 400,
        menubar: 'file edit view insert format tools table',
        plugins: 'link image media code fullscreen table lists',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | outdent indent | link image media | code fullscreen',
        toolbar_mode: 'wrap', branding: false, promotion: false, statusbar: false,
        placeholder: 'Write the category description here...',
        content_style: 'body { font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 15px; padding: 16px 18px; color: #111827; }',
        setup: editor => editor.on('change', () => editor.save())
    });
    document.querySelector('.category-editor').addEventListener('submit', () => tinymce.triggerSave());
}
</script>
@endpush
