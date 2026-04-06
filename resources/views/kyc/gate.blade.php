<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Verification - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        details > summary {
            list-style: none;
        }
        details > summary::-webkit-details-marker {
            display: none;
        }
        .verify-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #D4AF37;
            color: #D4AF37;
            background: transparent;
            border-radius: 9999px;
            padding: 14px 36px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        .verify-btn:hover {
            background: #D4AF37;
            color: #0A0A0A;
        }
        .verify-btn svg {
            width: 20px;
            height: 20px;
        }
        .dropdown-text {
            color: #A0A0A0;
            font-size: 14px;
            line-height: 2;
            text-align: center;
            padding-bottom: 24px;
        }
    </style>
</head>
<body class="bg-[#0A0A0A] text-white" style="font-family: 'Inter', sans-serif;">

<nav class="bg-[#0A0A0A]/95 backdrop-blur border-b border-[#D4AF37]/20">
    <div class="section-container">
        <div class="section-inner flex items-center justify-between h-20">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#D4AF37] to-[#B8860B] rounded-lg flex items-center justify-center p-2">
                    <img src="{{ Vite::asset('resources/assets/logo.svg') }}" alt="GoldVault" class="w-full h-full object-contain">
                </div>
                <span class="text-xl font-semibold text-white" style="font-family: 'Playfair Display';">Gold<span class="text-[#D4AF37]">Vault</span></span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-[#A0A0A0] hover:text-white transition-colors">Logout</button>
            </form>
        </div>
    </div>
</nav>

<main class="min-h-screen bg-[#0A0A0A] pt-8 pb-20">
    <div class="section-container">
        <div class="section-inner max-w-lg mx-auto">

            @php
                $status = $user->kyc_status ?? 'not_submitted';
                $latestSubmission = $user->latestKycSubmission;
            @endphp

            @if($status === 'verified')
                {{-- KYC Approved --}}
                <div class="bg-[#1a1a1a] rounded-2xl p-8 text-center mb-6">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M20 6 9 17l-5-5"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">KYC Verified!</h1>
                    <p class="text-[#A0A0A0] mb-6">Your identity has been verified successfully.</p>
                    <a href="{{ route('dashboard') }}" class="btn-primary w-full">Go to Dashboard</a>
                </div>

            @elseif($latestSubmission && $latestSubmission->status === 'pending')
                {{-- KYC Pending --}}
                <div class="bg-[#1a1a1a] rounded-2xl p-8 text-center mb-6">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Verification Pending</h1>
                    <p class="text-[#A0A0A0] mb-2">Your documents are under review.</p>
                    <p class="text-sm text-[#666]">Submitted: {{ $latestSubmission->created_at->format('M d, Y') }}</p>
                </div>

            @elseif($latestSubmission && $latestSubmission->status === 'rejected')
                {{-- KYC Rejected --}}
                <div class="bg-[#1a1a1a] rounded-2xl p-8 text-center mb-6">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2" style="font-family: 'Playfair Display';">Verification Rejected</h1>
                    @if($latestSubmission->admin_notes)
                        <p class="text-red-400 text-sm mb-4">{{ $latestSubmission->admin_notes }}</p>
                    @endif
                    <a href="{{ route('kyc.create') }}" class="btn-primary w-full">Resubmit Documents</a>
                </div>

            @else
                {{-- KYC Not Submitted - Main Design --}}
                
                {{-- Main Card --}}
                <div class="bg-[#1a1a1a] rounded-2xl p-8 text-center mb-6">
                    <p class="text-[#A0A0A0] mb-8" style="margin-bottom: 32px;">Start your profile verification process by clicking on the button below.</p>
                    
                    {{-- Verify Button - Custom Styled --}}
                    <a href="{{ route('kyc.create') }}" class="verify-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Verify</span>
                    </a>
                </div>

                {{-- Requirements Dropdowns --}}
                <div class="bg-[#1a1a1a] rounded-2xl overflow-hidden">
                    
                    {{-- Identity --}}
                    <details class="border-b border-[#333] group">
                        <summary class="w-full flex items-center justify-between p-5 text-left hover:bg-[#252525] transition-colors cursor-pointer list-none">
                            <div class="flex items-center gap-3">
                                <span class="text-white font-medium">Identity</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#4A9EFF]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#A0A0A0] transition-transform duration-300 group-open:rotate-180"><path d="m6 9 6 6 6-6"></path></svg>
                        </summary>
                        <div class="px-5 text-center">
                            <p class="dropdown-text">Verify your identity by uploading proof of identity (Government-issued ID: Passport, Driver's License, or National ID card).</p>
                        </div>
                    </details>

                    {{-- Address --}}
                    <details class="border-b border-[#333] group">
                        <summary class="w-full flex items-center justify-between p-5 text-left hover:bg-[#252525] transition-colors cursor-pointer list-none">
                            <div class="flex items-center gap-3">
                                <span class="text-white font-medium">Address</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#4A9EFF]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#A0A0A0] transition-transform duration-300 group-open:rotate-180"><path d="m6 9 6 6 6-6"></path></svg>
                        </summary>
                        <div class="px-5 text-center">
                            <p class="dropdown-text">Verify your address by uploading proof of address (Utility bill, Bank statement, or Government document not older than 3 months).</p>
                        </div>
                    </details>

                    {{-- Bank Account --}}
                    <details class="group">
                        <summary class="w-full flex items-center justify-between p-5 text-left hover:bg-[#252525] transition-colors cursor-pointer list-none">
                            <div class="flex items-center gap-3">
                                <span class="text-white font-medium">Bank account</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#4A9EFF]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#A0A0A0] transition-transform duration-300 group-open:rotate-180"><path d="m6 9 6 6 6-6"></path></svg>
                        </summary>
                        <div class="px-5 text-center">
                            <p class="dropdown-text">Verify your bank account by uploading bank statement or void check showing your account details for withdrawal purposes.</p>
                        </div>
                    </details>

                </div>

            @endif

        </div>
    </div>
</main>

{{-- Footer --}}
<footer class="bg-[#0A0A0A] border-t border-[#D4AF37]/20 py-6">
    <div class="section-container">
        <div class="section-inner flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-[#666]">© {{ date('Y') }} GoldVault. All rights reserved.</div>
            <div class="flex items-center gap-6">
                <a href="{{ route('contact') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Contact Support</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
