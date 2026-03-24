<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Vault - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Messages --}}
            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">{{ session('error') }}</div>
            @endif

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">My Vault</h1>
                <p class="text-[#A0A0A0]">Welcome back, {{ auth()->user()->first_name }}. Here's an overview of your precious metals portfolio.</p>
            </div>

            {{-- Stats --}}
            <div class="grid md:grid-cols-4 gap-6 mb-10">
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">USD Balance</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($wallet->usd_balance, 2) }}</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Total Products</p>
                    <p class="text-3xl font-bold text-white">{{ $holdingsSummary['total_products'] ?? 0 }}</p>
                    <p class="text-sm text-[#666]">{{ $holdingsSummary['unique_products'] ?? 0 }} different types</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Portfolio Value</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($holdingsSummary['total_current_value'] ?? 0, 2) }}</p>
                    @if(($holdingsSummary['profit_loss'] ?? 0) >= 0)
                        <p class="text-sm text-green-500">+${{ number_format($holdingsSummary['profit_loss'] ?? 0, 2) }} ({{ number_format($holdingsSummary['profit_loss_percent'] ?? 0, 2) }}%)</p>
                    @else
                        <p class="text-sm text-red-500">-${{ number_format(abs($holdingsSummary['profit_loss'] ?? 0), 2) }} ({{ number_format($holdingsSummary['profit_loss_percent'] ?? 0, 2) }}%)</p>
                    @endif
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Total Gold Weight</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($holdingsSummary['total_gold_grams'] ?? 0, 2) }}g</p>
                    @if(($holdingsSummary['total_silver_grams'] ?? 0) > 0)
                        <p class="text-sm text-[#666]">{{ number_format($holdingsSummary['total_silver_grams'], 2) }}g silver</p>
                    @endif
                </div>
            </div>

            {{-- Tabs --}}
            <div x-data="{ tab: 'holdings' }">
                <div class="inline-flex items-center justify-center rounded-lg bg-[#141414] border border-[#D4AF37]/20 p-1 mb-6">
                    <button @click="tab = 'holdings'" :class="tab === 'holdings' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors">Holdings</button>
                    <button @click="tab = 'deposit'" :class="tab === 'deposit' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors">Deposit</button>
                    <button @click="tab = 'transactions'" :class="tab === 'transactions' ? 'bg-[#D4AF37] text-[#0A0A0A]' : 'text-[#A0A0A0] hover:text-white'"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors">Transactions</button>
                </div>

                {{-- Holdings Tab --}}
                <div x-show="tab === 'holdings'">
                    @if(count($holdingsGrouped) > 0)
                        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-[#D4AF37]/20">
                                            <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Product</th>
                                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Quantity</th>
                                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Purchase Price</th>
                                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Current Value</th>
                                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">P/L</th>
                                            <th class="text-center py-4 px-6 text-[#A0A0A0] font-medium text-sm">Metal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($holdingsGrouped as $group)
                                            <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center gap-3">
                                                        @if($group['product']->image)
                                                            <img src="{{ asset('storage/' . $group['product']->image) }}" alt="{{ $group['product']->name }}" class="w-10 h-10 object-cover rounded">
                                                        @else
                                                            <span class="text-2xl">{{ $group['product']->metal_type === 'gold' ? '🥇' : '🥈' }}</span>
                                                        @endif
                                                        <div>
                                                            <p class="text-white font-medium">{{ $group['product']->name }}</p>
                                                            <p class="text-xs text-[#666]">{{ number_format($group['product']->weight_grams, 2) }}g {{ $group['product']->metal_type }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right py-4 px-6">
                                                    <p class="text-white font-semibold">{{ $group['total_quantity'] }}</p>
                                                </td>
                                                <td class="text-right py-4 px-6">
                                                    <p class="text-[#A0A0A0]">${{ number_format($group['total_purchase_price'], 2) }}</p>
                                                    <p class="text-xs text-[#666]">${{ number_format($group['total_purchase_price'] / $group['total_quantity'], 2) }}/unit</p>
                                                </td>
                                                <td class="text-right py-4 px-6">
                                                    <p class="text-[#D4AF37] font-semibold">${{ number_format($group['current_value'], 2) }}</p>
                                                    <p class="text-xs text-[#666]">${{ number_format($group['current_value'] / $group['total_quantity'], 2) }}/unit</p>
                                                </td>
                                                <td class="text-right py-4 px-6">
                                                    @if($group['profit_loss'] >= 0)
                                                        <p class="text-green-500 font-semibold">+${{ number_format($group['profit_loss'], 2) }}</p>
                                                        <p class="text-xs text-green-500">+{{ number_format($group['profit_loss_percent'], 2) }}%</p>
                                                    @else
                                                        <p class="text-red-500 font-semibold">-${{ number_format(abs($group['profit_loss']), 2) }}</p>
                                                        <p class="text-xs text-red-500">{{ number_format($group['profit_loss_percent'], 2) }}%</p>
                                                    @endif
                                                </td>
                                                <td class="text-center py-4 px-6">
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $group['product']->metal_type === 'gold' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-gray-500/20 text-gray-400' }}">
                                                        {{ ucfirst($group['product']->metal_type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-[#0A0A0A]">
                                        <tr>
                                            <td class="py-4 px-6 text-[#A0A0A0] font-medium">Total</td>
                                            <td class="text-right py-4 px-6 text-white font-semibold">{{ $holdingsSummary['total_products'] }}</td>
                                            <td class="text-right py-4 px-6 text-[#A0A0A0]">${{ number_format($holdingsSummary['total_purchase_value'], 2) }}</td>
                                            <td class="text-right py-4 px-6 text-[#D4AF37] font-bold">${{ number_format($holdingsSummary['total_current_value'], 2) }}</td>
                                            <td class="text-right py-4 px-6 {{ ($holdingsSummary['profit_loss'] ?? 0) >= 0 ? 'text-green-500' : 'text-red-500' }} font-semibold">
                                                {{ ($holdingsSummary['profit_loss'] ?? 0) >= 0 ? '+' : '-' }}${{ number_format(abs($holdingsSummary['profit_loss'] ?? 0), 2) }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-12 text-center">
                            <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No Holdings Yet</h3>
                            <p class="text-[#A0A0A0] mb-6">Start building your precious metals portfolio by browsing our products.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#D4AF37] text-[#0A0A0A] rounded-xl font-medium hover:bg-[#B8860B] transition-colors">
                                Browse Products
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Deposit Tab --}}
                <div x-show="tab === 'deposit'" style="display: none;">
                    <div class="max-w-4xl">
                        <h2 class="text-xl font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Choose Payment Method</h2>
                        
                        <div class="grid sm:grid-cols-3 gap-4 mb-8">
                            {{-- Credit Card --}}
                            <a href="{{ route('wallet.deposit') }}?method=card" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 hover:border-[#D4AF37] transition-all group">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-[#D4AF37]/30 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Credit Card</h3>
                                <p class="text-xs text-[#A0A0A0] mb-3">Visa, Mastercard, Amex</p>
                                <span class="text-xs px-2 py-1 bg-green-500/20 text-green-400 rounded">Instant</span>
                            </a>

                            {{-- Cryptocurrency --}}
                            <a href="{{ route('wallet.deposit') }}?method=crypto" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 hover:border-[#D4AF37] transition-all group">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-[#D4AF37]/30 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M9.5 9.5c.5-1 1.5-1.5 2.5-1.5s2 .5 2.5 1.5"></path><path d="M9.5 14.5c.5 1 1.5 1.5 2.5 1.5s2-.5 2.5-1.5"></path><path d="M12 8v8"></path></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Cryptocurrency</h3>
                                <p class="text-xs text-[#A0A0A0] mb-3">BTC, ETH, USDT, USDC</p>
                                <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded">~10 min</span>
                            </a>

                            {{-- Bank Transfer --}}
                            <a href="{{ route('wallet.deposit') }}?method=bank" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 hover:border-[#D4AF37] transition-all group">
                                <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-[#D4AF37]/30 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <h3 class="text-white font-semibold mb-1">Bank Transfer</h3>
                                <p class="text-xs text-[#A0A0A0] mb-3">Wire, ACH, SEPA</p>
                                <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded">1-3 days</span>
                            </a>
                        </div>

                        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                                <div>
                                    <h4 class="text-white font-medium mb-1">Deposit Information</h4>
                                    <ul class="text-sm text-[#A0A0A0] space-y-1">
                                        <li>• Minimum deposit: $10.00</li>
                                        <li>• Maximum deposit: $100,000.00</li>
                                        <li>• Credit card deposits are instant with a 2.5% fee</li>
                                        <li>• Crypto and Bank transfers have no fees</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Transactions Tab --}}
                <div x-show="tab === 'transactions'" style="display: none;">
                    {{-- Pending Transactions Alert --}}
                    @php
                        $pendingTransactions = $transactions->where('status', 'pending');
                    @endphp
                    @if($pendingTransactions->count() > 0)
                        <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500 mt-0.5">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                <div>
                                    <p class="text-yellow-500 font-medium mb-1">Pending Transactions</p>
                                    <p class="text-sm text-[#A0A0A0]">You have {{ $pendingTransactions->count() }} transaction(s) awaiting confirmation.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#D4AF37]/20">
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Amount</th>
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Status</th>
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Description</th>
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $tx)
                                        <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                            <td class="py-4 px-6">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if(in_array($tx->type, ['deposit', 'buy'])) bg-blue-500/20 text-blue-400
                                                    @else bg-red-500/20 text-red-400 @endif">
                                                    {{ ucfirst($tx->type) }}
                                                </span>
                                            </td>
                                            <td class="text-right py-4 px-6 text-white font-semibold">${{ number_format($tx->amount, 2) }}</td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium
                                                    @if($tx->status === 'pending') bg-yellow-500/20 text-yellow-400
                                                    @elseif($tx->status === 'completed') bg-green-500/20 text-green-400
                                                    @else bg-red-500/20 text-red-400
                                                    @endif">
                                                    <span class="w-1.5 h-1.5 rounded-full
                                                        @if($tx->status === 'pending') bg-yellow-500 animate-pulse
                                                        @elseif($tx->status === 'completed') bg-green-500
                                                        @else bg-red-500
                                                        @endif"></span>
                                                    {{ ucfirst($tx->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-[#A0A0A0] text-sm">{{ $tx->description ?? '--' }}</td>
                                            <td class="py-4 px-6">
                                                @if($tx->reference_number)
                                                    <code class="text-[#D4AF37] font-mono text-xs">{{ $tx->reference_number }}</code>
                                                @else
                                                    <span class="text-[#666]">--</span>
                                                @endif
                                            </td>
                                            <td class="text-right py-4 px-6 text-[#666] text-sm">{{ $tx->created_at->format('M j, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center py-8 text-[#666]">No transactions yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
