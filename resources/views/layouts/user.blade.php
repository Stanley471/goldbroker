<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoldVault')</title>
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
        @if(session('info'))
            <div class="mb-6 px-4 py-3 bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-xl text-[#D4AF37] text-sm">{{ session('info') }}</div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="border-t border-[#D4AF37]/10 py-6 mt-10">
    <div class="section-container">
        <div class="section-inner flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldVault. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                <a href="#" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
