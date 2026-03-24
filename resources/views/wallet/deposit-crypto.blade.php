<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Cryptocurrency - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Back Button --}}
            <a href="{{ route('wallet.deposit') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to Payment Methods
            </a>

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Deposit Cryptocurrency</h1>
                <p class="text-[#A0A0A0]">Select a cryptocurrency and send the equivalent amount to the provided address.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="max-w-2xl">
                {{-- Amount Display --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Deposit Amount</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($amount, 2) }} <span class="text-lg text-[#A0A0A0]">USD</span></p>
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
                                <div>
                                    <p class="text-xs text-[#A0A0A0] mb-2">Send exactly this amount:</p>
                                    <div class="flex items-center gap-2">
                                        <code class="flex-1 bg-[#0A0A0A] px-4 py-3 rounded-lg text-[#D4AF37] text-sm font-mono">{{ number_format($cryptoAmount, 8) }} {{ $wallet->code }}</code>
                                        <button onclick="navigator.clipboard.writeText('{{ number_format($cryptoAmount, 8) }}')" class="p-2 bg-[#D4AF37]/20 rounded-lg hover:bg-[#D4AF37]/30 transition-colors" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
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
                                        {{-- QR Code placeholder --}}
                                        <div class="w-full h-full bg-[#0A0A0A] flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-white"><rect width="5" height="5" x="3" y="3" rx="1"></rect><rect width="5" height="5" x="16" y="3" rx="1"></rect><rect width="5" height="5" x="3" y="16" rx="1"></rect><path d="M21 16h-3a2 2 0 0 0-2 2v3"></path><path d="M21 21v.01"></path><path d="M12 7v3a2 2 0 0 1-2 2H7"></path><path d="M3 12h.01"></path><path d="M12 3h.01"></path><path d="M12 16v.01"></path><path d="M16 12h.01"></path><path d="M16 21h.01"></path><path d="M21 12v.01"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <button @click="showQr = !showQr" class="w-full py-3 border border-[#D4AF37]/30 rounded-lg text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-colors">
                                    <span x-text="showQr ? 'Hide QR Code' : 'Show QR Code'"></span>
                                </button>
                            </div>

                            <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 mt-0.5"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" x2="12" y1="9" y2="13"></line><line x1="12" x2="12.01" y1="17" y2="17"></line></svg>
                                    <div>
                                        <p class="text-sm text-yellow-500 font-medium mb-1">Important</p>
                                        <ul class="text-xs text-[#A0A0A0] space-y-1">
                                            <li>• Send only {{ $wallet->code }}{{ $wallet->network ? ' (' . $wallet->network . ')' : '' }} to this address</li>
                                            <li>• Funds will be credited after network confirmation (~10-30 minutes)</li>
                                            <li>• Sending wrong crypto/network may result in permanent loss</li>
                                            <li>• Minimum deposit: $10 equivalent</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 mt-6">
                        <a href="{{ route('wallet.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                            I'll Send Later
                        </a>
                        <form method="POST" action="{{ route('wallet.deposit.process') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="payment_method" value="crypto">
                            <input type="hidden" name="confirm_payment" value="1">
                            <button type="submit" class="w-full btn-primary justify-center py-4" onclick="return confirm('Have you sent the exact crypto amount to the address shown?');">
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
