<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>Open IRA Account - GoldBroker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="section-container py-8">
    <div class="section-inner">

        <div class="mb-8">
            <a href="{{ route('ira.index') }}" class="flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors text-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to IRA Accounts
            </a>
            <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Open IRA Account</h1>
            <p class="text-[#A0A0A0] text-sm mt-1">Set up a tax-advantaged gold retirement account</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-6 md:p-8">

                    <div class="mb-6 p-4 bg-[#D4AF37]/5 border border-[#D4AF37]/20 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                            <p class="text-[#A0A0A0] text-sm">Please consult a financial advisor before opening an IRA account. Tax implications vary by account type and individual circumstances.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('ira.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Account Type</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach(['traditional' => 'Traditional IRA', 'roth' => 'Roth IRA', 'sep' => 'SEP IRA'] as $value => $label)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="account_type" value="{{ $value }}" class="sr-only peer" {{ old('account_type') === $value ? 'checked' : ($value === 'traditional' ? 'checked' : '') }}>
                                    <div class="w-full p-4 bg-[#0A0A0A] border border-[#D4AF37]/20 rounded-xl text-center peer-checked:border-[#D4AF37] peer-checked:bg-[#D4AF37]/10 transition-all">
                                        <p class="text-sm font-medium text-white">{{ $label }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('account_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Tax Year</label>
                            <input type="number" name="tax_year" value="{{ old('tax_year', date('Y')) }}"
                                class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                            @error('tax_year') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Custodian Name <span class="text-[#666]">(optional)</span></label>
                            <input type="text" name="custodian_name" value="{{ old('custodian_name') }}" placeholder="e.g. Fidelity, Schwab, Vanguard"
                                class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                        </div>

                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Account Number <span class="text-[#666]">(optional)</span></label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="Your existing IRA account number"
                                class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors" />
                        </div>

                        <button type="submit" class="w-full btn-primary justify-center py-3">
                            Open IRA Account
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-4">
                @foreach([
                    ['title' => 'Traditional IRA', 'desc' => 'Contributions may be tax-deductible. Pay taxes when you withdraw in retirement.'],
                    ['title' => 'Roth IRA', 'desc' => 'Contributions are after-tax. Qualified withdrawals in retirement are tax-free.'],
                    ['title' => 'SEP IRA', 'desc' => 'Designed for self-employed individuals. Higher contribution limits than traditional or Roth.'],
                ] as $info)
                <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-2xl p-5">
                    <h3 class="text-white font-semibold mb-2 text-sm">{{ $info['title'] }}</h3>
                    <p class="text-[#A0A0A0] text-xs leading-relaxed">{{ $info['desc'] }}</p>
                </div>
                @endforeach
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