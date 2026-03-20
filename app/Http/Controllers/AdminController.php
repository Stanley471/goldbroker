<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\AdminLog;

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
    public function users()
{
    $users = User::with('wallet')->latest()->paginate(20);
    return view('admin.users', compact('users'));
}
public function showUser($id)
{
    $user = User::with('wallet', 'orders')->findOrFail($id);
    return view('admin.users.show', compact('user'));
}
public function orders()
{
    $orders = Order::with('user')->latest()->paginate(20);
    return view('admin.orders', compact('orders'));
}
public function logs()
{
    $logs = AdminLog::with('admin')->latest()->paginate(20);
    return view('admin.logs', compact('logs'));
}
}