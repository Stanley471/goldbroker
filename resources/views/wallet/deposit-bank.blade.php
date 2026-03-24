<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer Deposit - GoldVault</title>
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
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Bank Transfer</h1>
                <p class="text-[#A0A0A0]">Select a bank account and send funds via wire transfer, ACH, or SEPA.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="max-w-4xl">
                {{-- Amount Display --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[#A0A0A0] mb-1">Deposit Amount</p>
                            <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($amount, 2) }} <span class="text-lg text-[#A0A0A0]">USD</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-[#A0A0A0] mb-1">Processing Time</p>
                            <p class="text-white">1-3 Business Days</p>
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
                            class="w-full p-6 rounded-xl border transition-all text-left">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-white font-semibold">{{ $account->bank_name }}</h3>
                                        <span class="px-2 py-0.5 bg-[#0A0A0A] rounded text-xs text-[#A0A0A0]">{{ $account->currency }}</span>
                                    </div>
                                    <p class="text-sm text-[#A0A0A0] mb-1">{{ $account->account_name }}</p>
                                    <code class="text-xs text-[#D4AF37] bg-[#0A0A0A] px-2 py-1 rounded">{{ $account->masked_account_number }}</code>
                                </div>
                            </div>
                        </button>

                        {{-- Bank Details (shown when selected) --}}
                        <div x-show="selectedId === {{ $account->id }}" x-transition class="p-6 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                            <h4 class="text-white font-medium mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                Bank Transfer Details
                            </h4>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                    <p class="text-xs text-[#A0A0A0] mb-1">Account Name</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-white font-medium">{{ $account->account_name }}</p>
                                        <button onclick="navigator.clipboard.writeText('{{ $account->account_name }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                    <p class="text-xs text-[#A0A0A0] mb-1">Account Number</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-white font-medium font-mono">{{ $account->masked_account_number }}</p>
                                        <button onclick="navigator.clipboard.writeText('{{ $account->account_number }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                @if($account->routing_number)
                                    <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">Routing Number (ACH/Domestic Wire)</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-white font-medium font-mono">{{ $account->routing_number }}</p>
                                            <button onclick="navigator.clipboard.writeText('{{ $account->routing_number }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if($account->swift_code)
                                    <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">SWIFT/BIC (International Wire)</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-white font-medium font-mono">{{ $account->swift_code }}</p>
                                            <button onclick="navigator.clipboard.writeText('{{ $account->swift_code }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if($account->iban)
                                    <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">IBAN (SEPA Transfers)</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-white font-medium font-mono text-sm">{{ $account->iban }}</p>
                                            <button onclick="navigator.clipboard.writeText('{{ $account->iban }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @if($account->bank_address)
                                    <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0] mb-1">Bank Address</p>
                                        <p class="text-white text-sm">{{ $account->bank_name }}</p>
                                        <p class="text-[#A0A0A0] text-sm">{{ $account->bank_address }}</p>
                                    </div>
                                @endif

                                @if($account->instructions)
                                    <div class="p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                        <p class="text-xs text-yellow-500 mb-1">Special Instructions</p>
                                        <p class="text-white text-sm">{{ $account->instructions }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Instructions --}}
                    <div class="mt-6 p-6 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                        <h4 class="text-white font-medium mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                            Important Instructions
                        </h4>
                        <ul class="space-y-3 text-sm text-[#A0A0A0]">
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">1.</span>
                                <span>Include the exact reference number <strong class="text-white">{{ $reference }}</strong> in your transfer memo/description</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">2.</span>
                                <span>Send the exact amount of <strong class="text-white">${{ number_format($amount, 2) }}</strong>. Partial payments may be delayed</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">3.</span>
                                <span>Third-party transfers are not accepted. Account holder name must match your GoldVault profile</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">4.</span>
                                <span>Keep your transfer receipt until funds are credited to your account</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Processing Times --}}
                    <div class="mt-6 p-6 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                        <h4 class="text-white font-medium mb-4">Processing Times</h4>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M12 2v20M2 12h20"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">Domestic Wire (US)</p>
                                    <p class="text-xs text-[#A0A0A0]">1-2 business days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">International Wire</p>
                                    <p class="text-xs text-[#A0A0A0]">2-3 business days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">ACH Transfer</p>
                                    <p class="text-xs text-[#A0A0A0]">1-3 business days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-500"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">SEPA Transfer</p>
                                    <p class="text-xs text-[#A0A0A0]">1-2 business days</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 mt-8">
                        <a href="{{ route('wallet.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                            I'll Send Later
                        </a>
                        <form method="POST" action="{{ route('wallet.deposit.process') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="payment_method" value="bank">
                            <input type="hidden" name="confirm_payment" value="1">
                            <button type="submit" class="w-full btn-primary justify-center py-4">
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
