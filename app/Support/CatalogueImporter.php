<?php

namespace App\Support;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CatalogueImporter
{
    private array $brandMap = [];
    private array $categoryPathMap = [];

    public function run(?array $data = null): array
    {
        $data ??= require database_path('seeders/data/catalogue.php');

        $stats = ['brands' => 0, 'categories' => 0, 'products' => 0];

        $this->importBrands($data['brands'] ?? [], $stats);
        $this->importCategories($data['categories'] ?? [], $stats);
        $this->importProducts($data['products'] ?? [], $stats);

        return $stats;
    }

    private function importBrands(array $brands, array &$stats): void
    {
        foreach ($brands as $slug => $brand) {
            $model = Brand::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $brand['name'],
                    'slug' => $slug,
                    'description' => $brand['description'] ?? null,
                    'meta_title' => $brand['meta_title'] ?? ($brand['name'].' Products & Prices in Kenya | Jupitaz'),
                    'meta_description' => $brand['meta_description'] ?? ('Shop '.$brand['name'].' networking products in Kenya at Jupitaz. Compare prices and availability.'),
                    'is_active' => true,
                ]
            );

            $this->brandMap[$slug] = $model->id;
            $stats['brands']++;
        }
    }

    private function importCategories(array $categories, array &$stats, ?int $parentId = null, string $parentPath = ''): void
    {
        foreach ($categories as $category) {
            $slug = $category['slug'];
            $path = $parentPath === '' ? $slug : $parentPath.'/'.$slug;

            $model = Category::updateOrCreate(
                ['slug' => $slug, 'parent_id' => $parentId],
                [
                    'parent_id' => $parentId,
                    'name' => $category['name'],
                    'slug' => $slug,
                    'description' => $category['description'] ?? null,
                    'meta_title' => $category['meta_title'] ?? null,
                    'meta_description' => $category['meta_description'] ?? null,
                    'content' => $category['content'] ?? null,
                    'icon' => $category['icon'] ?? null,
                    'sort_order' => $category['sort_order'] ?? 0,
                    'is_active' => true,
                ]
            );

            $this->categoryPathMap[$path] = $model->id;
            $stats['categories']++;

            if (! empty($category['children'])) {
                $this->importCategories($category['children'], $stats, $model->id, $path);
            }
        }
    }

    private function importProducts(array $products, array &$stats): void
    {
        foreach ($products as $product) {
            $brandId = $product['brand'] ? ($this->brandMap[$product['brand']] ?? null) : null;

            $sku = $product['sku'] ?? null;
            $sourceRef = $product['source_ref'] ?? $sku;

            $existing = Product::where('source_ref', $sourceRef)->first();
            $slug = $existing?->slug ?: $this->uniqueProductSlug($product['slug'] ?? Str::slug($product['name']));

            $model = Product::updateOrCreate(
                ['source_ref' => $sourceRef],
                [
                    'brand_id' => $brandId,
                    'sku' => $sku,
                    'name' => $product['name'],
                    'slug' => $slug,
                    'short_description' => $product['short_description'] ?? null,
                    'description' => $product['description'] ?? null,
                    'key_features' => $product['key_features'] ?? [],
                    'specifications' => $product['specifications'] ?? [],
                    'price' => $product['price'] ?? null,
                    'stock_quantity' => 10,
                    'stock_status' => 'in_stock',
                    'meta_title' => $product['meta_title'] ?? ($product['name'].' Price in Kenya | Jupitaz'),
                    'meta_description' => $product['meta_description'] ?? $this->defaultMetaDescription($product),
                    'is_active' => true,
                    'is_featured' => (bool) ($product['featured'] ?? false),
                ]
            );

            $categoryIds = $this->resolveCategoryIds($product['categories'] ?? []);
            $model->categories()->sync($categoryIds);

            $stats['products']++;
        }
    }

    private function resolveCategoryIds(array $slugs): array
    {
        $ids = [];

        foreach ($slugs as $slug) {
            $resolved = $this->resolveCategoryPath($slug, $slugs);

            if ($resolved !== null) {
                $ids[] = $resolved;
            }
        }

        return array_values(array_unique($ids));
    }

    /**
     * Resolve a single category reference to a category id.
     *
     * Supports both full paths ("fibre-optic/patch-cords") and bare slugs
     * ("patch-cords"). When a bare slug is ambiguous (the same slug exists
     * under multiple parents), it is disambiguated using the other categories
     * referenced by the same product.
     */
    private function resolveCategoryPath(string $slug, array $allSlugs): ?int
    {
        if (isset($this->categoryPathMap[$slug])) {
            return $this->categoryPathMap[$slug];
        }

        $candidates = [];

        foreach ($this->categoryPathMap as $path => $id) {
            if ($path === $slug || Str::endsWith($path, '/'.$slug)) {
                $candidates[$path] = $id;
            }
        }

        if (empty($candidates)) {
            return null;
        }

        if (count($candidates) === 1) {
            return reset($candidates);
        }

        // Disambiguate: prefer the candidate whose parent is also referenced.
        foreach ($candidates as $path => $id) {
            $parent = Str::beforeLast($path, '/');

            if ($parent !== $path && in_array($parent, $allSlugs, true)) {
                return $id;
            }
        }

        return reset($candidates);
    }

    private function defaultMetaDescription(array $product): string
    {
        $brand = isset($this->brandMap[$product['brand'] ?? '']) && isset($product['brand'])
            ? ucfirst($product['brand'])
            : 'networking';

        return 'Buy '.$product['name'].' in Kenya from Jupitaz. View price, specifications and availability for '.$brand.' networking equipment.';
    }

    private function uniqueProductSlug(string $slug): string
    {
        $base = $slug ?: 'product';
        $candidate = $base;
        $counter = 1;

        while (Product::where('slug', $candidate)->exists()) {
            $candidate = $base.'-'.$counter++;
        }

        return $candidate;
    }
}
