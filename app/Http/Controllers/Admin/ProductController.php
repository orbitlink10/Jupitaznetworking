<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'categories'])->latest();

        if ($term = trim((string) $request->query('q'))) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('sku', 'like', "%{$term}%"));
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product,
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['sku'] = $data['sku'] ?: Str::upper(Str::slug($data['name'], ''));

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        $data['gallery'] = $this->galleryFrom($request);

        $product = Product::create($data);
        $product->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product->load('categories'),
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->filled('name') && $request->input('name') !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        $data['gallery'] = $this->galleryFrom($request, $product->gallery ?? []);

        $product->update($data);
        $product->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'sku' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'key_features' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'stock_status' => ['required', 'in:in_stock,out_of_stock'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'max:4096'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $data['price'] = $data['price'] === null || $data['price'] === '' ? null : $data['price'];
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['key_features'] = $this->linesToArray($request->input('key_features'));
        $data['specifications'] = $this->specificationsFrom($request->input('specifications'));

        return $data;
    }

    private function linesToArray(?string $value): array
    {
        return array_values(array_filter(array_map('trim', explode("\n", (string) $value))));
    }

    private function specificationsFrom(?string $value): array
    {
        $rows = array_values(array_filter(array_map('trim', explode("\n", (string) $value))));
        $specs = [];

        foreach ($rows as $row) {
            if (str_contains($row, '|')) {
                [$label, $val] = array_map('trim', explode('|', $row, 2));
                $specs[] = ['label' => $label, 'value' => $val];
            } else {
                $specs[] = ['label' => $row, 'value' => ''];
            }
        }

        return $specs;
    }

    private function galleryFrom(Request $request, array $existing = []): array
    {
        $gallery = $existing;

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $gallery[] = $file->store('products', 'public');
            }
        }

        return array_values($gallery);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $counter = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
