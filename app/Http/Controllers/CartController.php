<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart)
    {
    }

    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $this->cart->add((int) $data['product_id'], (int) ($data['quantity'] ?? 1));

        if ($request->boolean('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Product added to your cart.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $this->cart->update((int) $data['product_id'], (int) $data['quantity']);

        return back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $this->cart->remove((int) $data['product_id']);

        return back()->with('success', 'Item removed from your cart.');
    }

    public function clear()
    {
        $this->cart->clear();

        return back();
    }
}
