<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\GoldPriceService;

class ProductController extends Controller
{
    public function __construct(private GoldPriceService $goldPriceService) {}

    public function index()
    {
        $goldPrice = $this->goldPriceService->getCurrentPrice();
        $products = Product::where('is_active', true)->latest()->paginate(12);
        return view('products.index', compact('products', 'goldPrice'));
    }

    public function show(Product $product)
    {
        $goldPrice = $this->goldPriceService->getCurrentPrice();
        return view('products.show', compact('product', 'goldPrice'));
    }
}