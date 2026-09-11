<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->get();

        return view('orders.index', ['orders' => $orders]);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();

        $supportPhone = Setting::valueFor('support_phone');
        $supportWhatsapp = Setting::valueFor('support_whatsapp');

        return view('orders.confirmation', [
            'order' => $order,
            'supportPhone' => $supportPhone,
            'supportWhatsapp' => $supportWhatsapp,
        ]);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 404);

        return view('orders.show', ['order' => $order->load('items.product')]);
    }
}
