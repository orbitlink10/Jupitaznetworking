<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('brands.index', [
            'brands' => Brand::active()->whereHas('products', fn ($q) => $q->active())->orderBy('name')->get(),
        ]);
    }

    public function show(Request $request, string $slug)
    {
        $brand = Brand::active()->where('slug', $slug)->firstOrFail();

        $query = Product::active()->with(['brand', 'categories'])->where('brand_id', $brand->id);

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

        return view('brands.show', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }
}
