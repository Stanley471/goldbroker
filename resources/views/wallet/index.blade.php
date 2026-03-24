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
                    <p class="text-sm text-[#A0A0A0] mb-1">Gold Holdings</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($wallet->gold_balance_grams, 4) }}g</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Total Transactions</p>
                    <p class="text-3xl font-bold text-white">{{ $transactions->count() }}</p>
                    <p class="text-sm text-[#666]">All time</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Gold Value (USD)</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">
                        @php $goldPrice = app(\App\Services\GoldPriceService::class)->getCurrentPrice(); @endphp
                        @if($goldPrice)
                            ${{ number_format($wallet->gold_balance_grams * $goldPrice->price_per_gram_usd, 2) }}
                        @else
                            --
                        @endif
                    </p>
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
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#D4AF37]/20">
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Asset</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Balance</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">USD Value</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <span class="text-2xl">🥇</span>
                                                <div>
                                                    <p class="text-white font-medium">Gold</p>
                                                    <p class="text-xs text-[#666]">Physical gold in grams</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <p class="text-[#D4AF37] font-semibold">{{ number_format($wallet->gold_balance_grams, 6) }}g</p>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <p class="text-white font-semibold">
                                                @if($goldPrice)
                                                    ${{ number_format($wallet->gold_balance_grams * $goldPrice->price_per_gram_usd, 2) }}
                                                @else
                                                    --
                                                @endif
                                            </p>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                                Trade
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <span class="text-2xl">💵</span>
                                                <div>
                                                    <p class="text-white font-medium">USD</p>
                                                    <p class="text-xs text-[#666]">Available cash balance</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <p class="text-white font-semibold">${{ number_format($wallet->usd_balance, 2) }}</p>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <p class="text-white font-semibold">${{ number_format($wallet->usd_balance, 2) }}</p>
                                        </td>
                                        <td class="text-right py-4 px-6">
                                            <button @click="tab = 'deposit'" class="inline-flex items-center gap-1 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                                Deposit
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Deposit Tab --}}
                <div x-show="tab === 'deposit'" style="display: none;">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-8 max-w-md">
                        <h2 class="text-xl font-semibold text-white mb-2" style="font-family: 'Playfair Display';">Deposit Funds</h2>
                        <p class="text-[#A0A0A0] text-sm mb-6">Add USD to your vault to start investing in gold.</p>
                        <form method="POST" action="{{ route('wallet.deposit') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Amount (USD)</label>
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#666]"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    <input type="number" name="amount" min="1" placeholder="Enter amount"
                                        class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl pl-12 pr-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                                </div>
                                @error('amount') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="flex gap-2">
                                @foreach([100, 500, 1000, 5000] as $amount)
                                    <button type="button" onclick="this.closest('form').querySelector('input[name=amount]').value={{ $amount }}"
                                        class="px-3 py-1 text-xs rounded-full border border-[#D4AF37]/30 text-[#A0A0A0] hover:border-[#D4AF37] hover:text-white transition-colors">
                                        ${{ number_format($amount) }}
                                    </button>
                                @endforeach
                            </div>
                            <button type="submit" class="w-full btn-primary justify-center py-3">
                                Deposit Funds
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Transactions Tab --}}
                <div x-show="tab === 'transactions'" style="display: none;">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-[#D4AF37]/20">
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Amount</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Currency</th>
                                        <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Description</th>
                                        <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $tx)
                                        <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                            <td class="py-4 px-6">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if(in_array($tx->type, ['deposit', 'buy'])) bg-green-500/20 text-green-400
                                                    @else bg-red-500/20 text-red-400 @endif">
                                                    {{ ucfirst($tx->type) }}
                                                </span>
                                            </td>
                                            <td class="text-right py-4 px-6 text-white font-semibold">{{ number_format($tx->amount, 6) }}</td>
                                            <td class="text-right py-4 px-6 text-[#A0A0A0]">{{ $tx->currency }}</td>
                                            <td class="py-4 px-6 text-[#A0A0A0] text-sm">{{ $tx->description ?? '--' }}</td>
                                            <td class="text-right py-4 px-6 text-[#666] text-sm">{{ $tx->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center py-8 text-[#666]">No transactions yet.</td></tr>
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