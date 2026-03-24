@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Admin Dashboard</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Overview of platform activity</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path></svg>
        </div>
        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-1">Total Users</p>
        <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
        </div>
        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-1">Total Orders</p>
        <p class="text-3xl font-bold text-white">{{ $totalOrders }}</p>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
        </div>
        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-1">Gold Sold</p>
        <p class="text-3xl font-bold text-[#D4AF37]">{{ number_format($totalGoldSold, 2) }}g</p>
    </div>
    <a href="{{ route('admin.kyc.index') }}" class="block bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 hover:border-yellow-500/50 transition-colors">
        <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
        </div>
        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-1">Pending KYC</p>
        <p class="text-3xl font-bold text-yellow-500">{{ $pendingKyc }}</p>
    </a>
</div>

{{-- Pending KYC Submissions --}}
@if($pendingKyc > 0)
<div class="bg-[#141414] border border-yellow-500/20 rounded-2xl overflow-hidden mb-8">
    <div class="p-6 border-b border-yellow-500/10 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white flex items-center gap-2" style="font-family: 'Playfair Display';">
            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
            Pending KYC Submissions
        </h2>
        <a href="{{ route('admin.kyc.index') }}" class="text-sm text-yellow-500 hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-yellow-500/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Email</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Submitted</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingKycSubmissions as $kyc)
                    <tr class="border-b border-yellow-500/10 hover:bg-yellow-500/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-yellow-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-yellow-500 text-sm font-medium">{{ substr($kyc->user->first_name, 0, 1) }}</span>
                                </div>
                                <span class="text-white">{{ $kyc->user->first_name }} {{ $kyc->user->last_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0]">{{ $kyc->user->email }}</td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0]">{{ $kyc->created_at->diffForHumans() }}</td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-500 text-[#0A0A0A] text-xs font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                                Review
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Recent Orders --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-[#D4AF37]/10 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Recent Orders</h2>
        <a href="{{ route('admin.orders') }}" class="text-sm text-[#D4AF37] hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Grams</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Total</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden lg:table-cell">Status</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden lg:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6 text-sm text-white font-mono">{{ $order->reference_number }}</td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0] hidden sm:table-cell">{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->order_type === 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right text-sm text-white hidden md:table-cell">{{ $order->gold_grams }}g</td>
                        <td class="py-4 px-6 text-right text-sm text-[#D4AF37] font-semibold">${{ number_format($order->total_usd, 2) }}</td>
                        <td class="py-4 px-6 text-right hidden lg:table-cell">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-500/20 text-green-400">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="py-4 px-6 text-right text-sm text-[#666] hidden lg:table-cell">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-10 text-[#666]">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection