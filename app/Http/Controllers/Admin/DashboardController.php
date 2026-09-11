<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'activeProductCount' => Product::active()->count(),
            'categoryCount' => Category::count(),
            'brandCount' => Brand::count(),
            'orderCount' => Order::count(),
            'pendingOrderCount' => Order::where('status', 'pending')->count(),
            'revenue' => Order::whereIn('status', ['completed', 'processing', 'confirmed'])->sum('total'),
            'customerCount' => User::whereHas('role', fn ($q) => $q->where('name', 'customer'))->count(),
            'recentOrders' => Order::with('items')->latest()->take(8)->get(),
            'recentProducts' => Product::with('brand')->latest()->take(8)->get(),
        ]);
    }
}
