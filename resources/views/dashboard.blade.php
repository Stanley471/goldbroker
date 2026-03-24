<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GoldVault</title>
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

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">Welcome back, {{ auth()->user()->first_name }}</h1>
            <p class="text-[#A0A0A0] text-sm mt-1">Here's an overview of your precious metals portfolio</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs text-[#A0A0A0] uppercase tracking-wider">Live Gold Price</p>
                    <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-green-500">LIVE</span>
                    </div>
                </div>
                @if($goldPrice)
                    <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($goldPrice->price_per_gram_usd, 2) }}</p>
                    <p class="text-xs text-[#A0A0A0] mt-1">per gram · {{ $goldPrice->fetched_at->diffForHumans() }}</p>
                    @if($priceChange)
                        <div class="flex items-center gap-1 mt-2">
                            @if($priceChange['direction'] === 'up')
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg>
                                <span class="text-xs text-green-500">+{{ number_format($priceChange['percent'], 2) }}% (24h)</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500"><path d="M16 17h6v-6"></path><path d="m22 17-8.5-8.5-5 5L2 7"></path></svg>
                                <span class="text-xs text-red-500">{{ number_format($priceChange['percent'], 2) }}% (24h)</span>
                            @endif
                        </div>
                    @endif
                @else
                    <p class="text-3xl font-bold text-[#D4AF37]">--</p>
                    <p class="text-xs text-[#A0A0A0] mt-1">Price unavailable</p>
                @endif
            </div>

            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs text-[#A0A0A0] uppercase tracking-wider">USD Balance</p>
                    <a href="{{ route('wallet.index') }}" class="text-xs text-[#D4AF37] hover:underline">Deposit →</a>
                </div>
                <p class="text-3xl font-bold text-white">${{ number_format($wallet->usd_balance, 2) }}</p>
                <p class="text-xs text-[#A0A0A0] mt-1">Available to invest</p>
            </div>

            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs text-[#A0A0A0] uppercase tracking-wider">Portfolio Value</p>
                    <span class="text-xs text-[#A0A0A0]">{{ $holdingsSummary['total_products'] ?? 0 }} products</span>
                </div>
                <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($holdingsSummary['total_current_value'] ?? 0, 2) }}</p>
                @if(($holdingsSummary['profit_loss'] ?? 0) >= 0)
                    <p class="text-xs text-green-500 mt-1">+${{ number_format($holdingsSummary['profit_loss'] ?? 0, 2) }} ({{ number_format($holdingsSummary['profit_loss_percent'] ?? 0, 2) }}%)</p>
                @else
                    <p class="text-xs text-red-500 mt-1">-${{ number_format(abs($holdingsSummary['profit_loss'] ?? 0), 2) }} ({{ number_format($holdingsSummary['profit_loss_percent'] ?? 0, 2) }}%)</p>
                @endif
            </div>

            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs text-[#A0A0A0] uppercase tracking-wider">Metal Weight</p>
                    <span class="text-xs text-[#A0A0A0]">grams</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ number_format($holdingsSummary['total_gold_grams'] ?? 0, 2) }}g</p>
                @if(($holdingsSummary['total_silver_grams'] ?? 0) > 0)
                    <p class="text-xs text-[#A0A0A0] mt-1">+{{ number_format($holdingsSummary['total_silver_grams'], 2) }}g silver</p>
                @else
                    <p class="text-xs text-[#A0A0A0] mt-1">Gold holdings</p>
                @endif
            </div>
        </div>

        {{-- Holdings Summary --}}
        @if(count($holdingsGrouped) > 0)
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Your Holdings</h2>
                    <a href="{{ route('wallet.index') }}" class="text-sm text-[#D4AF37] hover:underline">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#D4AF37]/20">
                                <th class="text-left py-3 px-4 text-[#A0A0A0] font-medium text-sm">Product</th>
                                <th class="text-right py-3 px-4 text-[#A0A0A0] font-medium text-sm">Qty</th>
                                <th class="text-right py-3 px-4 text-[#A0A0A0] font-medium text-sm">Current Value</th>
                                <th class="text-right py-3 px-4 text-[#A0A0A0] font-medium text-sm">P/L</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($holdingsGrouped, 0, 5) as $group)
                                <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xl">{{ $group['product']->metal_type === 'gold' ? '🥇' : '🥈' }}</span>
                                            <div>
                                                <p class="text-white font-medium text-sm">{{ $group['product']->name }}</p>
                                                <p class="text-xs text-[#666]">{{ number_format($group['product']->weight_grams, 1) }}g {{ $group['product']->metal_type }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right py-3 px-4 text-white">{{ $group['total_quantity'] }}</td>
                                    <td class="text-right py-3 px-4 text-[#D4AF37] font-medium">${{ number_format($group['current_value'], 2) }}</td>
                                    <td class="text-right py-3 px-4">
                                        @if($group['profit_loss'] >= 0)
                                            <span class="text-green-500 text-sm">+{{ number_format($group['profit_loss_percent'], 1) }}%</span>
                                        @else
                                            <span class="text-red-500 text-sm">{{ number_format($group['profit_loss_percent'], 1) }}%</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($holdingsGrouped) > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('wallet.index') }}" class="text-sm text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">
                            +{{ count($holdingsGrouped) - 5 }} more products
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 mb-8 text-center">
                <div class="w-12 h-12 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path></svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Start Your Portfolio</h3>
                <p class="text-[#A0A0A0] text-sm mb-4">Browse our collection of gold and silver products to begin investing.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37] text-[#0A0A0A] rounded-lg font-medium text-sm hover:bg-[#B8860B] transition-colors">
                    Browse Products
                </a>
            </div>
        @endif

        {{-- Quick Links --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('wallet.index') }}" class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-4 hover:border-[#D4AF37]/40 transition-colors text-center">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path><path d="M6 13h12"></path><path d="M6 17h12"></path></svg>
                </div>
                <p class="text-sm text-white font-medium">Vault</p>
                <p class="text-xs text-[#A0A0A0]">Portfolio & deposits</p>
            </a>
            <a href="{{ route('products.index') }}" class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-4 hover:border-[#D4AF37]/40 transition-colors text-center">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
                <p class="text-sm text-white font-medium">Products</p>
                <p class="text-xs text-[#A0A0A0]">Browse catalog</p>
            </a>
            <a href="{{ route('ira.index') }}" class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-4 hover:border-[#D4AF37]/40 transition-colors text-center">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path></svg>
                </div>
                <p class="text-sm text-white font-medium">IRA</p>
                <p class="text-xs text-[#A0A0A0]">Retirement accounts</p>
            </a>
            <a href="{{ route('referrals.index') }}" class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-4 hover:border-[#D4AF37]/40 transition-colors text-center">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path></svg>
                </div>
                <p class="text-sm text-white font-medium">Referrals</p>
                <p class="text-xs text-[#A0A0A0]">Earn bonuses</p>
            </a>
        </div>
    </div>
</main>

<footer class="border-t border-[#D4AF37]/10 py-6 mt-10">
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
