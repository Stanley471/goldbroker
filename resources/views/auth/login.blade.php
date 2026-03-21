<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - GoldVault</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

{{-- Top Bar --}}
<div class="w-full bg-[#0A0A0A] border-b border-[#D4AF37]/10">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-10">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5 px-2 py-0.5 bg-green-500/20 rounded-full">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-500 font-medium">LIVE</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="text-xs text-[#A0A0A0] uppercase tracking-wider">Gold</span>
                    <span class="text-sm font-semibold text-[#D4AF37]">Live Market</span>
                </div>
            </div>
            <a href="/contact" class="hidden sm:flex items-center gap-1.5 text-xs text-[#A0A0A0] hover:text-[#D4AF37] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg>
                Contact us
            </a>
        </div>
    </div>
</div>

{{-- Nav --}}
<nav class="bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center">
                    <span class="text-[#0A0A0A] font-bold text-xl">G</span>
                </div>
                <span class="text-xl font-semibold text-white hidden sm:block" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-[#A0A0A0]">Don't have an account?</span>
                <a href="{{ route('register') }}" class="btn-primary text-sm py-2">Create Account</a>
            </div>
        </div>
    </div>
</nav>

{{-- Login Form --}}
<main class="min-h-screen bg-[#0A0A0A] pt-20 pb-20">
    <div class="section-container">
        <div class="section-inner">
            <div class="max-w-md mx-auto">

                {{-- Header --}}
                <div class="text-center mb-10">
                    <a href="/" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center">
                            <span class="text-[#0A0A0A] font-bold text-2xl">G</span>
                        </div>
                        <span class="text-2xl font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
                    </a>
                    <h1 class="text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Welcome Back</h1>
                    <p class="text-[#A0A0A0]">Sign in to access your vault and portfolio</p>
                </div>

                {{-- Session Error --}}
                @if ($errors->any())
                    <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Email Address</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#666]"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                class="w-full bg-[#141414] border border-[#D4AF37]/20 rounded-xl pl-12 pr-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors"
                                required />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-2">Password</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#666]"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input type="password" name="password" placeholder="Enter your password"
                                class="w-full bg-[#141414] border border-[#D4AF37]/20 rounded-xl pl-12 pr-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none transition-colors"
                                required />
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#D4AF37]/30 bg-[#141414] text-[#D4AF37] focus:ring-[#D4AF37]">
                            <span class="text-sm text-[#A0A0A0]">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">Forgot password?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full btn-primary justify-center py-3">
                        Sign In
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </button>
                </form>

                {{-- Security Badge --}}
                <div class="mt-8 p-4 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                        <span class="text-sm text-white font-medium">Secure Connection</span>
                    </div>
                    <p class="text-sm text-[#A0A0A0]">Your connection is encrypted with 256-bit SSL security.</p>
                </div>

                <p class="text-center mt-8 text-[#A0A0A0]">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-[#D4AF37] hover:text-[#B8860B] transition-colors font-medium">Create one</a>
                </p>

            </div>
        </div>
    </div>
</main>

</body>
</html>