<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

@include('partials.nav-user')

<main class="min-h-screen bg-[#0A0A0A] pt-10 pb-20" x-data="{ active: null }">
    <div class="section-container">
        <div class="section-inner">

            {{-- Header --}}
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Frequently Asked Questions</h1>
                <p class="text-[#A0A0A0] text-lg max-w-2xl mx-auto">Find answers to common questions about investing with GoldVault</p>
            </div>

            {{-- FAQ Categories --}}
            <div class="grid md:grid-cols-4 gap-4 mb-12">
                <a href="#general" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-4 text-center hover:border-[#D4AF37] transition-colors">
                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <span class="text-sm text-white">General</span>
                </a>
                <a href="#buying" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-4 text-center hover:border-[#D4AF37] transition-colors">
                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    </div>
                    <span class="text-sm text-white">Buying</span>
                </a>
                <a href="#storage" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-4 text-center hover:border-[#D4AF37] transition-colors">
                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                    </div>
                    <span class="text-sm text-white">Storage</span>
                </a>
                <a href="#selling" class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-4 text-center hover:border-[#D4AF37] transition-colors">
                    <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <span class="text-sm text-white">Selling</span>
                </a>
            </div>

            {{-- General Questions --}}
            <div id="general" class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                    <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    General Questions
                </h2>
                
                <div class="space-y-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'g1' }">
                        <button @click="active = active === 'g1' ? null : 'g1'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">What is GoldVault?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'g1' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'g1'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">GoldVault is a digital platform that allows you to buy, sell, and store physical gold and silver. We combine the security of physical precious metals with the convenience of modern technology. Your metals are stored in secure vaults around the world and fully allocated to you.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'g2' }">
                        <button @click="active = active === 'g2' ? null : 'g2'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Is GoldVault regulated?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'g2' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'g2'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Yes, GoldVault operates in compliance with all applicable financial regulations. We are registered with relevant authorities and maintain strict KYC (Know Your Customer) and AML (Anti-Money Laundering) procedures to ensure the security of our platform.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'g3' }">
                        <button @click="active = active === 'g3' ? null : 'g3'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Who can use GoldVault?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'g3' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'g3'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">GoldVault is available to individuals aged 18 and over in supported countries. You must complete our KYC verification process before you can buy or sell precious metals. Both personal and business accounts are supported.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buying Questions --}}
            <div id="buying" class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                    <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    </div>
                    Buying & Payments
                </h2>
                
                <div class="space-y-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'b1' }">
                        <button @click="active = active === 'b1' ? null : 'b1'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">How do I buy gold or silver?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'b1' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'b1'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Simply browse our products, add items to your cart, and proceed to checkout. You can pay using your wallet balance, cryptocurrency, or bank transfer. Once payment is confirmed, your metals are allocated to your account and stored in your chosen vault.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'b2' }">
                        <button @click="active = active === 'b2' ? null : 'b2'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">What payment methods do you accept?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'b2' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'b2'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">We accept several payment methods including: Wallet balance (USD), Cryptocurrency (Bitcoin, Ethereum, USDT, USDC), and Bank Transfer (Wire/ACH/SEPA). Credit card payments are temporarily unavailable.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'b3' }">
                        <button @click="active = active === 'b3' ? null : 'b3'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">How long does it take to process a purchase?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'b3' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'b3'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Wallet payments are instant. Cryptocurrency deposits are typically confirmed within 10-30 minutes depending on network congestion. Bank transfers usually take 1-3 business days to process.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'b4' }">
                        <button @click="active = active === 'b4' ? null : 'b4'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Are there any buying fees?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'b4' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'b4'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">We charge competitive premiums over spot price. Storage fees are 0.5% annually, calculated daily and billed monthly. There are no hidden fees - all costs are transparently displayed before you complete your purchase.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Storage Questions --}}
            <div id="storage" class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                    <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M18 21V10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v11"></path><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 1.132-1.803l7.95-3.974a2 2 0 0 1 1.837 0l7.948 3.974A2 2 0 0 1 22 8z"></path></svg>
                    </div>
                    Storage & Security
                </h2>
                
                <div class="space-y-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 's1' }">
                        <button @click="active = active === 's1' ? null : 's1'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Where is my gold stored?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 's1' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 's1'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Your precious metals are stored in professional vaults operated by internationally recognized security companies. We have vaults in multiple locations including New York, London, Zurich, Singapore, and Dubai. You can choose your preferred vault location during checkout.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 's2' }">
                        <button @click="active = active === 's2' ? null : 's2'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Is my gold insured?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 's2' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 's2'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Yes, all precious metals stored in our vaults are fully insured against theft, damage, and loss by Lloyd's of London. Your holdings are protected from the moment they enter the vault until they leave.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 's3' }">
                        <button @click="active = active === 's3' ? null : 's3'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Can I take physical delivery of my gold?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 's3' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 's3'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">Yes! You can request physical delivery of your metals at any time. Select "Ship" as your delivery method during purchase, or request withdrawal later from your vault. Delivery fees and insurance apply based on destination and value.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 's4' }">
                        <button @click="active = active === 's4' ? null : 's4'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">How are vault audits conducted?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 's4' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 's4'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">All vaults undergo regular third-party audits by independent accounting firms. These audits verify that the physical metals match our records. Audit certificates are available upon request for verified account holders.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Selling Questions --}}
            <div id="selling" class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3" style="font-family: 'Playfair Display';">
                    <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    Selling & Withdrawals
                </h2>
                
                <div class="space-y-4">
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'sell1' }">
                        <button @click="active = active === 'sell1' ? null : 'sell1'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">How do I sell my gold?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'sell1' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'sell1'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">You can sell your metals instantly through our platform. Simply go to your Vault, select the holdings you want to sell, and confirm the sale. Funds are credited to your wallet immediately at current market rates.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'sell2' }">
                        <button @click="active = active === 'sell2' ? null : 'sell2'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">How do I withdraw funds?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'sell2' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'sell2'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">You can withdraw funds from your wallet via bank transfer or cryptocurrency. Go to your Vault, click Withdraw, select your preferred method, and enter the amount. Withdrawals are typically processed within 1-2 business days.</p>
                        </div>
                    </div>

                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden" :class="{ 'border-[#D4AF37]': active === 'sell3' }">
                        <button @click="active = active === 'sell3' ? null : 'sell3'" class="w-full flex items-center justify-between p-6 text-left hover:bg-[#D4AF37]/5 transition-colors">
                            <span class="text-white font-medium">Are there fees for selling?</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] transition-transform" :class="{ 'rotate-180': active === 'sell3' }"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div x-show="active === 'sell3'" x-collapse class="px-6 pb-6">
                            <p class="text-[#A0A0A0]">We charge a 1% spread on buy/sell transactions. This is built into the price you see. There are no additional hidden fees. Withdrawal fees vary by method - bank transfers are $25 domestic/$50 international, crypto withdrawals have network fees only.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Still Need Help --}}
            <div class="text-center bg-gradient-to-r from-[#D4AF37]/20 to-[#B8860B]/20 rounded-2xl p-12 border border-[#D4AF37]/30">
                <h2 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Still Have Questions?</h2>
                <p class="text-[#A0A0A0] mb-8 max-w-xl mx-auto">Our support team is here to help you with any questions or concerns.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="btn-primary">Contact Support</a>
                    <a href="mailto:support@goldbrokers.io" class="btn-secondary">Email Us</a>
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
