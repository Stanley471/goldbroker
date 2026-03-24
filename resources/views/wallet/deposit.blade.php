<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Funds - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Back Button --}}
            <a href="{{ route('wallet.index') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to Vault
            </a>

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Deposit Funds</h1>
                <p class="text-[#A0A0A0]">Choose your preferred payment method to add USD to your vault.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Payment Method Selection --}}
                <div class="lg:col-span-2">
                    <div x-data="{ method: '{{ old('payment_method', 'card') }}' }">
                        
                        {{-- Payment Method Cards --}}
                        <div class="grid sm:grid-cols-3 gap-4 mb-8">
                            {{-- Credit Card --}}
                            <button @click="method = 'card'" 
                                :class="method === 'card' ? 'border-[#D4AF37] bg-[#D4AF37]/10' : 'border-[#D4AF37]/20 hover:border-[#D4AF37]/50'"
                                class="p-6 rounded-xl border text-left transition-all">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Credit Card</h3>
                                <p class="text-xs text-[#A0A0A0]">Visa, Mastercard, Amex</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 bg-green-500/20 text-green-400 rounded">Instant</span>
                                </div>
                            </button>

                            {{-- Cryptocurrency --}}
                            <button @click="method = 'crypto'"
                                :class="method === 'crypto' ? 'border-[#D4AF37] bg-[#D4AF37]/10' : 'border-[#D4AF37]/20 hover:border-[#D4AF37]/50'"
                                class="p-6 rounded-xl border text-left transition-all">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M9.5 9.5c.5-1 1.5-1.5 2.5-1.5s2 .5 2.5 1.5"></path><path d="M9.5 14.5c.5 1 1.5 1.5 2.5 1.5s2-.5 2.5-1.5"></path><path d="M12 8v8"></path></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Cryptocurrency</h3>
                                <p class="text-xs text-[#A0A0A0]">BTC, ETH, USDT, USDC</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded">~10 min</span>
                                </div>
                            </button>

                            {{-- Bank Transfer --}}
                            <button @click="method = 'bank'"
                                :class="method === 'bank' ? 'border-[#D4AF37] bg-[#D4AF37]/10' : 'border-[#D4AF37]/20 hover:border-[#D4AF37]/50'"
                                class="p-6 rounded-xl border text-left transition-all">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Bank Transfer</h3>
                                <p class="text-xs text-[#A0A0A0]">Wire, ACH, SEPA</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded">1-3 days</span>
                                </div>
                            </button>
                        </div>

                        {{-- Amount Input --}}
                        <form method="POST" action="{{ route('wallet.deposit.process') }}" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                            @csrf
                            <input type="hidden" name="payment_method" x-model="method">

                            <div class="mb-6">
                                <label class="block text-sm text-[#A0A0A0] mb-3">Deposit Amount (USD)</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#666]"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    <input type="number" name="amount" min="10" step="0.01" placeholder="Enter amount" value="{{ old('amount') }}" required
                                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl pl-12 pr-4 py-4 text-xl text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                                </div>
                                @error('amount') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>

                            {{-- Quick Amount Buttons --}}
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach([100, 500, 1000, 5000, 10000] as $amount)
                                    <button type="button" onclick="document.querySelector('input[name=amount]').value={{ $amount }}"
                                        class="px-4 py-2 text-sm rounded-lg border border-[#D4AF37]/30 text-[#A0A0A0] hover:border-[#D4AF37] hover:text-white transition-colors">
                                        ${{ number_format($amount) }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Method-specific info --}}
                            <div class="mb-6 p-4 bg-[#0A0A0A] rounded-lg">
                                <div x-show="method === 'card'" x-transition>
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        <div>
                                            <p class="text-sm text-white font-medium mb-1">Credit/Debit Card Payment</p>
                                            <p class="text-xs text-[#A0A0A0]">Your funds will be available instantly. A 2.5% processing fee applies.</p>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="method === 'crypto'" x-transition>
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        <div>
                                            <p class="text-sm text-white font-medium mb-1">Cryptocurrency Payment</p>
                                            <p class="text-xs text-[#A0A0A0]">You will receive a wallet address to send your crypto. Funds credited after network confirmation (~10 minutes). No processing fees.</p>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="method === 'bank'" x-transition>
                                    <div class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                        <div>
                                            <p class="text-sm text-white font-medium mb-1">Bank Transfer</p>
                                            <p class="text-xs text-[#A0A0A0]">You will receive our bank details. Domestic transfers take 1-2 business days, international 2-3 days. No processing fees.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full btn-primary justify-center py-4 text-base">
                                Continue to Payment
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Deposit Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Current Balance</span>
                                <span class="text-white">${{ number_format($wallet->usd_balance, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Minimum Deposit</span>
                                <span class="text-white">$10.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Maximum Deposit</span>
                                <span class="text-white">$100,000.00</span>
                            </div>
                        </div>

                        <div class="border-t border-[#D4AF37]/20 pt-6 mb-6">
                            <h4 class="text-sm text-[#A0A0A0] mb-3">Supported Currencies</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">USD</span>
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">EUR</span>
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">GBP</span>
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">BTC</span>
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">ETH</span>
                                <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">USDT</span>
                            </div>
                        </div>

                        <div class="p-4 bg-[#0A0A0A] rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                <span class="text-sm text-white font-medium">Secure & Insured</span>
                            </div>
                            <p class="text-xs text-[#A0A0A0]">All deposits are held in segregated accounts with full insurance coverage.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-6">
    <div class="section-container">
        <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldVault. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
