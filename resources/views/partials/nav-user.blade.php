<div class="w-full bg-[#0A0A0A] border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-10">
            <div class="flex items-center gap-4 overflow-x-auto">
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full flex-shrink-0">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-500 font-medium">LIVE</span>
                </div>
                <span class="text-xs text-[#A0A0A0] uppercase tracking-wider flex-shrink-0">Gold</span>
                <span class="text-sm font-semibold text-[#D4AF37] flex-shrink-0">Live Market</span>
            </div>
            <a href="/contact" class="hidden sm:flex items-center gap-1.5 text-xs text-[#A0A0A0] hover:text-[#D4AF37] transition-colors flex-shrink-0">Contact us</a>
        </div>
    </div>
</div>

<nav class="sticky top-0 z-40 bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20" x-data="{ open: false }">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center">
                    <span class="text-[#0A0A0A] font-bold text-sm">G</span>
                </div>
                <span class="text-lg font-semibold text-white hidden sm:block" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>

            {{-- Desktop Links --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm {{ request()->routeIs('dashboard') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Dashboard</a>
                <a href="{{ route('wallet.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('wallet.*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Vault</a>
                <a href="{{ route('ira.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('ira.*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">IRA</a>
                <a href="{{ route('referrals.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('referrals.*') ? 'text-[#D4AF37]' : 'text-[#A0A0A0] hover:text-white' }} transition-colors">Referrals</a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                <div class="hidden sm:flex items-center gap-2 px-3 py-2 text-sm text-[#A0A0A0]">
                    <div class="w-7 h-7 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <span>{{ auth()->user()->first_name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hidden sm:block text-xs text-[#A0A0A0] hover:text-red-400 transition-colors px-2 py-1">Logout</button>
                </form>

                {{-- Mobile hamburger --}}
                <button @click="open = !open" class="lg:hidden p-2 text-[#A0A0A0] hover:text-white transition-colors">
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
                <a href="{{ route('dashboard') }}" class="px-4 py-3 text-sm {{ request()->routeIs('dashboard') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Dashboard</a>
                <a href="{{ route('wallet.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('wallet.*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Vault</a>
                <a href="{{ route('ira.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('ira.*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">IRA</a>
                <a href="{{ route('referrals.index') }}" class="px-4 py-3 text-sm {{ request()->routeIs('referrals.*') ? 'text-[#D4AF37] bg-[#D4AF37]/10' : 'text-[#A0A0A0]' }} rounded-lg">Referrals</a>
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