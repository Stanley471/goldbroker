<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalGoldSold = Order::where('order_type', 'buy')->sum('gold_grams');
        $pendingKyc = User::where('kyc_status', 'pending')->count();
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalGoldSold',
            'pendingKyc',
            'recentOrders'
        ));
    }
}