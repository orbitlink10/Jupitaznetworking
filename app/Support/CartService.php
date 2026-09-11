<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $key = 'cart';

    public function all(): array
    {
        return Session::get($this->key, []);
    }

    public function items(): Collection
    {
        $raw = $this->all();

        $products = Product::whereIn('id', array_keys($raw))->get()->keyBy('id');

        return collect($raw)->map(function ($quantity, $id) use ($products) {
            $product = $products->get((int) $id);

            if (! $product) {
                return null;
            }

            $price = $product->price;

            return [
                'product' => $product,
                'quantity' => max(1, (int) $quantity),
                'price' => $price,
                'line_total' => $price !== null ? $price * max(1, (int) $quantity) : null,
            ];
        })->filter()->values();
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->all();
        $existing = (int) ($cart[$productId] ?? 0);
        $cart[$productId] = max(1, $existing + $quantity);
        Session::put($this->key, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->all();

        if ($quantity <= 0) {
            $this->remove($productId);

            return;
        }

        $cart[$productId] = max(1, $quantity);
        Session::put($this->key, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->all();
        unset($cart[$productId]);
        Session::put($this->key, $cart);
    }

    public function clear(): void
    {
        Session::forget($this->key);
    }

    public function count(): int
    {
        return (int) array_sum(array_values($this->all()));
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum(fn ($item) => (float) ($item['line_total'] ?? 0));
    }

    public function hasPricedItems(): bool
    {
        return $this->items()->contains(fn ($item) => $item['price'] !== null);
    }
}
