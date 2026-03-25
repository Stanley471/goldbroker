<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>IRA Account - GoldBroker</title>
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
            <a href="{{ route('ira.index') }}" class="flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors text-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to IRA Accounts
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">{{ ucfirst($iraAccount->account_type) }} IRA</h1>
                    <p class="text-[#A0A0A0] text-sm mt-1">Tax Year {{ $iraAccount->tax_year }} · Opened {{ $iraAccount->opened_at->format('M d, Y') }}</p>
                </div>
                <span class="px-3 py-1 text-sm rounded-full w-fit {{ $iraAccount->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                    {{ ucfirst($iraAccount->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Stats + Transfer --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Stats --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-3">Account Balance</p>
                        <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($iraAccount->balance_usd, 2) }}</p>
                        <p class="text-xs text-[#A0A0A0] mt-1">Cash balance in USD</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider mb-3">Account Type</p>
                        <p class="text-3xl font-bold text-white">{{ ucfirst($iraAccount->account_type) }}</p>
                        <p class="text-xs text-[#A0A0A0] mt-1">IRA classification</p>
                    </div>
                </div>

                {{-- Transfer Form --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 md:p-8" x-data="{ direction: 'to_ira' }">
                    <h2 class="text-lg font-semibold text-white mb-6" style="font-family: 'Playfair Display';">Transfer Funds</h2>

                    <form method="POST" action="{{ route('ira.transfer', $iraAccount->id) }}" class="space-y-6">
                        @csrf

                        {{-- Direction Toggle --}}
                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-3">Transfer Direction</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="direction" value="to_ira" class="sr-only peer" checked x-model="direction">
                                    <div class="w-full p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl text-center peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-2 text-[#D4AF37]"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                        <p class="text-sm font-medium text-white">Wallet → IRA</p>
                                        <p class="text-xs text-[#A0A0A0] mt-1">Deposit funds into IRA</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="direction" value="from_ira" class="sr-only peer" x-model="direction">
                                    <div class="w-full p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl text-center peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-2 text-[#D4AF37]"><path d="M19 12H5"></path><path d="m12 5-7 7 7 7"></path></svg>
                                        <p class="text-sm font-medium text-white">IRA → Wallet</p>
                                        <p class="text-xs text-[#A0A0A0] mt-1">Withdraw funds from IRA</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Amount (USD)</label>
                            <input type="number" name="amount" step="0.01" min="1" placeholder="Enter amount to transfer"
                                class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                            @error('amount') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary justify-center py-3">
                            Transfer Funds
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </button>
                    </form>
                </div>

            </div>

            {{-- Right: Account Details --}}
            <div class="space-y-4">
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6">
                    <h3 class="text-white font-semibold mb-4">Account Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Account Type</span>
                            <span class="text-xs text-white">{{ ucfirst($iraAccount->account_type) }} IRA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Tax Year</span>
                            <span class="text-xs text-white">{{ $iraAccount->tax_year }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Status</span>
                            <span class="text-xs text-white">{{ ucfirst($iraAccount->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Opened</span>
                            <span class="text-xs text-white">{{ $iraAccount->opened_at->format('M d, Y') }}</span>
                        </div>
                        @if($iraAccount->custodian_name)
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Custodian</span>
                            <span class="text-xs text-white">{{ $iraAccount->custodian_name }}</span>
                        </div>
                        @endif
                        @if($iraAccount->account_number)
                        <div class="flex justify-between">
                            <span class="text-xs text-[#A0A0A0]">Account #</span>
                            <span class="text-xs text-white">{{ $iraAccount->account_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                        <p class="text-[#A0A0A0] text-xs leading-relaxed">Early withdrawals from IRAs may be subject to taxes and penalties. Consult a financial advisor before transferring funds.</p>
                    </div>
                </div>
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