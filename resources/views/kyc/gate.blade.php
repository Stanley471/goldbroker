<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Verification Required - GoldBroker</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

<main class="min-h-screen bg-[#0A0A0A] pt-20 pb-20">
    <div class="section-container">
        <div class="section-inner">
            <div class="max-w-2xl mx-auto text-center">
                
                @php
                    $status = $user->kyc_status ?? 'not_submitted';
                    $latestSubmission = $user->latestKycSubmission;
                @endphp

                @if($status === 'verified')
                    {{-- KYC Approved --}}
                    <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M20 6 9 17l-5-5"></path></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">KYC Verified!</h1>
                    <p class="text-[#A0A0A0] mb-8">Your identity has been verified. You now have full access to your account.</p>
                    <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>

                @elseif($latestSubmission && $latestSubmission->status === 'pending')
                    {{-- KYC Pending --}}
                    <div class="w-20 h-20 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Verification Pending</h1>
                    <p class="text-[#A0A0A0] mb-4">Your KYC documents have been submitted and are under review.</p>
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-8">
                        <p class="text-sm text-[#A0A0A0] mb-2">Submission ID: <span class="text-white">#{{ $latestSubmission->id }}</span></p>
                        <p class="text-sm text-[#A0A0A0] mb-2">Submitted: <span class="text-white">{{ $latestSubmission->created_at->format('M d, Y H:i') }}</span></p>
                        <p class="text-sm text-[#A0A0A0]">Status: <span class="text-yellow-500">Pending Review</span></p>
                    </div>
                    <p class="text-sm text-[#666] mb-8">We will notify you via email once your verification is complete. This usually takes 24-48 hours.</p>
                    <a href="{{ route('kyc.index') }}" class="btn-secondary">View Submission</a>

                @elseif($latestSubmission && $latestSubmission->status === 'rejected')
                    {{-- KYC Rejected --}}
                    <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Verification Rejected</h1>
                    <p class="text-[#A0A0A0] mb-6">Your KYC verification could not be approved.</p>
                    
                    @if($latestSubmission->admin_notes)
                    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 mb-8 text-left">
                        <p class="text-sm text-red-400 font-semibold mb-2">Reason:</p>
                        <p class="text-[#A0A0A0]">{{ $latestSubmission->admin_notes }}</p>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('kyc.create') }}" class="btn-primary">Resubmit Documents</a>
                        <a href="{{ route('contact') }}" class="btn-secondary">Contact Support</a>
                    </div>

                @else
                    {{-- KYC Not Submitted --}}
                    <div class="w-20 h-20 bg-[#D4AF37]/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-4" style="font-family: 'Playfair Display';">Identity Verification Required</h1>
                    <p class="text-[#A0A0A0] mb-6">Before you can access your account and start investing, we need to verify your identity. This is a one-time process required by regulations.</p>
                    
                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6 mb-8 text-left">
                        <h3 class="text-white font-semibold mb-4">What you'll need:</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                Government-issued ID (front & back)
                            </li>
                            <li class="flex items-center gap-3 text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                                Selfie video for liveness check
                            </li>
                            <li class="flex items-center gap-3 text-[#A0A0A0]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                Takes about 5 minutes
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('kyc.create') }}" class="btn-primary">Start Verification</a>
                @endif

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
                <a href="{{ route('contact') }}" class="text-sm text-[#666] hover:text-[#D4AF37] transition-colors">Contact Support</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
