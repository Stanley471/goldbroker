<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Pending - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-16">
    <div class="section-inner">
        <div class="max-w-lg mx-auto text-center">

            <div class="w-20 h-20 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>

            <h1 class="text-3xl font-bold text-white mb-3" style="font-family: 'Playfair Display';">Order Pending</h1>
            <p class="text-[#A0A0A0] mb-8">Your order has been received. Please complete your payment using the details below. Your gold will be reserved for 24 hours.</p>

            @php $method = session('payment_method', 'bank_transfer'); $total = session('total', 0); @endphp

            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 text-left mb-6">
                <h2 class="text-lg font-semibold text-white mb-4" style="font-family: 'Playfair Display';">
                    @if($method === 'card') Card Payment
                    @elseif($method === 'crypto') Cryptocurrency Payment
                    @else Bank Transfer
                    @endif
                </h2>

                @if($method === 'bank_transfer')
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Bank Name</span>
                            <span class="text-xs text-white">GoldVault Bank</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Account Name</span>
                            <span class="text-xs text-white">GoldVault Ltd</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Account Number</span>
                            <span class="text-xs text-white">1234567890</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">SWIFT/BIC</span>
                            <span class="text-xs text-white">GOLDVAULTXXX</span>
                        </div>
                        <div class="flex justify-between border-t border-[#D4AF37]/10 pt-3">
                            <span class="text-xs text-[#A0A0A0]">Amount to Transfer</span>
                            <span class="text-sm text-[#D4AF37] font-bold">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                @elseif($method === 'crypto')
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Bitcoin (BTC)</span>
                            <span class="text-xs text-white font-mono">1A1zP1eP5QGefi2DMPTfTL5SLmv7Divf</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Ethereum (ETH)</span>
                            <span class="text-xs text-white font-mono">0x742d35Cc6634C0532925a3b844Bc9e7</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">USDT (TRC20)</span>
                            <span class="text-xs text-white font-mono">TRx1234567890ABCDEFGHIJKLMNOP</span>
                        </div>
                        <div class="flex justify-between border-t border-[#D4AF37]/10 pt-3">
                            <span class="text-xs text-[#A0A0A0]">Amount</span>
                            <span class="text-sm text-[#D4AF37] font-bold">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>