<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count with all views
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $cart = auth()->user()->cart;
                $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;
            } else {
                $cartItemCount = 0;
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
