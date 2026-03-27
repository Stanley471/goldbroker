<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

{{-- Nav --}}
<div class="w-full bg-[#0A0A0A] border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-10">
            <div class="flex items-center gap-4 overflow-x-auto">
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full flex-shrink-0">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-500 font-medium">LIVE</span>
                </div>
                <span class="text-xs text-[#A0A0A0] uppercase tracking-wider flex-shrink-0">Gold</span>
                @if($goldPrice)
                    <span class="text-sm font-semibold text-[#D4AF37] flex-shrink-0">${{ number_format($goldPrice->price_per_gram_usd, 2) }}/g</span>
                @endif
            </div>
            <a href="{{ route('contact') }}" class="hidden sm:flex items-center gap-1.5 text-xs text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">Contact us</a>
        </div>
    </div>
</div>

<nav class="sticky top-0 z-40 bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20" x-data="{ open: false }">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center p-1.5">
                    <img src="{{ Vite::asset('resources/assets/logo.svg') }}" alt="GoldVault" class="w-full h-full object-contain">
                </div>
                <span class="hidden sm:block text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>
            <div class="hidden lg:flex items-center gap-1">
                <a href="/products" class="px-3 py-2 text-sm {{ request()->routeIs('products.*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Buy Gold & Silver</a>
                <a href="{{ route('wallet.locations') }}" class="px-3 py-2 text-sm {{ request()->routeIs('wallet.locations') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Storage</a>
                <a href="{{ route('ira.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('ira.*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">IRA</a>
                <a href="{{ route('about') }}" class="px-3 py-2 text-sm {{ request()->routeIs('about') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">About</a>
                <a href="{{ route('faq') }}" class="px-3 py-2 text-sm {{ request()->routeIs('faq') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">FAQ</a>
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
                <button @click="open = !open" class="lg:hidden p-2 text-[#A0A0A0] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
                </button>
            </div>
        </div>
    </div>
    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="lg:hidden border-t border-[#D4AF37]/10 bg-[#0A0A0A]">
        <div class="section-container py-4">
            <div class="flex flex-col gap-1">
                <a href="/products" class="px-4 py-3 text-sm text-[#D4AF37] bg-[#D4AF37]/10 rounded-lg">Buy Gold & Silver</a>
                <a href="#" class="px-4 py-3 text-sm text-[#A0A0A0] rounded-lg">Storage</a>
                <a href="{{ route('ira.index') }}" class="px-4 py-3 text-sm text-[#A0A0A0] rounded-lg">IRA</a>
                <a href="/about" class="px-4 py-3 text-sm text-[#A0A0A0] rounded-lg">About</a>
                @auth
                    <a href="{{ route('cart.index') }}" class="px-4 py-3 text-sm text-[#A0A0A0] rounded-lg flex items-center justify-between">
                        <span>Cart</span>
                        @if($cartItemCount > 0)
                            <span class="px-2 py-0.5 bg-[#D4AF37] text-[#0A0A0A] text-xs font-bold rounded-full">{{ $cartItemCount }}</span>
                        @endif
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="section-container py-10">
    <div class="section-inner">

        {{-- Messages --}}
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
        @endif

        <div class="mb-10">
            <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Buy Gold & Silver</h1>
            <p class="text-[#A0A0A0]">Investment-grade bullion bars and coins at live market prices</p>
        </div>

        {{-- Filter Tabs --}}
        <div x-data="{ filter: 'all' }" class="mb-8">
            <div class="inline-flex items-center bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-1 gap-1">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors">All</button>
                <button @click="filter = 'gold'" :class="filter === 'gold' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors">Gold</button>
                <button @click="filter = 'silver'" :class="filter === 'silver' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors">Silver</button>
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-8">
                @forelse($products as $product)
                    <div x-show="filter === 'all' || filter === '{{ $product->metal_type }}'"
                        class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden group hover:border-[#D4AF37]/50 transition-all duration-300">

                        {{-- Image --}}
                        <div class="relative h-48 bg-[#0A0A0A] overflow-hidden">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                                        <span class="text-[#D4AF37] text-2xl font-bold">{{ strtoupper(substr($product->metal_type, 0, 1)) }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $product->metal_type === 'gold' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'bg-gray-400 text-[#0A0A0A]' }} font-semibold">
                                    {{ ucfirst($product->metal_type) }}
                                </span>
                            </div>
                            @if($product->stock > 0)
                                <div class="absolute top-3 right-3">
                                    <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">In Stock</span>
                                </div>
                            @else
                                <div class="absolute top-3 right-3">
                                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full">Out of Stock</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-5">
                            @if($product->brand)
                                <p class="text-xs text-[#D4AF37] mb-1">{{ $product->brand }}</p>
                            @endif
                            <h3 class="text-white font-medium mb-1 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-[#A0A0A0] mb-4">{{ $product->weight_grams }}g</p>

                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-xs text-[#A0A0A0]">From</span>
                                    <p class="text-xl font-bold text-[#D4AF37]">
                                        @if($goldPrice)
                                            ${{ number_format($product->current_price, 2) }}
                                        @else
                                            --
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                @auth
                                    @if($product->stock > 0)
                                        <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full btn-primary text-sm py-2 justify-center">Add to Cart</button>
                                        </form>
                                    @else
                                        <button disabled class="flex-1 py-2 bg-[#141414] border border-[#D4AF37]/10 text-[#666] rounded-lg text-sm cursor-not-allowed">Out of Stock</button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 btn-primary text-sm py-2 justify-center text-center">Sign in to Buy</a>
                                @endauth
                                <a href="{{ route('products.show', $product->id) }}" class="px-3 py-2 border border-[#D4AF37]/30 rounded-lg text-[#D4AF37] hover:bg-[#D4AF37]/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16">
                        <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                        </div>
                        <p class="text-white font-semibold mb-2">No products yet</p>
                        <p class="text-[#A0A0A0] text-sm">Check back soon for available products.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</main>

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

<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-8 mt-10">
    <div class="section-container">
        <div class="section-inner flex flex-col sm:flex-row items-center justify-between gap-4">
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
