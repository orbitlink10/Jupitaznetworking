<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Setting;
use App\Support\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class, fn () => new CartService);
    }

    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.dashboard'], function ($view) {
            $view->with([
                'navCategories' => Category::active()->roots()->with('children')->orderBy('sort_order')->orderBy('name')->get(),
                'navBrands' => Brand::active()->whereHas('products', fn ($q) => $q->active())->orderBy('name')->get(),
                'cartCount' => app(CartService::class)->count(),
                'supportPhone' => Setting::valueFor('support_phone'),
                'supportEmail' => Setting::valueFor('support_email'),
                'supportWhatsapp' => Setting::valueFor('support_whatsapp'),
            ]);
        });

        View::composer(['products.show', 'orders.confirmation'], function ($view) {
            $view->with([
                'supportPhone' => Setting::valueFor('support_phone'),
                'supportWhatsapp' => Setting::valueFor('support_whatsapp'),
            ]);
        });
    }
}
