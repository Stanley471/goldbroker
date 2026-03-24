@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.crypto-wallets.index') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
            Back to Wallets
        </a>
        <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Edit Crypto Wallet</h1>
        <p class="text-[#A0A0A0] mt-1">Update {{ $cryptoWallet->name }} ({{ $cryptoWallet->code }}) wallet details</p>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.crypto-wallets.update', $cryptoWallet) }}" method="POST" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Currency Name *</label>
                    <input type="text" name="name" value="{{ old('name', $cryptoWallet->name) }}" required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Currency Code *</label>
                    <input type="text" name="code" value="{{ old('code', $cryptoWallet->code) }}" required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors uppercase">
                    @error('code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Symbol</label>
                    <input type="text" name="symbol" value="{{ old('symbol', $cryptoWallet->symbol) }}"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('symbol') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Network</label>
                    <input type="text" name="network" value="{{ old('network', $cryptoWallet->network) }}"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('network') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm text-[#A0A0A0] mb-2">Wallet Address *</label>
                <textarea name="address" rows="3" required
                    class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors font-mono text-sm">{{ old('address', $cryptoWallet->address) }}</textarea>
                @error('address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm text-[#A0A0A0] mb-2">Exchange Rate (USD) *</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#666]">$</span>
                    <input type="number" name="exchange_rate" value="{{ old('exchange_rate', $cryptoWallet->exchange_rate) }}" step="0.0000000001" min="0.0000000001" required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl pl-8 pr-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                </div>
                <p class="text-xs text-[#666] mt-1">1 {{ $cryptoWallet->code }} = ${{ number_format($cryptoWallet->exchange_rate, 2) }} USD</p>
                @error('exchange_rate') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $cryptoWallet->sort_order) }}" min="0"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('sort_order') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cryptoWallet->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-[#D4AF37]/30 bg-[#0A0A0A] text-[#D4AF37] focus:ring-[#D4AF37]">
                        <span class="text-white">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.crypto-wallets.index') }}" class="flex-1 py-3 border border-[#D4AF37]/30 rounded-xl text-[#A0A0A0] text-center hover:border-[#D4AF37] transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 btn-primary justify-center py-3">
                    Update Wallet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
