<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - GoldBroker</title>
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
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">About GoldVault</h1>
                <p class="text-[#A0A0A0] text-lg max-w-2xl mx-auto">Your trusted partner in precious metals investment since 2020</p>
            </div>

            {{-- Mission Section --}}
            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-6" style="font-family: 'Playfair Display';">Our Mission</h2>
                    <p class="text-[#A0A0A0] mb-4 leading-relaxed">
                        At GoldVault, we believe that everyone deserves access to secure, physical precious metals investment. Our mission is to democratize gold and silver ownership by providing a modern, digital platform that makes investing in physical bullion as easy as buying stocks.
                    </p>
                    <p class="text-[#A0A0A0] leading-relaxed">
                        We combine cutting-edge technology with time-tested vaulting solutions to offer you the best of both worlds - the convenience of digital investing with the security of physical ownership.
                    </p>
                </div>
                <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-[#D4AF37] mb-2">$500M+</p>
                            <p class="text-sm text-[#A0A0A0]">Assets Under Management</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-bold text-[#D4AF37] mb-2">50K+</p>
                            <p class="text-sm text-[#A0A0A0]">Active Investors</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-bold text-[#D4AF37] mb-2">12</p>
                            <p class="text-sm text-[#A0A0A0]">Vault Locations</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-bold text-[#D4AF37] mb-2">99.9%</p>
                            <p class="text-sm text-[#A0A0A0]">Uptime</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Why Choose Us --}}
            <div class="mb-20">
                <h2 class="text-3xl font-bold text-white mb-10 text-center" style="font-family: 'Playfair Display';">Why Choose GoldVault</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Secure Vaulting</h3>
                        <p class="text-[#A0A0A0] text-sm">Your metals are stored in internationally recognized vaults with full insurance coverage and regular audits.</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" x2="9.01" y1="9" y2="9"></line><line x1="15" x2="15.01" y1="9" y2="9"></line></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Easy to Use</h3>
                        <p class="text-[#A0A0A0] text-sm">Buy, sell, and manage your precious metals portfolio with our intuitive platform available 24/7.</p>
                    </div>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
                        <div class="w-12 h-12 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Competitive Pricing</h3>
                        <p class="text-[#A0A0A0] text-sm">We offer some of the lowest premiums in the industry, ensuring you get the most metal for your money.</p>
                    </div>
                </div>
            </div>

            {{-- Our Story --}}
            <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl p-8 md:p-12 mb-20">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl font-bold text-white mb-6" style="font-family: 'Playfair Display';">Our Story</h2>
                    <p class="text-[#A0A0A0] mb-4 leading-relaxed">
                        GoldVault was founded in 2020 by a team of precious metals experts and fintech innovators who saw a gap in the market. While digital assets were becoming mainstream, physical gold and silver ownership remained complicated and inaccessible to average investors.
                    </p>
                    <p class="text-[#A0A0A0] mb-4 leading-relaxed">
                        We set out to change that by building a platform that combines the security of physical bullion with the convenience of modern technology. Today, we serve over 50,000 investors across 40 countries, managing more than $500 million in assets.
                    </p>
                    <p class="text-[#A0A0A0] leading-relaxed">
                        Our commitment to transparency, security, and customer service has made us one of the fastest-growing precious metals platforms in the world.
                    </p>
                </div>
            </div>

            {{-- Team --}}
            <div class="mb-20">
                <h2 class="text-3xl font-bold text-white mb-10 text-center" style="font-family: 'Playfair Display';">Leadership Team</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-[#D4AF37]/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Michael Chen</h3>
                        <p class="text-[#D4AF37] text-sm mb-2">CEO & Co-Founder</p>
                        <p class="text-[#A0A0A0] text-sm">Former Goldman Sachs precious metals trader with 15+ years experience.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-24 h-24 bg-[#D4AF37]/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Sarah Williams</h3>
                        <p class="text-[#D4AF37] text-sm mb-2">COO & Co-Founder</p>
                        <p class="text-[#A0A0A0] text-sm">Ex-McKinsey consultant specializing in fintech operations.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-24 h-24 bg-[#D4AF37]/20 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">David Park</h3>
                        <p class="text-[#D4AF37] text-sm mb-2">CTO</p>
                        <p class="text-[#A0A0A0] text-sm">Former tech lead at Coinbase, expert in secure financial systems.</p>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="text-center bg-gradient-to-r from-[#D4AF37]/20 to-[#B8860B]/20 rounded-2xl p-12 border border-[#D4AF37]/30">
                <h2 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Start Your Investment Journey</h2>
                <p class="text-[#A0A0A0] mb-8 max-w-xl mx-auto">Join thousands of investors who trust GoldVault with their precious metals portfolio.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="btn-primary">Create Account</a>
                    <a href="{{ route('products.index') }}" class="btn-secondary">Browse Products</a>
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
