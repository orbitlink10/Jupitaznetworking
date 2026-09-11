<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::active()->with(['brand', 'categories'])->where('slug', $slug)->firstOrFail();

        return view('products.show', [
            'product' => $product,
            'related' => $product->related(),
        ]);
    }
}
