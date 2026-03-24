<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-8">
    <div class="section-inner">

        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Checkout</h1>
            <p class="text-[#A0A0A0] text-sm mt-1">Complete your order</p>
        </div>

        <form method="POST" action="{{ route('checkout.process') }}" x-data="{ delivery: 'vault', payment: 'wallet' }" x-on:submit="$event.target.payment_method.value = payment" x-cloak>
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: Delivery + Payment --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Delivery Method --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Delivery Method</h2>

                        <div class="space-y-3">

                            {{-- Store in Vault --}}
                            <label class="relative cursor-pointer block">
                                <input type="radio" name="delivery_method" value="vault" class="sr-only peer" x-model="delivery">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">Store in Vault</p>
                                            <p class="text-[#A0A0A0] text-xs mt-1">Your gold is stored securely in one of our vaults. Free storage.</p>
                                        </div>
                                        <span class="ml-auto text-xs text-green-400 bg-green-500/10 px-2 py-1 rounded-full flex-shrink-0">Free</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Pick Up --}}
                            <label class="relative cursor-pointer block">
                                <input type="radio" name="delivery_method" value="pickup" class="sr-only peer" x-model="delivery">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">Pick Up from Vault</p>
                                            <p class="text-[#A0A0A0] text-xs mt-1">Collect your gold in person from one of our vault locations.</p>
                                        </div>
                                        <span class="ml-auto text-xs text-green-400 bg-green-500/10 px-2 py-1 rounded-full flex-shrink-0">Free</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Ship --}}
                            <label class="relative cursor-pointer block">
                                <input type="radio" name="delivery_method" value="ship" class="sr-only peer" x-model="delivery">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v3"></path><rect width="13" height="13" x="9" y="9" rx="2"></rect><path d="M16 9h4l2 4v4h-6V9z"></path><circle cx="11.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">Ship to My Location</p>
                                            <p class="text-[#A0A0A0] text-xs mt-1">Delivered securely to your address. 0.5% shipping fee applies.</p>
                                        </div>
                                        <span class="ml-auto text-xs text-yellow-400 bg-yellow-500/10 px-2 py-1 rounded-full flex-shrink-0">+0.5%</span>
                                    </div>
                                </div>
                            </label>

                        </div>

                        {{-- Vault Selection --}}
                        <div x-show="delivery === 'vault' || delivery === 'pickup'" class="mt-6">
                            <label class="block text-sm text-[#A0A0A0] mb-3">Select Vault Location</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($vaults as $vault)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="vault_id" value="{{ $vault->id }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                            <p class="text-white font-medium text-sm">{{ $vault->city }}, {{ $vault->country }}</p>
                                            <p class="text-[#A0A0A0] text-xs mt-1">{{ $vault->address }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        <div x-show="delivery === 'ship'" class="mt-6">
                            <label class="block text-sm text-[#A0A0A0] mb-2">Shipping Address</label>
                            <textarea name="shipping_address" rows="3" placeholder="Enter your full shipping address..."
                                class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors"></textarea>
                        </div>

                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Payment Method</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            {{-- Wallet --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="wallet" class="sr-only peer" x-model="payment" checked>
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path></svg>
                                        <div>
                                            <p class="text-white font-medium text-sm">Wallet Balance</p>
                                            <p class="text-xs text-[#D4AF37]">${{ number_format($wallet->usd_balance, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            {{-- Card --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="sr-only peer" x-model="payment">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                                        <div>
                                            <p class="text-white font-medium text-sm">Credit / Debit Card</p>
                                            <p class="text-xs text-[#A0A0A0]">Visa, Mastercard</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            {{-- Crypto --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="crypto" class="sr-only peer" x-model="payment">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"></path></svg>
                                        <div>
                                            <p class="text-white font-medium text-sm">Cryptocurrency</p>
                                            <p class="text-xs text-[#A0A0A0]">BTC, ETH, USDT</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            {{-- Bank Transfer --}}
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" x-model="payment">
                                <div class="p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/5 transition-all">
                                    <div class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 11 19-9-9 19-2-8-8-2z"></path></svg>
                                        <div>
                                            <p class="text-white font-medium text-sm">Bank Transfer</p>
                                            <p class="text-xs text-[#A0A0A0]">Wire transfer</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                        </div>

                        {{-- Wallet insufficient warning --}}
                        <div x-show="payment === 'wallet'" class="mt-4">
                            @if($wallet->usd_balance < $total)
                                <div class="p-3 bg-red-500/10 border border-red-500/20 rounded-xl">
                                    <p class="text-xs text-red-400">Insufficient wallet balance. <a href="{{ route('wallet.index') }}" class="underline">Deposit funds</a> or choose another payment method.</p>
                                </div>
                            @else
                                <div class="p-3 bg-green-500/10 border border-green-500/20 rounded-xl">
                                    <p class="text-xs text-green-400">Your wallet balance is sufficient for this order.</p>
                                </div>
                            @endif
                        </div>

                        <div x-show="payment !== 'wallet'" class="mt-4">
                            <div class="p-3 bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-xl">
                                <p class="text-xs text-[#A0A0A0]">You will receive payment instructions after placing your order. Your gold will be reserved for 24 hours.</p>
                            </div>
                        </div>

                    </div>
                    {{-- Submit Button --}}
                        <button type="submit" class="w-full btn-primary justify-center py-4 mt-6">
                            Place Order
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </button>

                    </div>
                    {{-- End payment method div --}}

                </div>

                {{-- Right: Order Summary --}}
                <div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 sticky top-24">