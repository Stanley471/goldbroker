@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.users') }}" class="flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors text-sm mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="m12 5-7 7 7 7"></path></svg>
        Back to Users
    </a>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-[#D4AF37] font-bold text-lg">{{ strtoupper(substr($user->first_name, 0, 1)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">{{ $user->first_name }} {{ $user->last_name }}</h1>
                <p class="text-[#A0A0A0] text-sm">{{ $user->email }}</p>
            </div>
        </div>
        <span class="px-3 py-1 text-sm rounded-full w-fit
            {{ $user->kyc_status === 'approved' ? 'bg-green-500/20 text-green-400' :
               ($user->kyc_status === 'rejected' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
            KYC: {{ ucfirst($user->kyc_status) }}
        </span>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-5">
        <p class="text-xs text-[#A0A0A0] mb-1">USD Balance</p>
        <p class="text-2xl font-bold text-white">${{ number_format($user->wallet->usd_balance ?? 0, 2) }}</p>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-5">
        <p class="text-xs text-[#A0A0A0] mb-1">Gold Balance</p>
        <p class="text-2xl font-bold text-[#D4AF37]">{{ number_format($user->wallet->gold_balance_grams ?? 0, 4) }}g</p>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-5">
        <p class="text-xs text-[#A0A0A0] mb-1">Total Orders</p>
        <p class="text-2xl font-bold text-white">{{ $orders->count() }}</p>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-5">
        <p class="text-xs text-[#A0A0A0] mb-1">Referral Code</p>
        <p class="text-lg font-bold text-[#D4AF37] tracking-widest">{{ $user->referral_code ?? '--' }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- User Info --}}
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4" style="font-family: 'Playfair Display';">User Info</h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-xs text-[#A0A0A0]">Full Name</span>
                <span class="text-xs text-white">{{ $user->first_name }} {{ $user->last_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xs text-[#A0A0A0]">Email</span>
                <span class="text-xs text-white">{{ $user->email }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xs text-[#A0A0A0]">KYC Status</span>
                <span class="text-xs text-white">{{ ucfirst($user->kyc_status) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xs text-[#A0A0A0]">Referred By</span>
                <span class="text-xs text-white">{{ $user->referred_by ?? 'Direct signup' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xs text-[#A0A0A0]">Joined</span>
                <span class="text-xs text-white">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    {{-- KYC Actions --}}
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4" style="font-family: 'Playfair Display';">KYC Management</h2>
        <p class="text-[#A0A0A0] text-sm mb-6">Current status: <span class="text-white font-medium">{{ ucfirst($user->kyc_status) }}</span></p>
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="POST" action="{{ route('admin.users.kyc', $user->id) }}" class="flex-1">
                @csrf
                @method('PATCH')
                <input type="hidden" name="kyc_status" value="approved">
                <button type="submit" class="w-full py-3 bg-green-500/20 border border-green-500/30 text-green-400 rounded-xl text-sm font-medium hover:bg-green-500/30 transition-colors">
                    Approve KYC
                </button>
            </form>
            <form method="POST" action="{{ route('admin.users.kyc', $user->id) }}" class="flex-1">
                @csrf
                @method('PATCH')
                <input type="hidden" name="kyc_status" value="rejected">
                <button type="submit" class="w-full py-3 bg-red-500/20 border border-red-500/30 text-red-400 rounded-xl text-sm font-medium hover:bg-red-500/30 transition-colors">
                    Reject KYC
                </button>
            </form>
        </div>
    </div>

</div>

{{-- Orders --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden mb-6">
    <div class="p-6 border-b border-[#D4AF37]/10">
        <h2 class="text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Orders</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Grams</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Total</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6 text-sm text-white font-mono">{{ $order->reference_number }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->order_type === 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-right text-[#A0A0A0] hidden sm:table-cell">{{ $order->gold_grams }}g</td>
                        <td class="py-4 px-6 text-sm text-right text-[#D4AF37] font-semibold">${{ number_format($order->total_usd, 2) }}</td>
                        <td class="py-4 px-6 text-sm text-right text-[#666] hidden sm:table-cell">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-[#666]">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Transactions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-[#D4AF37]/10">
        <h2 class="text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Transactions</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Amount</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Currency</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Description</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ in_array($tx->type, ['deposit', 'buy', 'referral_bonus']) ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ ucfirst($tx->type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-right text-white font-semibold">{{ number_format($tx->amount, 4) }}</td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0] hidden sm:table-cell">{{ $tx->currency }}</td>
                        <td class="py-4 px-6 text-sm text-[#666] hidden md:table-cell">{{ $tx->description ?? '--' }}</td>
                        <td class="py-4 px-6 text-sm text-right text-[#666]">{{ $tx->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-[#666]">No transactions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection