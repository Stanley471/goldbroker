@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Transactions</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Manage and verify user deposits and payments</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['pending'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Pending</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['completed'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Completed</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['failed'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Failed</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#D4AF37]">${{ number_format($stats['pending_amount'], 2) }}</p>
                <p class="text-sm text-[#A0A0A0]">Pending Deposits</p>
            </div>
        </div>
    </div>
</div>

{{-- Pending Transactions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-8">
    <div class="p-6 border-b border-[#D4AF37]/20">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
            Pending Confirmation
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Amount</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Method</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Submitted</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingTransactions as $transaction)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <code class="text-[#D4AF37] font-mono text-sm">{{ $transaction->reference_number }}</code>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                                    <span class="text-[#D4AF37] text-sm font-medium">{{ substr($transaction->user->first_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white text-sm">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</p>
                                    <p class="text-xs text-[#A0A0A0]">{{ $transaction->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                @if($transaction->type === 'deposit') bg-blue-500/20 text-blue-400
                                @elseif($transaction->type === 'buy') bg-green-500/20 text-green-400
                                @else bg-[#D4AF37]/20 text-[#D4AF37]
                                @endif">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <p class="text-white font-semibold">${{ number_format($transaction->amount, 2) }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-[#A0A0A0]">
                                @if($transaction->payment_method === 'crypto')
                                    Crypto
                                @elseif($transaction->payment_method === 'bank_transfer')
                                    Bank Transfer
                                @else
                                    {{ ucfirst($transaction->payment_method) }}
                                @endif
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white text-sm">{{ $transaction->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#D4AF37] text-[#0A0A0A] text-xs font-medium rounded-lg hover:bg-[#B8860B] transition-colors">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 px-6 text-center text-[#A0A0A0]">
                            No pending transactions
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pendingTransactions->hasPages())
        <div class="p-4 border-t border-[#D4AF37]/20">
            {{ $pendingTransactions->links() }}
        </div>
    @endif
</div>

{{-- Completed Transactions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-8">
    <div class="p-6 border-b border-[#D4AF37]/20">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            Completed
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Amount</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Confirmed By</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completedTransactions as $transaction)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <code class="text-[#D4AF37] font-mono text-sm">{{ $transaction->reference_number }}</code>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-green-500 text-sm font-medium">{{ substr($transaction->user->first_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white text-sm">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</p>
                                    <p class="text-xs text-[#A0A0A0]">{{ $transaction->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                @if($transaction->type === 'deposit') bg-blue-500/20 text-blue-400
                                @elseif($transaction->type === 'buy') bg-green-500/20 text-green-400
                                @else bg-[#D4AF37]/20 text-[#D4AF37]
                                @endif">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <p class="text-white font-semibold">${{ number_format($transaction->amount, 2) }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($transaction->confirmer)
                                <p class="text-white text-sm">{{ $transaction->confirmer->first_name }} {{ $transaction->confirmer->last_name }}</p>
                            @else
                                <span class="text-[#A0A0A0]">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white text-sm">{{ $transaction->confirmed_at?->format('M j, Y') }}</p>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-[#D4AF37] hover:text-[#B8860B] transition-colors text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 px-6 text-center text-[#A0A0A0]">
                            No completed transactions
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($completedTransactions->hasPages())
        <div class="p-4 border-t border-[#D4AF37]/20">
            {{ $completedTransactions->links() }}
        </div>
    @endif
</div>
@endsection
