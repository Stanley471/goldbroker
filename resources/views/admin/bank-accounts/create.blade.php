@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.bank-accounts.index') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
            Back to Accounts
        </a>
        <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Add Bank Account</h1>
        <p class="text-[#A0A0A0] mt-1">Add a new bank account for wire transfers</p>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.bank-accounts.store') }}" method="POST" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-8">
            @csrf

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Account Name *</label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}" placeholder="e.g. GoldVault Inc." required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('account_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Bank Name *</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g. JPMorgan Chase" required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('bank_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm text-[#A0A0A0] mb-2">Account Number *</label>
                <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="Enter account number" required
                    class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                @error('account_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm text-[#A0A0A0] mb-2">Bank Address</label>
                <textarea name="bank_address" rows="2" placeholder="Full bank address"
                    class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">{{ old('bank_address') }}</textarea>
                @error('bank_address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Routing Number</label>
                    <input type="text" name="routing_number" value="{{ old('routing_number') }}" placeholder="For ACH/Domestic"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('routing_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">SWIFT/BIC</label>
                    <input type="text" name="swift_code" value="{{ old('swift_code') }}" placeholder="For International"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('swift_code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">IBAN</label>
                    <input type="text" name="iban" value="{{ old('iban') }}" placeholder="For SEPA"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('iban') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Currency *</label>
                    <select name="currency" required
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white focus:border-[#D4AF37] focus:outline-none transition-colors">
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                        <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                        <option value="CHF" {{ old('currency') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                    </select>
                    @error('currency') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">
                    @error('sort_order') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm text-[#A0A0A0] mb-2">Special Instructions</label>
                <textarea name="instructions" rows="3" placeholder="Any special instructions for users..."
                    class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors">{{ old('instructions') }}</textarea>
                @error('instructions') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 mb-8">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-[#D4AF37]/30 bg-[#0A0A0A] text-[#D4AF37] focus:ring-[#D4AF37]">
                <label class="text-white">Active</label>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.bank-accounts.index') }}" class="flex-1 py-3 border border-[#D4AF37]/30 rounded-xl text-[#A0A0A0] text-center hover:border-[#D4AF37] transition-colors">
                    Cancel
                </a>
                <button type="submit" class="flex-1 btn-primary justify-center py-3">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
