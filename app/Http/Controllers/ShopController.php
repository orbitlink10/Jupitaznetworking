<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Product::active()->with(['brand', 'categories']);

        if ($term = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('categories', fn ($c) => $c->where('name', 'like', "%{$term}%"));
            });
        }

        if ($brandSlug = $request->query('brand')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $brandSlug));
        }

        if ($categorySlug = $request->query('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        if (($min = $request->query('min_price')) !== null && is_numeric($min)) {
            $query->where('price', '>=', (float) $min);
        }

        if (($max = $request->query('max_price')) !== null && is_numeric($max)) {
            $query->where('price', '<=', (float) $max);
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
                $query->orderByDesc('is_featured')->orderByDesc('created_at');
        }

        $products = $query->paginate(24)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'brands' => Brand::active()->orderBy('name')->get(),
            'categories' => Category::active()->roots()->orderBy('sort_order')->orderBy('name')->get(),
            'filters' => $request->only(['q', 'brand', 'category', 'sort', 'min_price', 'max_price', 'in_stock']),
        ]);
    }
}
