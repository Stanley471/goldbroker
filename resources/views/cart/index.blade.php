<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>Cart - GoldBroker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-8">
    <div class="section-inner">

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
        @endif

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">My Cart</h1>
                <p class="text-[#A0A0A0] text-sm mt-1">{{ $cart->items->count() }} {{ Str::plural('item', $cart->items->count()) }}</p>
            </div>
            @if($cart->items->count() > 0)
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors">Clear Cart</button>
                </form>
            @endif
        </div>

        @if($cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart->items as $item)
                        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-5 {{ $item->is_expired ? 'border-yellow-500/30' : '' }}">

                            @if($item->is_expired)
                                <div class="mb-3 px-3 py-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                    <p class="text-xs text-yellow-400">Price expired and has been refreshed to current market price.</p>
                                </div>
                            @endif

                            <div class="flex gap-4">
                                {{-- Image --}}
                                <div class="w-20 h-20 bg-[#0A0A0A] rounded-xl overflow-hidden flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="text-[#D4AF37] font-bold">{{ strtoupper(substr($item->product->metal_type, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs text-[#D4AF37] mb-1">{{ $item->product->brand ?? ucfirst($item->product->metal_type) }}</p>
                                            <h3 class="text-white font-medium text-sm">{{ $item->product->name }}</h3>
                                            <p class="text-xs text-[#A0A0A0] mt-1">{{ $item->product->weight_grams }}g · Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-[#D4AF37] font-bold">${{ number_format($item->locked_price_per_gram * $item->product->weight_grams * $item->quantity, 2) }}</p>
                                            <p class="text-xs text-[#A0A0A0]">${{ number_format($item->locked_price_per_gram * $item->product->weight_grams, 2) }} each</p>
                                        </div>
                                    </div>

                                    {{-- Timer --}}
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            @if(!$item->is_expired)
                                                <div class="flex items-center gap-1.5 text-xs text-[#A0A0A0]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                    <span>Price locked until {{ $item->price_expires_at->format('H:i') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="space-y-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 sticky top-24">
                        <h2 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-[#A0A0A0] truncate mr-2">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                    <span class="text-white flex-shrink-0">${{ number_format($item->locked_price_per_gram * $item->product->weight_grams * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-[#D4AF37]/10 pt-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-white font-semibold">Subtotal</span>
                                <span class="text-[#D4AF37] font-bold text-lg">${{ number_format($total, 2) }}</span>
                            </div>
                            <p class="text-xs text-[#A0A0A0] mt-1">Shipping calculated at checkout</p>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="w-full btn-primary justify-center py-3 block text-center">
                            Proceed to Checkout
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>

                        <a href="/products" class="w-full btn-secondary justify-center py-3 mt-3 block text-center">
                            Continue Shopping
                        </a>

                        {{-- Price Lock Notice --}}
                        <div class="mt-4 p-3 bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-xl">
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                <p class="text-xs text-[#A0A0A0]">Prices are locked for 15 minutes. After expiry, prices update to current market rates.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-[#D4AF37]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-3" style="font-family: 'Playfair Display';">Your cart is empty</h2>
                <p class="text-[#A0A0A0] mb-8">Browse our selection of gold and silver products.</p>
                <a href="/products" class="btn-primary">Browse Products</a>
            </div>
        @endif

    </div>
</main>

<footer class="border-t border-[#D4AF37]/10 py-6 mt-10">
    <div class="section-container">
        <div class="section-inner flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldBroker. All rights reserved.</div>
        </div>
    </div>
</footer>

</body>
</html>