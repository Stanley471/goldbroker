<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referrals - GoldBroker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-8">
    <div class="section-inner">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Referral Program</h1>
            <p class="text-[#A0A0A0] text-sm mt-1">Earn 0.1g of gold for every friend who signs up and makes their first purchase</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-3">Total Referrals</p>
                <p class="text-3xl font-bold text-white">{{ $totalReferrals }}</p>
                <p class="text-xs text-[#A0A0A0] mt-1">People referred</p>
            </div>
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-3">Gold Earned</p>
                <p class="text-3xl font-bold text-[#D4AF37]">{{ number_format($totalGoldEarned, 4) }}g</p>
                <p class="text-xs text-[#A0A0A0] mt-1">Total bonus gold</p>
            </div>
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-3">Pending</p>
                <p class="text-3xl font-bold text-white">{{ $pendingReferrals }}</p>
                <p class="text-xs text-[#A0A0A0] mt-1">Awaiting first purchase</p>
            </div>
        </div>

        {{-- Referral Link --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 mb-8">
            <h2 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display';">Your Referral Link</h2>
            <p class="text-[#A0A0A0] text-sm mb-4">Share this link and earn 0.1g of gold for every person who signs up and makes their first purchase.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" readonly
                    value="{{ url('/register?ref=' . auth()->user()->referral_code) }}"
                    class="flex-1 bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-[#A0A0A0] text-sm focus:outline-none" />
                <button onclick="navigator.clipboard.writeText('{{ url('/register?ref=' . auth()->user()->referral_code) }}'); this.textContent = 'Copied!';"
                    class="btn-primary justify-center px-6 py-3 whitespace-nowrap">
                    Copy Link
                </button>
            </div>
            <div class="mt-4 p-4 bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-xl">
                <p class="text-xs text-[#A0A0A0]">Your referral code: <span class="text-[#D4AF37] font-semibold tracking-widest">{{ auth()->user()->referral_code }}</span></p>
            </div>
        </div>

        {{-- How it works --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 mb-8">
            <h2 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">How It Works</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Share your link', 'desc' => 'Copy your unique referral link and share it with friends and family.'],
                        ['num' => '02', 'title' => 'They sign up', 'desc' => 'Your friend creates an account using your referral link.'],
                        ['num' => '03', 'title' => 'You earn gold', 'desc' => 'When they make their first purchase, 0.1g of gold is credited to your vault.'],
                    ];
                @endphp
                @foreach($steps as $step)
                <div class="relative">
                    <div class="w-10 h-10 bg-[#D4AF37] rounded-lg flex items-center justify-center mb-4">
                        <span class="text-[#0A0A0A] font-bold text-sm">{{ $step['num'] }}</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">{{ $step['title'] }}</h3>
                    <p class="text-[#A0A0A0] text-sm">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Referral History --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-[#D4AF37]/10">
                <h2 class="text-lg font-semibold text-white" style="font-family: 'Playfair Display';">Referral History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#D4AF37]/10">
                            <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Name</th>
                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Bonus</th>
                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Status</th>
                            <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                                <td class="py-4 px-6">
                                    <p class="text-white">{{ $referral->referred->first_name }} {{ $referral->referred->last_name }}</p>
                                </td>
                                <td class="text-right py-4 px-6">
                                    <span class="text-[#D4AF37] font-semibold">+{{ $referral->bonus_gold_grams }}g</span>
                                </td>
                                <td class="text-right py-4 px-6">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $referral->status === 'credited' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </td>
                                <td class="text-right py-4 px-6 text-[#666] text-sm">{{ $referral->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-10 text-[#666]">No referrals yet. Share your link to get started.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<footer class="border-t border-[#D4AF37]/10 py-6 mt-10">
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