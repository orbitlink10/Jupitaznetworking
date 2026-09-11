<?php

namespace App\Http\Controllers;

use App\Models\Order;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->isRole(['admin', 'dispatcher'])) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboards.customer', [
            'orders' => $user->orders()->with('items')->latest()->get(),
        ]);
    }
}
