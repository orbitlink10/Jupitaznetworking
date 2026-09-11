<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $path)
    {
        $category = $this->resolve($path);

        abort_if(! $category || ! $category->is_active, 404);

        $category->load('children');

        $productIds = $category->allProductIds();

        $query = Product::active()->with(['brand', 'categories'])
            ->whereIn('id', $productIds);

        if ($brandSlug = $request->query('brand')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $brandSlug));
        }

        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        switch ($request->query('sort')) {
            case 'price_asc':
                $query->orderByRaw('price IS NULL, price ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('price IS NULL DESC, price DESC');
                break;
            case 'name_asc':
                $query->orderBy('name');
                break;
            default:
                $query->orderByDesc('created_at');
        }

        $products = $query->paginate(24)->withQueryString();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
            'ancestors' => $category->ancestors(),
        ]);
    }

    private function resolve(string $path): ?Category
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if (empty($segments)) {
            return null;
        }

        $parent = null;
        $current = null;

        foreach ($segments as $segment) {
            $query = Category::where('slug', $segment);

            if ($parent) {
                $query->where('parent_id', $parent->id);
            } else {
                $query->whereNull('parent_id');
            }

            $current = $query->first();

            if (! $current) {
                return null;
            }

            $parent = $current;
        }

        return $current;
    }
}
