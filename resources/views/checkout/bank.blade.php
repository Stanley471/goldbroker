<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Bank Transfer - GoldVault Checkout</title>
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
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Pay with Bank Transfer</h1>
                <p class="text-[#A0A0A0]">Select a bank account and complete your order via wire transfer.</p>
            </div>

            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-2 gap-8 max-w-5xl">
                
                {{-- Left: Bank Details --}}
                <div>
                    {{-- Order Summary --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[#A0A0A0]">Order Total</span>
                            <span class="text-2xl font-bold text-[#D4AF37]">${{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                <p class="text-xs text-yellow-500">Your order is reserved for 24 hours. Bank transfers typically take 1-3 business days to process.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Reference Number --}}
                    <div class="bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-xl p-6 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-[#D4AF37] mb-1">Your Reference Number (Required)</p>
                                <p class="text-2xl font-bold text-[#D4AF37] font-mono">{{ $reference }}</p>
                                <p class="text-xs text-[#A0A0A0] mt-2">⚠️ Include this in your transfer memo/description</p>
                            </div>
                            <button onclick="navigator.clipboard.writeText('{{ $reference }}')" class="px-4 py-2 bg-[#D4AF37] text-[#0A0A0A] rounded-lg font-medium hover:bg-[#B8860B] transition-colors">
                                Copy
                            </button>
                        </div>
                    </div>

                    {{-- Bank Account Selection --}}
                    <div x-data="{ selectedId: {{ $bankAccounts->first()->id ?? 'null' }} }" class="space-y-4">
                        
                        <p class="text-sm text-[#A0A0A0] mb-3">Select Bank Account</p>
                        
                        @foreach($bankAccounts as $account)
                            <button @click="selectedId = {{ $account->id }}" 
                                :class="selectedId === {{ $account->id }} ? 'border-[#D4AF37] bg-[#D4AF37]/10' : 'border-[#D4AF37]/20 hover:border-[#D4AF37]/50'"
                                class="w-full p-4 rounded-xl border transition-all text-left">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-white font-semibold">{{ $account->bank_name }}</h3>
                                            <span class="px-2 py-0.5 bg-[#0A0A0A] rounded text-xs text-[#A0A0A0]">{{ $account->currency }}</span>
                                        </div>
                                        <p class="text-sm text-[#A0A0A0]">{{ $account->account_name }}</p>
                                        <code class="text-xs text-[#D4AF37]">{{ $account->masked_account_number }}</code>
                                    </div>
                                </div>
                            </button>

                            {{-- Bank Details (shown when selected) --}}
                            <div x-show="selectedId === {{ $account->id }}" x-transition class="p-6 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                                <h4 class="text-white font-medium mb-4">Bank Transfer Details</h4>
                                
                                <div class="space-y-3">
                                    <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">Account Name</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-white font-medium">{{ $account->account_name }}</p>
                                            <button onclick="navigator.clipboard.writeText('{{ $account->account_name }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">Account Number</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-white font-medium font-mono">{{ $account->masked_account_number }}</p>
                                            <button onclick="navigator.clipboard.writeText('{{ $account->account_number }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    @if($account->routing_number)
                                        <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                            <p class="text-xs text-[#A0A0A0] mb-1">Routing Number (ACH/Domestic)</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-white font-medium font-mono">{{ $account->routing_number }}</p>
                                                <button onclick="navigator.clipboard.writeText('{{ $account->routing_number }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($account->swift_code)
                                        <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                            <p class="text-xs text-[#A0A0A0] mb-1">SWIFT/BIC (International)</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-white font-medium font-mono">{{ $account->swift_code }}</p>
                                                <button onclick="navigator.clipboard.writeText('{{ $account->swift_code }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($account->iban)
                                        <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                            <p class="text-xs text-[#A0A0A0] mb-1">IBAN (SEPA)</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-white font-medium font-mono text-sm">{{ $account->iban }}</p>
                                                <button onclick="navigator.clipboard.writeText('{{ $account->iban }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if($account->bank_address)
                                        <div class="p-3 bg-[#0A0A0A] rounded-lg">
                                            <p class="text-xs text-[#A0A0A0] mb-1">Bank Address</p>
                                            <p class="text-white text-sm">{{ $account->bank_name }}</p>
                                            <p class="text-[#A0A0A0] text-sm">{{ $account->bank_address }}</p>
                                        </div>
                                    @endif

                                    @if($account->instructions)
                                        <div class="p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                            <p class="text-xs text-yellow-500 mb-1">Special Instructions</p>
                                            <p class="text-white text-sm">{{ $account->instructions }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Instructions --}}
                <div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <h4 class="text-white font-medium mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                            Important Instructions
                        </h4>
                        <ul class="space-y-3 text-sm text-[#A0A0A0]">
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">1.</span>
                                <span>Include the reference number <strong class="text-white">{{ $reference }}</strong> in your transfer</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">2.</span>
                                <span>Send exactly <strong class="text-white">${{ number_format($amount, 2) }}</strong></span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">3.</span>
                                <span>Account holder name must match your profile</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">4.</span>
                                <span>Keep your transfer receipt</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <h4 class="text-white font-medium mb-4">Processing Times</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Domestic Wire (US)</span>
                                <span class="text-white">1-2 business days</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">International Wire</span>
                                <span class="text-white">2-3 business days</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">ACH Transfer</span>
                                <span class="text-white">1-3 business days</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">SEPA Transfer</span>
                                <span class="text-white">1-2 business days</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4">
                        <a href="{{ route('checkout.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                            Cancel Order
                        </a>
                        <form method="POST" action="{{ route('checkout.confirm') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full btn-primary justify-center py-4" onclick="return confirm('Have you initiated the bank transfer?');">
                                I've Sent the Transfer
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
