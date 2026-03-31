<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoldBroker - Buy & Sell Physical Gold</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

{{-- Top Bar --}}
<div class="w-full bg-[#0A0A0A] border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-10">
            <div class="flex items-center gap-4 md:gap-6 overflow-x-auto">
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full flex-shrink-0">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-500 font-medium">LIVE</span>
                </div>
                <div class="flex items-center gap-1.5 md:gap-2 flex-shrink-0">
                    <span class="text-xs text-[#A0A0A0] uppercase tracking-wider">Gold</span>
                    <span class="text-sm font-semibold text-[#D4AF37]">
                        @if($goldPrice) ${{ number_format($goldPrice->price_per_oz_usd, 2) }} @else $-- @endif
                    </span>
                    <span class="flex items-center gap-0.5 text-xs text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
                        Live
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="/contact" class="hidden sm:flex items-center gap-1.5 text-xs text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg>
                    Contact us
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Navigation --}}
<nav class="sticky top-0 z-40 bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-20">
            <a class="flex items-center gap-3" href="/">
                <div class="w-10 h-10 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center p-2">
                    <img src="{{ Vite::asset('resources/assets/logo.svg') }}" alt="GoldVault" class="w-full h-full object-contain">
                </div>
                <span class="text-xl font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors relative group">
                    Buy Gold & Silver
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-[#D4AF37] transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('vault-locations') }}" class="px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors relative group">
                    Storage
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-[#D4AF37] transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('ira.index') }}" class="px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors relative group">
                    IRA
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-[#D4AF37] transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors relative group">
                    About
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-[#D4AF37] transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('faq') }}" class="px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors relative group">
                    FAQ
                    <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-[#D4AF37] transition-transform duration-300 scale-x-0 group-hover:scale-x-100"></span>
                </a>
            </div>
            <div class="flex items-center gap-2">
                @auth
                    {{-- Cart Icon with Count --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-[#A0A0A0] hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                        @if($cartItemCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#D4AF37] text-[#0A0A0A] text-xs font-bold rounded-full flex items-center justify-center">
                                {{ $cartItemCount > 99 ? '99+' : $cartItemCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-primary text-sm py-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block px-4 py-2 text-sm text-[#A0A0A0] hover:text-white transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm py-2">Create Account</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="min-h-screen bg-[#0A0A0A]">

    {{-- Hero --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0A0A0A] via-[#0A0A0A]/90 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-transparent to-transparent z-10"></div>
        <div class="relative z-20 section-container pt-32 pb-20">
            <div class="section-inner">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                        <span class="text-sm text-[#D4AF37]">Secure Storage Outside the Banking System</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6" style="font-family: 'Playfair Display';">
                        Investing in Physical <span class="gold-text">Gold</span> and <span class="gold-text">Silver</span>
                    </h1>
                    <p class="text-lg md:text-xl text-[#A0A0A0] leading-relaxed mb-8 max-w-2xl">
                        GoldBroker offers a high-end solution enabling individuals and companies to invest in physical gold or silver, in the form of certified bullion bars and coins. Precious metals are held in your own name and stored outside the banking system.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="{{ route('register') }}" class="btn-primary group">
                            Create an Account
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 group-hover:translate-x-1 transition-transform"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                        <a href="#how-it-works" class="btn-secondary group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path></svg>
                            Discover Our Solution
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
                                <span class="text-2xl md:text-3xl font-bold text-white">$2.8B</span>
                            </div>
                            <p class="text-sm text-[#A0A0A0]">Assets Under Storage</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                <span class="text-2xl md:text-3xl font-bold text-white">45K+</span>
                            </div>
                            <p class="text-sm text-[#A0A0A0]">Active Investors</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                <span class="text-2xl md:text-3xl font-bold text-white">4.8/5</span>
                            </div>
                            <p class="text-sm text-[#A0A0A0]">Trustpilot Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Floating Price Card --}}
        <div class="absolute bottom-8 right-8 hidden lg:block z-20">
            <div class="bg-[#141414]/90 backdrop-blur-xl border border-[#D4AF37]/20 rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-[#A0A0A0]">Gold Spot Price</p>
                        <p class="text-lg font-bold text-white">
                            @if($goldPrice) ${{ number_format($goldPrice->price_per_oz_usd, 2) }} @else $-- @endif
                        </p>
                        <p class="text-xs text-green-500">Live price</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    @if($featuredProducts->count() > 0)
    <section class="py-20 bg-[#0A0A0A]">
        <div class="section-container">
            <div class="section-inner">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Featured Products</h2>
                        <p class="text-[#A0A0A0]">Discover our most popular gold and silver bullion products.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-[#D4AF37] hover:text-[#B8860B] transition-colors font-medium">
                        View All Products
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                    <div class="group bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden hover:border-[#D4AF37]/50 transition-all duration-300">
                        <a href="{{ route('products.show', $product) }}" class="block relative">
                            <div class="aspect-square overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-[#1a1a1a] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]/30"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 bg-[#D4AF37] text-[#0A0A0A] text-xs font-bold rounded">{{ strtoupper($product->metal_type) }}</span>
                            </div>
                        </a>
                        <div class="p-5">
                            <a href="{{ route('products.show', $product) }}">
                                <h3 class="text-white font-semibold mb-2 group-hover:text-[#D4AF37] transition-colors" style="font-family: 'Playfair Display';">{{ $product->name }}</h3>
                            </a>
                            <p class="text-sm text-[#A0A0A0] mb-3">{{ $product->brand }} • {{ $product->weight_grams }}g</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-[#D4AF37]">${{ number_format($product->current_price, 2) }}</span>
                                @auth
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="px-4 py-2 bg-[#D4AF37] text-[#0A0A0A] text-sm font-semibold rounded-lg hover:bg-[#B8860B] transition-colors flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                            Add
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-[#D4AF37]/20 border border-[#D4AF37]/30 text-[#D4AF37] text-sm font-semibold rounded-lg hover:bg-[#D4AF37]/30 transition-colors">
                                        Sign In
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Live Prices Table --}}
    <section class="py-20 bg-[#0A0A0A]">
        <div class="section-container">
            <div class="section-inner">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-3xl md:text-4xl font-bold text-white" style="font-family: 'Playfair Display';">Precious Metal Spot Prices</h2>
                            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-green-500/20 text-green-400 text-xs rounded-full">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>LIVE
                            </span>
                        </div>
                        <p class="text-[#A0A0A0]">Real-time gold and silver prices from global markets.</p>
                    </div>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-[#D4AF37]/20">
                                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Metal</th>
                                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Spot Price (oz)</th>
                                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Per Gram</th>
                                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-[#D4AF37]/10 border border-[#D4AF37]/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="8" cy="8" r="6"></circle><path d="M18.09 10.37A6 6 0 1 1 10.34 18"></path><path d="M7 6h1v4"></path><path d="m16.71 13.88.7.71-2.82 2.82"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium">Gold</p>
                                                <p class="text-xs text-[#666]">Spot Price</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right py-4 px-6">
                                        <p class="text-white font-semibold">
                                            @if($goldPrice) ${{ number_format($goldPrice->price_per_oz_usd, 2) }} @else -- @endif
                                        </p>
                                    </td>
                                    <td class="text-right py-4 px-6">
                                        <p class="text-white font-semibold">
                                            @if($goldPrice) ${{ number_format($goldPrice->price_per_gram_usd, 2) }} @else -- @endif
                                        </p>
                                    </td>
                                    <td class="text-right py-4 px-6">
                                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                            Trade
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="py-20 bg-[#0A0A0A]">
        <div class="section-container">
            <div class="section-inner">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Our Services</h2>
                    <p class="text-[#A0A0A0] max-w-2xl mx-auto">We offer a complete range of services to help you invest in precious metals with confidence and security.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 hover:border-[#D4AF37]/50 transition-all duration-500">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background-color: rgba(212, 175, 55, 0.125);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: rgb(212, 175, 55);"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path><path d="M6 13h12"></path><path d="M6 17h12"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3" style="font-family: 'Playfair Display';">Vault Storage</h3>
                        <p class="text-[#A0A0A0] mb-6 leading-relaxed">Secure storage outside the banking system, in your own name, with direct access to the vaults.</p>
                        <ul class="space-y-2 mb-8">
                            @foreach(['Direct Ownership', 'Full Insurance', '24/7 Security', 'Free-Trade Zones'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                        <a href="#" class="inline-flex items-center gap-2 text-[#D4AF37] font-medium group-hover:gap-3 transition-all">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="group bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 hover:border-[#D4AF37]/50 transition-all duration-500">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background-color: rgba(212, 175, 55, 0.125);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: rgb(212, 175, 55);"><path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3" style="font-family: 'Playfair Display';">IRA Investment</h3>
                        <p class="text-[#A0A0A0] mb-6 leading-relaxed">Invest in physical gold and silver through your retirement account with tax advantages.</p>
                        <ul class="space-y-2 mb-8">
                            @foreach(['Tax Advantages', 'Physical Metals', 'IRS Approved', 'Retirement Growth'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-[#D4AF37] font-medium group-hover:gap-3 transition-all">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="group bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 hover:border-[#D4AF37]/50 transition-all duration-500">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mb-6" style="background-color: rgba(192, 192, 192, 0.125);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: rgb(192, 192, 192);"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-3" style="font-family: 'Playfair Display';">Buyback Program</h3>
                        <p class="text-[#A0A0A0] mb-6 leading-relaxed">Sell your precious metals back to us at competitive market rates with instant liquidity.</p>
                        <ul class="space-y-2 mb-8">
                            @foreach(['Competitive Rates', 'Instant Quotes', 'Fast Settlement', 'No Hidden Fees'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-[#D4AF37] font-medium group-hover:gap-3 transition-all">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 bg-[#0A0A0A]">
        <div class="section-container">
            <div class="section-inner">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">How to Invest in Gold?</h2>
                    <p class="text-[#A0A0A0] max-w-2xl mx-auto">Getting started with precious metals investment is simple. Follow these four easy steps to secure your wealth.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Create an Account', 'desc' => 'Complete the registration form and verify your profile by providing the required supporting documents.'],
                            ['num' => '02', 'title' => 'Place an Order', 'desc' => 'Choose the desired products and services, lock in a purchase price, then validate your order.'],
                            ['num' => '03', 'title' => 'Proceed to Payment', 'desc' => 'Pay for your order by bank transfer, credit card, or cryptocurrency. We support multiple payment methods.'],
                            ['num' => '04', 'title' => 'Secure Storage', 'desc' => 'Your precious metals are stored in ultra-secure vaults in your own name.'],
                        ];
                    @endphp
                    @foreach($steps as $step)
                    <div class="relative">
                        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 h-full hover:border-[#D4AF37]/50 transition-all duration-300 group">
                            <div class="absolute -top-3 -left-3 w-10 h-10 bg-[#D4AF37] rounded-lg flex items-center justify-center">
                                <span class="text-[#0A0A0A] font-bold text-sm">{{ $step['num'] }}</span>
                            </div>
                            <div class="mt-4 mb-4">
                                <h3 class="text-lg font-semibold text-white mb-3" style="font-family: 'Playfair Display';">{{ $step['title'] }}</h3>
                                <p class="text-sm text-[#A0A0A0] leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('register') }}" class="btn-primary inline-flex">
                        Create an Account
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Trust Badges --}}
    <section class="py-16 bg-[#141414] border-y border-[#D4AF37]/10">
        <div class="section-container">
            <div class="section-inner">
                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">We Put Safety at the Core of Our Business</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                    @php
                        $badges = [
                            ['title' => 'Fully Insured', 'desc' => "All metals insured by Lloyd's of London"],
                            ['title' => 'SSL Secure', 'desc' => '256-bit encryption for all transactions'],
                            ['title' => 'LBMA Approved', 'desc' => 'London Bullion Market Association certified'],
                            ['title' => '24/7 Support', 'desc' => 'Expert assistance whenever you need it'],
                            ['title' => 'Direct Ownership', 'desc' => 'Metals held in your own name'],
                        ];
                    @endphp
                    @foreach($badges as $badge)
                    <div class="flex flex-col items-center text-center">
                        <div class="w-14 h-14 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                        </div>
                        <h3 class="text-white font-medium mb-1">{{ $badge['title'] }}</h3>
                        <p class="text-xs text-[#A0A0A0]">{{ $badge['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20">
    <div class="section-container py-16">
        <div class="section-inner">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-12">
                <div class="lg:col-span-2">
                    <a class="flex items-center gap-3 mb-6" href="/">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center p-2.5">
                            <img src="{{ Vite::asset('resources/assets/logo.svg') }}" alt="GoldVault" class="w-full h-full object-contain">
                        </div>
                        <span class="text-2xl font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
                    </a>
                    <p class="text-[#A0A0A0] text-sm leading-relaxed mb-6">GoldBroker offers a high-end solution enabling individuals and companies to invest in physical gold and silver, stored securely outside the banking system.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('vault-locations') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Vault Storage</a></li>
                        <li><a href="{{ route('ira.index') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">IRA Investment</a></li>
                        <li><a href="#" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Buyback Program</a></li>
                        <li><a href="{{ route('referrals.index') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Referral Program</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Contact</a></li>
                        <li><a href="{{ route('faq') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Account</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Create Account</a></li>
                        @auth
                        <li><a href="{{ route('dashboard') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-[#D4AF37]/10">
        <div class="section-container py-6">
            <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-[#666]">© {{ date('Y') }} GoldBroker. All rights reserved.</div>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Terms of Use</a>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- Toast Notification for Cart --}}
@if(session('cart_success'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-4 sm:w-96 z-50">
        <div class="bg-[#141414] border border-[#D4AF37]/30 rounded-xl shadow-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M20 6 9 17l-5-5"></path></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-medium text-sm">{{ session('cart_success') }}</p>
                <p class="text-[#A0A0A0] text-xs">Item added to your cart</p>
            </div>
            <a href="{{ route('cart.index') }}" class="px-3 py-1.5 bg-[#D4AF37] text-[#0A0A0A] text-xs font-medium rounded-lg hover:bg-[#B8860B] transition-colors flex-shrink-0">
                View Cart
            </a>
        </div>
    </div>
@endif


<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'c37e68033564304dfaf83166b5587b1c6821e8d4';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>


</body>
</html>