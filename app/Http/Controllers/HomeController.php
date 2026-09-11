<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function __invoke()
    {
        $defaults = [
            'site_hero_title' => 'Networking Equipment in Kenya',
            'site_hero_subtitle' => 'Shop routers, switches, wireless access points, fibre optic equipment, structured cabling and ISP networking products from leading global brands.',
            'site_primary_cta' => 'Shop Networking Equipment',
            'site_primary_cta_url' => 'products',
            'site_secondary_cta' => 'Browse Categories',
            'site_secondary_cta_url' => 'products',
        ];

        $content = collect($defaults)->mapWithKeys(fn ($default, $key) => [$key => Setting::valueFor($key, $default)]);

        $categories = Category::active()->roots()->orderBy('sort_order')->orderBy('name')->get();

        $featuredProducts = Product::active()->inStock()->where('is_featured', true)->with(['brand'])->take(8)->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::active()->inStock()->with(['brand'])->latest()->take(8)->get();
        }

        $brands = Brand::active()->whereHas('products', fn ($q) => $q->active())->orderBy('name')->get();

        return view('home', [
            'content' => $content,
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'brands' => $brands,
            'brandShowcase' => $this->productsByBrand($brands),
            'productsByCategory' => $this->productsByCategory($categories),
        ]);
    }

    private function productsByBrand($brands): array
    {
        $priority = ['ubiquiti', 'mikrotik', 'tp-link', 'd-link'];

        $ordered = collect($priority)
            ->map(fn ($slug) => $brands->firstWhere('slug', $slug))
            ->filter()
            ->unique('id');

        $result = [];

        foreach ($ordered as $brand) {
            $products = Product::active()
                ->where('brand_id', $brand->id)
                ->with('brand')
                ->orderBy('id')
                ->take(6)
                ->get();

            if ($products->isNotEmpty()) {
                $result[$brand->slug] = ['brand' => $brand, 'products' => $products];
            }
        }

        return $result;
    }

    private function productsByCategory($categories): array
    {
        $slugs = ['routers', 'network-switches', 'wireless-access-points', 'fibre-optic', 'structured-cabling', 'wireless-cpe'];

        $result = [];

        foreach ($slugs as $slug) {
            $category = $categories->firstWhere('slug', $slug);

            if (! $category) {
                continue;
            }

            $result[$slug] = Product::active()->inStock()
                ->whereIn('id', $category->allProductIds())
                ->with('brand')
                ->take(6)
                ->get();
        }

        return $result;
    }
}
