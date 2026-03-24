<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\AdminLog;
use App\Models\KycSubmission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalGoldSold = Order::where('order_type', 'buy')->sum('gold_grams');
        $pendingKyc = KycSubmission::where('status', 'pending')->count();
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $pendingKycSubmissions = KycSubmission::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalGoldSold',
            'pendingKyc',
            'recentOrders',
            'pendingKycSubmissions'
        ));
    }
    public function users()
{
    $users = User::with('wallet')->latest()->paginate(20);
    return view('admin.users', compact('users'));
}
public function showUser($id)
{
    $user = User::findOrFail($id);
    $orders = $user->orders()->latest()->get();
    $transactions = $user->transactions()->latest()->get();

    return view('admin.users.show', compact('user', 'orders', 'transactions'));
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
public function updateKyc($id, Request $request)
{
    $user = User::findOrFail($id);
    $user->update(['kyc_status' => $request->kyc_status]);

    AdminLog::create([
        'admin_id' => auth()->id(),
        'action' => 'KYC status updated to ' . $request->kyc_status,
        'target_type' => 'User',
        'target_id' => $user->id,
        'notes' => 'Updated by admin',
    ]);

    return back()->with('success', 'KYC status updated to ' . $request->kyc_status);
}
}