<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>Order Pending - GoldBroker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Success Header --}}
            <div class="text-center mb-10">
                <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Order Awaiting Confirmation</h1>
                <p class="text-[#A0A0A0] max-w-lg mx-auto">Your order has been placed and is now pending payment confirmation. We'll notify you once your payment is received and processed.</p>
            </div>

            <div class="max-w-2xl mx-auto">
                @if($transaction)
                {{-- Transaction Details --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Order Details</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Reference Number</span>
                            <code class="text-[#D4AF37] font-mono">{{ $transaction->reference_number }}</code>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Total Amount</span>
                            <span class="text-white font-semibold">${{ number_format($transaction->amount, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Payment Method</span>
                            <span class="text-white">
                                @if($transaction->payment_method === 'crypto')
                                    Cryptocurrency
                                @else
                                    Bank Transfer
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Status</span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-500/20 text-yellow-400 text-sm rounded-full">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                                Pending Payment
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-[#0A0A0A] rounded-lg">
                            <span class="text-[#A0A0A0]">Order Date</span>
                            <span class="text-white">{{ $transaction->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>

                {{-- What to Expect --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4"/>
                            <path d="M12 8h.01"/>
                        </svg>
                        What to Expect
                    </h3>
                    
                    <div class="space-y-4">
                        @if($transaction->payment_method === 'crypto')
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-sm font-bold">1</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Network Confirmation</p>
                                    <p class="text-sm text-[#A0A0A0]">Your crypto payment will be confirmed on the blockchain (typically 10-30 minutes).</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-sm font-bold">2</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Payment Verification</p>
                                    <p class="text-sm text-[#A0A0A0]">Our team will verify your payment within 1-2 hours.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-sm font-bold">1</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Bank Processing</p>
                                    <p class="text-sm text-[#A0A0A0]">Bank transfers typically take 1-3 business days to arrive.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-sm font-bold">2</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">Payment Verification</p>
                                    <p class="text-sm text-[#A0A0A0]">Our team will verify your payment upon receipt.</p>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-green-500 text-sm font-bold">✓</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">Order Completed</p>
                                <p class="text-sm text-[#A0A0A0]">Once confirmed, your order will be processed and products added to your vault.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Important Note --}}
                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 mt-0.5">
                            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" x2="12" y1="9" y2="13"/>
                            <line x1="12" x2="12.01" y1="17" y2="17"/>
                        </svg>
                        <div>
                            <p class="text-yellow-500 font-medium mb-1">Keep Your Reference Number</p>
                            <p class="text-sm text-[#A0A0A0]">Save your reference number <strong class="text-white">{{ $transaction->reference_number }}</strong> for your records. You'll need it if you contact support about this order.</p>
                        </div>
                    </div>
                </div>
                @else
                {{-- Generic Pending Message --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-6 text-center">
                    <p class="text-[#A0A0A0]">Your order is being processed. Please check your email for payment instructions.</p>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <a href="{{ route('dashboard') }}" class="flex-1 btn-primary justify-center py-4 text-center">
                        Go to Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="flex-1 py-4 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-center hover:bg-[#D4AF37]/10 transition-colors">
                        Continue Shopping
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-6">
    <div class="section-container">
        <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldBroker. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
