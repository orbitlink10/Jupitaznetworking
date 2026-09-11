<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Support\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart)
    {
    }

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('products.index')->with('success', 'Your cart is empty.');
        }

        return view('checkout.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'deliveryFee' => (float) (Setting::valueFor('delivery_fee', '0') ?? 0),
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('products.index')->with('success', 'Your cart is empty.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'county' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $items = $this->cart->items();
        $subtotal = $this->cart->subtotal();
        $deliveryFee = (float) (Setting::valueFor('delivery_fee', '0') ?? 0);

        $order = DB::transaction(function () use ($data, $items, $subtotal, $deliveryFee) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'],
                'county' => $data['county'] ?? null,
                'location' => $data['location'] ?? null,
                'address' => $data['address'] ?? null,
                'notes' => $data['notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $subtotal + $deliveryFee,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                $product = $item['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['line_total'] ?? 0,
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('orders.confirmation', $order->order_number);
    }
}
