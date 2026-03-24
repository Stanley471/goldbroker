<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

{{-- Top Bar --}}
<div class="w-full bg-[#0A0A0A] border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-10">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-500 font-medium">LIVE</span>
                </div>
                @if($goldPrice)
                    <span class="text-sm font-semibold text-[#D4AF37]">${{ number_format($goldPrice->price_per_gram_usd, 2) }}/g</span>
                @endif
            </div>
            <a href="/contact" class="hidden sm:flex items-center gap-1.5 text-xs text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Contact us</a>
        </div>
    </div>
</div>

<nav class="sticky top-0 z-40 bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center">
                    <span class="text-[#0A0A0A] font-bold text-sm">G</span>
                </div>
                <span class="hidden sm:block text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-[#A0A0A0] hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-primary text-sm py-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-[#A0A0A0] hover:text-white transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm py-2">Create Account</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="section-container py-10">
    <div class="section-inner">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-[#A0A0A0] mb-8">
            <a href="/products" class="hover:text-[#D4AF37] transition-colors">Products</a>
            <span>/</span>
            <span class="text-white">{{ $product->name }}</span>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Image --}}
            <div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden aspect-square flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-24 h-24 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                            <span class="text-[#D4AF37] text-4xl font-bold">{{ strtoupper(substr($product->metal_type, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div>
                @if($product->brand)
                    <p class="text-xs text-[#D4AF37] uppercase tracking-widest mb-2">{{ $product->brand }}</p>
                @endif
                <h1 class="text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">{{ $product->name }}</h1>

                <div class="flex items-center gap-3 mb-6">
                    <span class="px-3 py-1 text-xs rounded-full {{ $product->metal_type === 'gold' ? 'bg-[#D4AF37]/20 text-[#D4AF37]' : 'bg-gray-500/20 text-gray-400' }} font-semibold">
                        {{ ucfirst($product->metal_type) }}
                    </span>
                    <span class="text-xs text-[#A0A0A0]">{{ $product->weight_grams }}g</span>
                    @if($product->stock > 0)
                        <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">In Stock ({{ $product->stock }})</span>
                    @else
                        <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full">Out of Stock</span>
                    @endif
                </div>

                {{-- Price --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 mb-6">
                    <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-2">Price</p>
                    @if($goldPrice)
                        <p class="text-4xl font-bold text-[#D4AF37]">${{ number_format($product->current_price, 2) }}</p>
                        <p class="text-xs text-[#A0A0A0] mt-1">Based on live {{ $product->metal_type }} price · Updated {{ $goldPrice->fetched_at->diffForHumans() }}</p>
                    @else
                        <p class="text-4xl font-bold text-[#D4AF37]">--</p>
                        <p class="text-xs text-[#A0A0A0] mt-1">Price unavailable</p>
                    @endif
                </div>

                {{-- Add to Cart --}}
                @auth
                    @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.add') }}" class="mb-6" x-data="{ qty: 1 }">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-4">
                                <label class="block text-sm text-[#A0A0A0] mb-2">Quantity</label>
                                <div class="flex items-center gap-3">
                                    <button type="button" @click="qty = Math.max(1, qty - 1)"
                                        class="w-10 h-10 border border-[#D4AF37]/30 rounded-lg flex items-center justify-center text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path></svg>
                                    </button>
                                    <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}"
                                        class="w-20 text-center bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-2 text-white focus:border-[#D4AF37] focus:outline-none" />
                                    <button type="button" @click="qty = Math.min({{ $product->stock }}, qty + 1)"
                                        class="w-10 h-10 border border-[#D4AF37]/30 rounded-lg flex items-center justify-center text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="w-full btn-primary justify-center py-4 text-base">
                                Add to Cart
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full py-4 bg-[#141414] border border-[#D4AF37]/10 text-[#666] rounded-xl text-base cursor-not-allowed mb-6">Out of Stock</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full btn-primary justify-center py-4 text-base mb-6 block text-center">
                        Sign In to Purchase
                    </a>
                @endauth

                {{-- Description --}}
                @if($product->description)
                    <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-2xl p-6">
                        <h3 class="text-white font-semibold mb-3">Description</h3>
                        <p class="text-[#A0A0A0] text-sm leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                {{-- Trust Badges --}}
                <div class="grid grid-cols-3 gap-3 mt-6">
                    <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mx-auto mb-2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                        <p class="text-xs text-[#A0A0A0]">Insured</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mx-auto mb-2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                        <p class="text-xs text-[#A0A0A0]">Certified</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-3 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mx-auto mb-2"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                        <p class="text-xs text-[#A0A0A0]">Vault Storage</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-8 mt-10">
    <div class="section-container">
        <div class="section-inner flex flex-col sm:flex-row items-center justify-between gap-4">
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