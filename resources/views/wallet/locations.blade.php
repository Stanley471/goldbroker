<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Locations - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Back Button --}}
            <a href="{{ route('wallet.index') }}" class="inline-flex items-center gap-2 text-[#A0A0A0] hover:text-white transition-colors mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5-7 7 7 7"></path></svg>
                Back to Vault
            </a>

            {{-- Header --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Storage Locations</h1>
                <p class="text-[#A0A0A0]">View where your precious metals are stored around the world.</p>
            </div>

            {{-- Summary Stats --}}
            @php
                $totalVaultItems = 0;
                $totalVaultValue = 0;
                $totalPersonalItems = 0;
                $totalPersonalValue = 0;
                
                foreach ($holdingsByLocation['vault'] as $vaultData) {
                    $totalVaultItems += $vaultData['total_items'];
                    $totalVaultValue += $vaultData['total_value'];
                }
                
                if (isset($holdingsByLocation['personal']['personal'])) {
                    $totalPersonalItems = $holdingsByLocation['personal']['personal']['total_items'];
                    $totalPersonalValue = $holdingsByLocation['personal']['personal']['total_value'];
                }
            @endphp

            <div class="grid md:grid-cols-4 gap-6 mb-10">
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Vault Locations</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">{{ count($holdingsByLocation['vault']) }}</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Items in Vaults</p>
                    <p class="text-3xl font-bold text-white">{{ $totalVaultItems }}</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Personal Storage</p>
                    <p class="text-3xl font-bold text-white">{{ $totalPersonalItems }}</p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                    <p class="text-sm text-[#A0A0A0] mb-1">Total Value Stored</p>
                    <p class="text-3xl font-bold text-[#D4AF37]">${{ number_format($totalVaultValue + $totalPersonalValue, 2) }}</p>
                </div>
            </div>

            {{-- Vault Locations --}}
            @if(count($holdingsByLocation['vault']) > 0)
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                        <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                        </div>
                        Vault Storage
                    </h2>

                    <div class="space-y-6">
                        @foreach($holdingsByLocation['vault'] as $vaultId => $vaultData)
                            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                                {{-- Vault Header --}}
                                <div class="p-6 border-b border-[#D4AF37]/20 bg-[#D4AF37]/5">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-semibold text-white">{{ $vaultData['vault']->name }}</h3>
                                                <p class="text-[#A0A0A0] text-sm">{{ $vaultData['vault']->city }}, {{ $vaultData['vault']->country }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div class="text-right">
                                                <p class="text-xs text-[#A0A0A0]">Items Stored</p>
                                                <p class="text-lg font-semibold text-white">{{ $vaultData['total_items'] }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-[#A0A0A0]">Value</p>
                                                <p class="text-lg font-semibold text-[#D4AF37]">${{ number_format($vaultData['total_value'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 p-3 bg-[#0A0A0A] rounded-lg">
                                        <p class="text-xs text-[#A0A0A0]"><span class="text-[#D4AF37]">Address:</span> {{ $vaultData['vault']->address }}</p>
                                    </div>
                                </div>

                                {{-- Holdings at this Vault --}}
                                <div class="p-6">
                                    <h4 class="text-sm font-medium text-[#A0A0A0] mb-4">Stored Items</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($vaultData['holdings'] as $holding)
                                            <div class="bg-[#0A0A0A] border border-[#D4AF37]/10 rounded-lg p-4">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $holding->product->metal_type === 'gold' ? 'bg-yellow-500/20' : 'bg-gray-500/20' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $holding->product->metal_type === 'gold' ? 'text-yellow-500' : 'text-gray-400' }}">
                                                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-white font-medium text-sm">{{ $holding->product->name }}</p>
                                                        <p class="text-xs text-[#666]">{{ $holding->product->brand }}</p>
                                                    </div>
                                                </div>
                                                <div class="space-y-1">
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-[#A0A0A0]">Quantity</span>
                                                        <span class="text-white">{{ $holding->quantity }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-[#A0A0A0]">Weight</span>
                                                        <span class="text-white">{{ number_format($holding->product->weight_grams * $holding->quantity, 2) }}g</span>
                                                    </div>
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-[#A0A0A0]">Current Value</span>
                                                        <span class="text-[#D4AF37]">${{ number_format($holding->current_value, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Personal Storage --}}
            @if(isset($holdingsByLocation['personal']['personal']) && count($holdingsByLocation['personal']['personal']['holdings']) > 0)
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                        <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                        Personal Storage
                    </h2>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
                        {{-- Personal Storage Header --}}
                        <div class="p-6 border-b border-[#D4AF37]/20 bg-[#D4AF37]/5">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-white">Personal Storage</h3>
                                        <p class="text-[#A0A0A0] text-sm">Items shipped to your location</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <p class="text-xs text-[#A0A0A0]">Items</p>
                                        <p class="text-lg font-semibold text-white">{{ $holdingsByLocation['personal']['personal']['total_items'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-[#A0A0A0]">Value</p>
                                        <p class="text-lg font-semibold text-[#D4AF37]">${{ number_format($holdingsByLocation['personal']['personal']['total_value'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Holdings in Personal Storage --}}
                        <div class="p-6">
                            <h4 class="text-sm font-medium text-[#A0A0A0] mb-4">Stored Items</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($holdingsByLocation['personal']['personal']['holdings'] as $holding)
                                    <div class="bg-[#0A0A0A] border border-[#D4AF37]/10 rounded-lg p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $holding->product->metal_type === 'gold' ? 'bg-yellow-500/20' : 'bg-gray-500/20' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="{{ $holding->product->metal_type === 'gold' ? 'text-yellow-500' : 'text-gray-400' }}">
                                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium text-sm">{{ $holding->product->name }}</p>
                                                <p class="text-xs text-[#666]">{{ $holding->product->brand }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs">
                                                <span class="text-[#A0A0A0]">Quantity</span>
                                                <span class="text-white">{{ $holding->quantity }}</span>
                                            </div>
                                            <div class="flex justify-between text-xs">
                                                <span class="text-[#A0A0A0]">Weight</span>
                                                <span class="text-white">{{ number_format($holding->product->weight_grams * $holding->quantity, 2) }}g</span>
                                            </div>
                                            <div class="flex justify-between text-xs">
                                                <span class="text-[#A0A0A0]">Current Value</span>
                                                <span class="text-[#D4AF37]">${{ number_format($holding->current_value, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Empty State --}}
            @if(count($holdingsByLocation['vault']) === 0 && (!isset($holdingsByLocation['personal']['personal']) || count($holdingsByLocation['personal']['personal']['holdings']) === 0))
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-12 text-center">
                    <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                    </div>
                    <h3 class="text-white font-semibold mb-2">No Items in Storage</h3>
                    <p class="text-[#A0A0A0] text-sm mb-6">Purchase products to see them in your storage locations.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
                </div>
            @endif

            {{-- Available Vaults Info --}}
            <div class="mt-10">
                <h2 class="text-xl font-bold text-white mb-6" style="font-family: 'Playfair Display';">Our Vault Locations</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($vaults as $vault)
                        <div class="bg-[#141414] border border-[#D4AF37]/10 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-[#D4AF37]/10 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm">{{ $vault->city }}</p>
                                    <p class="text-xs text-[#A0A0A0]">{{ $vault->country }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-[#666]">{{ $vault->address }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-6">
    <div class="section-container">
        <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldBroker. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text#[666] hover:text-[#D4AF37] transition-colors">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
