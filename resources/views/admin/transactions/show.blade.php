@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.transactions.index') }}" class="text-[#A0A0A0] hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">Transaction Details</h1>
                <p class="text-[#A0A0A0] text-sm">Review and confirm payment</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-sm font-medium
                @if($transaction->isPending()) bg-yellow-500/20 text-yellow-400
                @elseif($transaction->isCompleted()) bg-green-500/20 text-green-400
                @else bg-red-500/20 text-red-400
                @endif">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Left Column: Transaction Info --}}
    <div>
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">Transaction Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Reference Number</span>
                        <code class="text-[#D4AF37] font-mono">{{ $transaction->reference_number }}</code>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Type</span>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                            @if($transaction->type === 'deposit') bg-blue-500/20 text-blue-400
                            @elseif($transaction->type === 'buy') bg-green-500/20 text-green-400
                            @else bg-[#D4AF37]/20 text-[#D4AF37]
                            @endif">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Amount</span>
                        <span class="text-white font-semibold">${{ number_format($transaction->amount, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Payment Method</span>
                        <span class="text-white">
                            @if($transaction->payment_method === 'crypto')
                                Cryptocurrency
                            @elseif($transaction->payment_method === 'bank_transfer')
                                Bank Transfer
                            @else
                                {{ ucfirst($transaction->payment_method) }}
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Status</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-xs font-medium
                            @if($transaction->isPending()) bg-yellow-500/20 text-yellow-400
                            @elseif($transaction->isCompleted()) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400
                            @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($transaction->isPending()) bg-yellow-500
                                @elseif($transaction->isCompleted()) bg-green-500
                                @else bg-red-500
                                @endif"></span>
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Submitted</span>
                        <span class="text-white">{{ $transaction->created_at->format('F j, Y g:i A') }}</span>
                    </div>
                    
                    @if($transaction->confirmed_at)
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Confirmed At</span>
                            <span class="text-white">{{ $transaction->confirmed_at->format('F j, Y g:i A') }}</span>
                        </div>
                    @endif
                    
                    @if($transaction->confirmer)
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Confirmed By</span>
                            <span class="text-white">{{ $transaction->confirmer->first_name }} {{ $transaction->confirmer->last_name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- User Info --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">User Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                        <span class="text-2xl text-[#D4AF37] font-medium">{{ substr($transaction->user->first_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-white font-medium text-lg">{{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</p>
                        <p class="text-sm text-[#A0A0A0]">{{ $transaction->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">User ID</span>
                        <code class="text-white font-mono text-sm">#{{ $transaction->user->id }}</code>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                        <span class="text-[#A0A0A0]">Wallet Balance</span>
                        <span class="text-[#D4AF37] font-semibold">${{ number_format($transaction->user->wallet->usd_balance ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Actions --}}
    <div>
        {{-- Description --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">Description</h3>
            </div>
            <div class="p-6">
                <p class="text-white">{{ $transaction->description }}</p>
            </div>
        </div>

        @if($transaction->admin_notes)
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-6">
                <div class="p-6 border-b border-[#D4AF37]/20">
                    <h3 class="text-lg font-semibold text-white">Admin Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-white">{{ $transaction->admin_notes }}</p>
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        @if($transaction->isPending())
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-[#D4AF37]/20">
                    <h3 class="text-lg font-semibold text-white">Process Transaction</h3>
                </div>
                <div class="p-6 space-y-4">
                    {{-- Confirm Form --}}
                    <form action="{{ route('admin.transactions.confirm', $transaction) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to confirm this transaction? The user\'s wallet will be credited.');">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-sm text-[#A0A0A0] mb-2">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" 
                                      rows="3"
                                      class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none resize-none"
                                      placeholder="Add any notes about this confirmation..."></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            Confirm & Credit Wallet
                        </button>
                    </form>

                    <div class="border-t border-[#D4AF37]/20 pt-4">
                        {{-- Reject Form --}}
                        <div x-data="{ showRejectForm: false }">
                            <button type="button" 
                                    @click="showRejectForm = true"
                                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                Reject Transaction
                            </button>

                            {{-- Rejection Modal --}}
                            <div x-show="showRejectForm" 
                                 x-cloak
                                 class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0">
                                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl max-w-md w-full p-6"
                                     @click.away="showRejectForm = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100">
                                    <h3 class="text-xl font-semibold text-white mb-4">Reject Transaction</h3>
                                    <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label class="block text-sm text-[#A0A0A0] mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                                            <textarea name="admin_notes" 
                                                      rows="4"
                                                      class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none resize-none"
                                                      placeholder="Please provide a detailed reason for rejection..."
                                                      required></textarea>
                                            @error('admin_notes')
                                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex items-center justify-end gap-3">
                                            <button type="button" 
                                                    @click="showRejectForm = false"
                                                    class="px-4 py-2 text-[#A0A0A0] hover:text-white transition-colors">
                                                Cancel
                                            </button>
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                                Confirm Rejection
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-[#D4AF37]/20">
                    <h3 class="text-lg font-semibold text-white">Transaction Processed</h3>
                </div>
                <div class="p-6">
                    <p class="text-[#A0A0A0]">This transaction has already been {{ $transaction->status }}.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
