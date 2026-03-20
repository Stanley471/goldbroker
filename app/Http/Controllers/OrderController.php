<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;        
use App\Http\Requests\BuyGoldRequest;
use App\Http\Requests\SellGoldRequest;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function buy(BuyGoldRequest $request)
    {

        /** @var \App\Models\User $user */
        $user = auth()->user();

        try {
            $order = $this->orderService->buy($user, $request->grams);
            return back()->with('success', 'Purchase successful! Reference: ' . $order->reference_number);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function sell(SellGoldRequest $request)
    {
        $request->validate([
            'grams' => ['required', 'numeric', 'min:0.1'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        try {
            $order = $this->orderService->sell($user, $request->grams);
            return back()->with('success', 'Sale successful! Reference: ' . $order->reference_number);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}