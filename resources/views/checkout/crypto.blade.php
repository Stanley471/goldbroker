<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Cryptocurrency - GoldVault Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Back Button --}}
            <a href="{{ route('checkout.index') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to Checkout
            </a>

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Pay with Cryptocurrency</h1>
                <p class="text-[#A0A0A0]">Select a cryptocurrency and send the exact amount to complete your order.</p>
            </div>

            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="max-w-2xl">
                {{-- Order Summary --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[#A0A0A0]">Order Total</span>
                        <span class="text-2xl font-bold text-[#D4AF37]">${{ number_format($amount, 2) }}</span>
                    </div>
                    <div class="p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                            <p class="text-xs text-yellow-500">Your order is reserved for 24 hours. Please complete payment within this timeframe.</p>
                        </div>
                    </div>
                </div>

                {{-- Cryptocurrency Selection --}}
                <div x-data="{ selectedId: {{ $cryptoWallets->first()->id ?? 'null' }}, showQr: false }" class="space-y-4">
                    
                    <p class="text-sm text-[#A0A0A0] mb-3">Select Cryptocurrency</p>
                    
                    @foreach($cryptoWallets as $wallet)
                        @php
                            $cryptoAmount = $wallet->calculateCryptoAmount($amount);
                        @endphp
                        <button @click="selectedId = {{ $wallet->id }}; showQr = false" 
                            :class="selectedId === {{ $wallet->id }} ? 'border-[#D4AF37] bg-[#D4AF37]/10' : 'border-[#D4AF37]/20 hover:border-[#D4AF37]/50'"
                            class="w-full p-4 rounded-xl border flex items-center justify-between transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                    <span class="text-[#D4AF37] text-xl font-bold">{{ $wallet->symbol ?: substr($wallet->code, 0, 1) }}</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-white font-semibold">{{ $wallet->name }}</h3>
                                    <p class="text-xs text-[#A0A0A0]">{{ $wallet->code }}{{ $wallet->network ? ' • ' . $wallet->network : '' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-semibold">{{ number_format($cryptoAmount, 8) }} {{ $wallet->code }}</p>
                                <p class="text-xs text-[#A0A0A0]">≈ ${{ number_format($amount, 2) }}</p>
                            </div>
                        </button>

                        {{-- Wallet Details (shown when selected) --}}
                        <div x-show="selectedId === {{ $wallet->id }}" x-transition class="mt-4 p-6 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                <h3 class="text-white font-semibold">Payment Details</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-lg">
                                    <p class="text-xs text-[#D4AF37] mb-1">Send Exactly This Amount</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xl font-bold text-[#D4AF37] font-mono">{{ number_format($cryptoAmount, 8) }} {{ $wallet->code }}</p>
                                        <button onclick="navigator.clipboard.writeText('{{ number_format($cryptoAmount, 8) }}')" class="px-3 py-1 bg-[#D4AF37] text-[#0A0A0A] text-xs font-medium rounded hover:bg-[#B8860B] transition-colors">
                                            Copy
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-[#A0A0A0] mb-2">To this address:</p>
                                    <div class="flex items-center gap-2">
                                        <code class="flex-1 bg-[#0A0A0A] px-4 py-3 rounded-lg text-white text-sm font-mono truncate">{{ $wallet->address }}</code>
                                        <button onclick="navigator.clipboard.writeText('{{ $wallet->address }}')" class="p-2 bg-[#D4AF37]/20 rounded-lg hover:bg-[#D4AF37]/30 transition-colors" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="showQr" x-transition class="flex justify-center py-4">
                                    <div class="w-48 h-48 bg-white p-4 rounded-lg">
                                        <div class="w-full h-full bg-[#0A0A0A] flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-white"><rect width="5" height="5" x="3" y="3" rx="1"></rect><rect width="5" height="5" x="16" y="3" rx="1"></rect><rect width="5" height="5" x="3" y="16" rx="1"></rect><path d="M21 16h-3a2 2 0 0 0-2 2v3"></path><path d="M21 21v.01"></path><path d="M12 7v3a2 2 0 0 1-2 2H7"></path><path d="M3 12h.01"></path><path d="M12 3h.01"></path><path d="M12 16v.01"></path><path d="M16 12h.01"></path><path d="M16 21h.01"></path><path d="M21 12v.01"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <button @click="showQr = !showQr" class="w-full py-3 border border-[#D4AF37]/30 rounded-lg text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-colors">
                                    <span x-text="showQr ? 'Hide QR Code' : 'Show QR Code'"></span>
                                </button>
                            </div>

                            <div class="mt-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 mt-0.5"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" x2="12" y1="9" y2="13"></line><line x1="12" x2="12.01" y1="17" y2="17"></line></svg>
                                    <div>
                                        <p class="text-sm text-red-500 font-medium mb-1">Critical Instructions</p>
                                        <ul class="text-xs text-[#A0A0A0] space-y-1">
                                            <li>• Send ONLY {{ $wallet->code }}{{ $wallet->network ? ' on ' . $wallet->network : '' }} to this address</li>
                                            <li>• Sending wrong crypto or using wrong network = PERMANENT LOSS</li>
                                            <li>• Send EXACT amount shown above</li>
                                            <li>• Order will be processed after network confirmation (~10-30 min)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 mt-8">
                        <a href="{{ route('checkout.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                            Cancel Order
                        </a>
                        <form method="POST" action="{{ route('checkout.confirm') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full btn-primary justify-center py-4">
                                I've Sent the Payment
                            </button>
                        </form>
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
