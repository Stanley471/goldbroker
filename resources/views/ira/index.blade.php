<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRA Accounts - GoldBroker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-8">
    <div class="section-inner">

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">IRA Accounts</h1>
                <p class="text-[#A0A0A0] text-sm mt-1">Tax-advantaged retirement investment</p>
            </div>
            <a href="{{ route('ira.create') }}" class="btn-primary whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                Open IRA Account
            </a>
        </div>

        {{-- Info Banner --}}
        <div class="bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-2xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                </div>
                <div>
                    <p class="text-white font-medium mb-1">Important Notice</p>
                    <p class="text-[#A0A0A0] text-sm">IRA accounts are subject to IRS regulations. Please consult a financial advisor before opening an IRA account. Contribution limits and tax implications vary by account type.</p>
                </div>
            </div>
        </div>

        {{-- Account Types --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            @php
                $types = [
                    ['type' => 'Traditional', 'desc' => 'Pre-tax contributions, tax-deferred growth', 'icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'],
                    ['type' => 'Roth', 'desc' => 'After-tax contributions, tax-free growth', 'icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'],
                    ['type' => 'SEP', 'desc' => 'For self-employed, higher contribution limits', 'icon' => 'M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'],
                ];
            @endphp
            @foreach($types as $t)
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path></svg>
                </div>
                <h3 class="text-white font-semibold mb-1">{{ $t['type'] }} IRA</h3>
                <p class="text-[#A0A0A0] text-xs">{{ $t['desc'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Accounts List --}}
        @forelse($iraAccounts as $ira)
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 mb-4 hover:border-[#D4AF37]/40 transition-colors">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path></svg>
                            </div>
                            <h3 class="text-white font-semibold">{{ ucfirst($ira->account_type) }} IRA</h3>
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $ira->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ ucfirst($ira->status) }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-3">
                            <div>
                                <p class="text-xs text-[#A0A0A0]">Balance</p>
                                <p class="text-[#D4AF37] font-semibold">${{ number_format($ira->balance_usd, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-[#A0A0A0]">Tax Year</p>
                                <p class="text-white font-semibold">{{ $ira->tax_year }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-[#A0A0A0]">Opened</p>
                                <p class="text-white font-semibold">{{ $ira->opened_at->format('M d, Y') }}</p>
                            </div>
                            @if($ira->custodian_name)
                            <div>
                                <p class="text-xs text-[#A0A0A0]">Custodian</p>
                                <p class="text-white font-semibold">{{ $ira->custodian_name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('ira.show', $ira->id) }}" class="btn-secondary text-sm whitespace-nowrap">
                        Manage
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z"></path></svg>
                </div>
                <h3 class="text-white font-semibold mb-2">No IRA Accounts Yet</h3>
                <p class="text-[#A0A0A0] text-sm mb-6">Open your first IRA account to start saving for retirement.</p>
                <a href="{{ route('ira.create') }}" class="btn-primary">Open IRA Account</a>
            </div>
        @endforelse

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