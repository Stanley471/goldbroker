<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Vault Locations - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20">
    <div class="section-container">
        <div class="section-inner">

            {{-- Header --}}
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Our Vault Locations</h1>
                <p class="text-[#A0A0A0] text-lg max-w-3xl mx-auto">Your precious metals are stored in world-class, professionally managed vaults across four continents. Each facility offers maximum security, full insurance, and easy accessibility.</p>
            </div>

            {{-- Stats Banner --}}
            <div class="bg-gradient-to-r from-[#D4AF37]/20 to-[#B8860B]/20 border border-[#D4AF37]/30 rounded-2xl p-8 mb-16">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <p class="text-4xl font-bold text-[#D4AF37] mb-2">{{ $vaults->count() }}</p>
                        <p class="text-sm text-[#A0A0A0]">Vault Locations</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-[#D4AF37] mb-2">4</p>
                        <p class="text-sm text-[#A0A0A0]">Continents</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-[#D4AF37] mb-2">24/7</p>
                        <p class="text-sm text-[#A0A0A0]">Security Monitoring</p>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-[#D4AF37] mb-2">100%</p>
                        <p class="text-sm text-[#A0A0A0]">Insured</p>
                    </div>
                </div>
            </div>

            {{-- Why Our Vaults --}}
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-8 text-center" style="font-family: 'Playfair Display';">Why Our Vaults?</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Maximum Security</h3>
                        <p class="text-[#A0A0A0] text-sm">Our vaults feature military-grade security systems, biometric access controls, armed guards, and 24/7 surveillance. Your assets are protected by the same standards used by central banks.</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 12 15 16 10"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Full Insurance</h3>
                        <p class="text-[#A0A0A0] text-sm">All precious metals stored in our vaults are fully insured by Lloyd's of London against theft, damage, and loss. Your holdings are protected from the moment they enter our facilities.</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Instant Liquidity</h3>
                        <p class="text-[#A0A0A0] text-sm">Sell your metals instantly through our platform. No need to arrange physical pickup or shipping. Funds are credited to your wallet immediately at current market rates.</p>
                    </div>
                </div>
            </div>

            {{-- Vault Locations --}}
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-8 text-center" style="font-family: 'Playfair Display';">Our Global Network</h2>
                
                {{-- Storage Partner --}}
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-8 mb-10">
                    <h3 class="text-xl font-semibold text-[#D4AF37] mb-4">Our Storage Partner</h3>
                    <p class="text-[#A0A0A0] leading-relaxed">
                        Storage is managed by our partner <strong class="text-white">Malca-Amit</strong>, a private operator independent from the international banking system. Founded in 1963, Malca-Amit is a trusted storage partner for financial institutions and high net-worth individuals around the world. Malca-Amit's highly-secured, strategically located storage facilities are recognized as market leaders. Their facilities include a division dedicated to a unique set of value-added services for those needing storage of bullion.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vaults as $vault)
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden hover:border-[#D4AF37]/50 transition-colors">
                        {{-- Flag Header --}}
                        <div class="h-32 bg-gradient-to-br from-[#1a1a1a] to-[#0A0A0A] flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10" style="background-image: url('https://flagcdn.com/w640/{{ strtolower($vault->country_code) }}.png'); background-size: cover; background-position: center;"></div>
                            <img src="https://flagcdn.com/w160/{{ strtolower($vault->country_code) }}.png" 
                                 alt="{{ $vault->country }} Flag" 
                                 class="w-24 h-auto rounded shadow-lg relative z-10 border-2 border-white/10">
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-bold text-white">{{ $vault->city }}</h3>
                                <span class="text-sm text-[#A0A0A0]">, {{ $vault->country }}</span>
                            </div>
                            
                            <p class="text-sm text-[#A0A0A0] mb-4">{{ $vault->address }}</p>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    <span class="text-[#A0A0A0]">Military-grade security</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 12 15 16 10"></polyline></svg>
                                    <span class="text-[#A0A0A0]">Fully insured by Lloyd's</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <span class="text-[#A0A0A0]">24/7 access available</span>
                                </div>
                            </div>
                            
                            @auth
                                <a href="{{ route('products.index') }}" class="btn-primary w-full text-center text-sm">Store Here</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-secondary w-full text-center text-sm">Create Account to Store</a>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- How It Works --}}
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 md:p-12 mb-16">
                <h2 class="text-3xl font-bold text-white mb-8 text-center" style="font-family: 'Playfair Display';">How Vault Storage Works</h2>
                
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-[#D4AF37]">1</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Buy Metals</h3>
                        <p class="text-sm text-[#A0A0A0]">Purchase gold or silver through our platform at competitive prices.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-[#D4AF37]">2</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Choose Vault</h3>
                        <p class="text-sm text-[#A0A0A0]">Select your preferred vault location from our global network.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-[#D4AF37]">3</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Allocated</h3>
                        <p class="text-sm text-[#A0A0A0]">Your specific bars or coins are allocated to your account.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-[#D4AF37]">4</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Manage Online</h3>
                        <p class="text-sm text-[#A0A0A0]">Track, sell, or request delivery anytime through your dashboard.</p>
                    </div>
                </div>
            </div>

            {{-- CTA Section --}}
            <div class="text-center bg-gradient-to-r from-[#D4AF37]/20 to-[#B8860B]/20 rounded-2xl p-12 border border-[#D4AF37]/30">
                <h2 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Start Storing Today</h2>
                <p class="text-[#A0A0A0] mb-8 max-w-xl mx-auto">Join thousands of investors who trust GoldVault with their precious metals. Choose from our global network of secure vaults.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
                        <a href="{{ route('wallet.locations') }}" class="btn-secondary">View Your Storage</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">Create Free Account</a>
                        <a href="{{ route('contact') }}" class="btn-secondary">Contact Sales</a>
                    @endauth
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
                <a href="{{ route('about') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">About</a>
                <a href="{{ route('contact') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Contact</a>
                <a href="{{ route('faq') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">FAQ</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
