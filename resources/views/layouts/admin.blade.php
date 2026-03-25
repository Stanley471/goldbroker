<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

<nav class="sticky top-0 z-40 bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20" x-data="{ open: false }">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-16">

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center p-1.5">
                    <img src="{{ Vite::asset('resources/assets/logo.svg') }}" alt="GoldVault" class="w-full h-full object-contain">
                </div>
                <span class="hidden sm:block text-base font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span> <span class="text-xs text-[#A0A0A0] font-normal">Admin</span></span>
            </a>

            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.users*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Users</a>
                <a href="{{ route('admin.kyc.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.kyc*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">KYC</a>
                <a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.transactions*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Transactions</a>
                <a href="{{ route('admin.orders') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.orders') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Orders</a>
                <a href="{{ route('admin.logs') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.logs') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Logs</a>
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.products*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Products</a>
                <a href="{{ route('admin.crypto-wallets.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.crypto-wallets*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Crypto Wallets</a>
                <a href="{{ route('admin.bank-accounts.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('admin.bank-accounts*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Bank Accounts</a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 text-sm text-[#A0A0A0]">
                    <div class="w-7 h-7 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <span>{{ auth()->user()->first_name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hidden sm:block text-xs text-[#A0A0A0] hover:text-red-400 transition-colors">Logout</button>
                </form>
                <button @click="open = !open" class="lg:hidden p-2 text-[#A0A0A0] hover:text-white">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="lg:hidden border-t border-[#D4AF37]/10 bg-[#0A0A0A]">
        <div class="section-container py-4">
            <div class="flex flex-col gap-1">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.dashboard') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.users*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Users</a>
                <a href="{{ route('admin.kyc.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.kyc*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">KYC</a>
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.transactions*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Transactions</a>
                <a href="{{ route('admin.orders') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.orders') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Orders</a>
                <a href="{{ route('admin.logs') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.logs') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Logs</a>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.products*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Products</a>
                <a href="{{ route('admin.crypto-wallets.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.crypto-wallets*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Crypto Wallets</a>
                <a href="{{ route('admin.bank-accounts.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('admin.bank-accounts*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Bank Accounts</a>
                <div class="border-t border-[#D4AF37]/10 mt-2 pt-2 flex items-center justify-between px-4">
                    <span class="text-sm text-[#A0A0A0]">{{ auth()->user()->first_name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-400">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<main class="section-container py-8">
    <div class="section-inner">
        @yield('content')
    </div>
</main>

<footer class="border-t border-[#D4AF37]/10 py-6 mt-10">
    <div class="section-container">
        <div class="section-inner flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldBroker Admin. All rights reserved.</div>
        </div>
    </div>
</footer>

</body>
</html>