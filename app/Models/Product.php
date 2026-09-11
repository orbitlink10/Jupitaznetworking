<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Product extends Model
{
    protected $fillable = [
        'brand_id', 'sku', 'name', 'slug', 'short_description', 'description',
        'key_features', 'specifications', 'price', 'stock_quantity', 'stock_status',
        'featured_image', 'gallery', 'meta_title', 'meta_description', 'canonical_url',
        'is_active', 'is_featured', 'source_ref',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'key_features' => 'array',
            'specifications' => 'array',
            'gallery' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock_status', 'in_stock');
    }

    public function inStock(): bool
    {
        return $this->stock_status === 'in_stock' && $this->stock_quantity > 0;
    }

    public function hasPrice(): bool
    {
        return $this->price !== null && (float) $this->price > 0;
    }

    public function formattedPrice(): ?string
    {
        return $this->hasPrice() ? 'KSh '.Number::format((float) $this->price, 0) : null;
    }

    public function primaryCategory(): ?Category
    {
        return $this->categories()->first();
    }

    public function imageUrl(): string
    {
        $image = $this->featured_image;

        if (! $image) {
            foreach (['png', 'jpg', 'webp'] as $extension) {
                $path = 'images/products/'.$this->slug.'.'.$extension;
                if (is_file(public_path($path))) {
                    return asset($path);
                }
            }
            return asset('images/placeholder-product.svg');
        }

        if (str_starts_with($image, 'http')) {
            return $image;
        }

        return asset('storage/'.$image);
    }

    public function galleryUrls(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($image) => str_starts_with($image, 'http') ? $image : asset('storage/'.$image))
            ->values()
            ->all();
    }

    public function seoTitle(): string
    {
        return $this->meta_title ?: $this->name;
    }

    public function seoDescription(): string
    {
        return $this->meta_description
            ?: \Illuminate\Support\Str::limit(strip_tags((string) $this->short_description), 160);
    }

    public function related(int $limit = 4)
    {
        $categoryIds = $this->categories()->pluck('categories.id');

        return static::active()
            ->where('id', '!=', $this->id)
            ->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $categoryIds))
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }
}
