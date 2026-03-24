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
                <p class="text-[#A0A0A0]">Send funds via wire transfer, ACH, or SEPA to credit your account.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-2 gap-8 max-w-5xl">
                
                {{-- Bank Details --}}
                <div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-semibold">Bank Transfer Details</h3>
                                <p class="text-xs text-[#A0A0A0]">{{ $bankDetails['bank_name'] }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                <p class="text-xs text-[#A0A0A0] mb-1">Account Name</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-medium">{{ $bankDetails['account_name'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $bankDetails['account_name'] }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                <p class="text-xs text-[#A0A0A0] mb-1">Account Number</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-medium font-mono">{{ $bankDetails['account_number'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ str_replace('*', '', $bankDetails['account_number']) }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                <p class="text-xs text-[#A0A0A0] mb-1">Routing Number (ACH/Domestic Wire)</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-medium font-mono">{{ $bankDetails['routing_number'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $bankDetails['routing_number'] }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                <p class="text-xs text-[#A0A0A0] mb-1">SWIFT/BIC (International Wire)</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-medium font-mono">{{ $bankDetails['swift'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $bankDetails['swift'] }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 bg-[#0A0A0A] rounded-lg">
                                <p class="text-xs text-[#A0A0A0] mb-1">IBAN (SEPA Transfers)</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-medium font-mono text-sm">{{ $bankDetails['iban'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $bankDetails['iban'] }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-lg">
                                <p class="text-xs text-[#D4AF37] mb-1">Reference/Memo (Required)</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-[#D4AF37] font-bold font-mono">{{ $bankDetails['reference'] }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $bankDetails['reference'] }}')" class="p-1.5 hover:bg-[#D4AF37]/20 rounded transition-colors" title="Copy">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
                                    </button>
                                </div>
                                <p class="text-xs text-[#A0A0A0] mt-2">⚠️ Include this reference in your transfer memo</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Address --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <h4 class="text-white font-medium mb-3">Bank Address</h4>
                        <p class="text-sm text-[#A0A0A0]">{{ $bankDetails['bank_name'] }}</p>
                        <p class="text-sm text-[#A0A0A0]">{{ $bankDetails['bank_address'] }}</p>
                    </div>
                </div>

                {{-- Instructions & Summary --}}
                <div>
                    {{-- Deposit Summary --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Deposit Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Amount to Deposit</span>
                                <span class="text-white font-semibold">${{ number_format($amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-[#A0A0A0]">Processing Fee</span>
                                <span class="text-green-500">$0.00</span>
                            </div>
                            <div class="border-t border-[#D4AF37]/20 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-white font-medium">Total to Send</span>
                                    <span class="text-[#D4AF37] font-bold text-lg">${{ number_format($amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-[#0A0A0A] rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                <span class="text-sm text-white font-medium">Processing Time</span>
                            </div>
                            <ul class="text-xs text-[#A0A0A0] space-y-1">
                                <li>• Domestic Wire (US): 1-2 business days</li>
                                <li>• International Wire: 2-3 business days</li>
                                <li>• ACH Transfer: 1-3 business days</li>
                                <li>• SEPA Transfer: 1-2 business days</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Instructions --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                        <h4 class="text-white font-medium mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                            Important Instructions
                        </h4>
                        <ul class="space-y-3 text-sm text-[#A0A0A0]">
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">1.</span>
                                <span>Include the exact reference number in your transfer memo/description</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#D4AF37] mt-0.5">2.</span>
                                <span>Send the exact amount specified. Partial payments may be delayed</span>
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

                    {{-- Action Buttons --}}
                    <div class="flex gap-4">
                        <a href="{{ route('wallet.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                            I'll Send Later
                        </a>
                        <form method="POST" action="{{ route('wallet.deposit.process') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="payment_method" value="bank">
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
