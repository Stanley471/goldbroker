@extends('layouts.user')

@section('title', 'KYC Verification - GoldVault')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">KYC Verification</h1>
        @if(!$user->isKycVerified() && (!$latestSubmission || !$latestSubmission->isPending()))
            <a href="{{ route('kyc.create') }}" class="btn-primary text-sm">
                Submit KYC
            </a>
        @endif
    </div>
    <p class="text-[#A0A0A0] text-sm mt-1">Manage your identity verification</p>
</div>

{{-- KYC Status Card --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-8">
    <div class="p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full flex items-center justify-center
                @if($user->isKycVerified()) bg-green-500/20
                @elseif($user->isKycPending()) bg-yellow-500/20
                @elseif($user->isKycRejected()) bg-red-500/20
                @else bg-[#D4AF37]/20
                @endif">
                @if($user->isKycVerified())
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                @elseif($user->isKycPending())
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                    </svg>
                @elseif($user->isKycRejected())
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                        <path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><path d="M2 21h20"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h0.01"/><path d="M12 4h0.01"/><path d="M17 4h0.01"/>
                    </svg>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-semibold text-white mb-1">Verification Status</h3>
                <p class="text-[#A0A0A0]">
                    @if($user->isKycVerified())
                        <span class="text-green-500 font-medium">Verified</span> - Your identity has been verified.
                    @elseif($user->isKycPending())
                        <span class="text-yellow-500 font-medium">Pending Review</span> - Your documents are being reviewed.
                    @elseif($user->isKycRejected())
                        <span class="text-red-500 font-medium">Rejected</span> - Your submission was rejected.
                    @else
                        <span class="text-[#D4AF37] font-medium">Not Submitted</span> - Complete KYC to unlock all features.
                    @endif
                </p>
            </div>
        </div>

        @if($latestSubmission && $latestSubmission->isRejected())
            <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                <h4 class="text-red-400 font-medium mb-2">Rejection Reason</h4>
                <p class="text-[#A0A0A0] text-sm">{{ $latestSubmission->rejection_reason }}</p>
            </div>
        @endif

        @if(!$user->isKycVerified() && (!$latestSubmission || !$latestSubmission->isPending()))
            <div class="bg-[#D4AF37]/10 border border-[#D4AF37]/30 rounded-lg p-4">
                <h4 class="text-[#D4AF37] font-medium mb-2">Why complete KYC?</h4>
                <ul class="space-y-2 text-sm text-[#A0A0A0]">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 6 9 17l-5-5"/></svg>
                        Access higher transaction limits
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 6 9 17l-5-5"/></svg>
                        Enable withdrawals to bank accounts
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="M20 6 9 17l-5-5"/></svg>
                        Enhanced account security
                    </li>
                </ul>
            </div>
        @endif
    </div>
</div>

{{-- Submission History --}}
@if($latestSubmission)
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-[#D4AF37]/20">
            <h3 class="text-lg font-semibold text-white">Submission Details</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Submission Date</label>
                    <p class="text-white">{{ $latestSubmission->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm text-[#A0A0A0] mb-2">Status</label>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium
                        @if($latestSubmission->isApproved()) bg-green-500/20 text-green-400
                        @elseif($latestSubmission->isPending()) bg-yellow-500/20 text-yellow-400
                        @else bg-red-500/20 text-red-400
                        @endif">
                        @if($latestSubmission->isApproved())
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                            Approved
                        @elseif($latestSubmission->isPending())
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            Pending Review
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            Rejected
                        @endif
                    </span>
                </div>
            </div>

            @if($latestSubmission->reviewed_at)
                <div class="mt-6 pt-6 border-t border-[#D4AF37]/20">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-[#A0A0A0] mb-2">Reviewed Date</label>
                            <p class="text-white">{{ $latestSubmission->reviewed_at->format('F j, Y g:i A') }}</p>
                        </div>
                        @if($latestSubmission->reviewer)
                            <div>
                                <label class="block text-sm text-[#A0A0A0] mb-2">Reviewed By</label>
                                <p class="text-white">{{ $latestSubmission->reviewer->first_name }} {{ $latestSubmission->reviewer->last_name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Document Previews --}}
            <div class="mt-6 pt-6 border-t border-[#D4AF37]/20">
                <h4 class="text-white font-medium mb-4">Submitted Documents</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('kyc.show', $latestSubmission) }}" class="block group">
                        <div class="aspect-[3/2] bg-[#0A0A0A] rounded-lg overflow-hidden border border-[#D4AF37]/20 group-hover:border-[#D4AF37]/50 transition-colors">
                            <img src="{{ route('kyc.document', ['kyc' => $latestSubmission, 'type' => 'front']) }}" 
                                 alt="ID Front" 
                                 class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-[#A0A0A0] mt-2 text-center">ID Front</p>
                    </a>
                    <a href="{{ route('kyc.show', $latestSubmission) }}" class="block group">
                        <div class="aspect-[3/2] bg-[#0A0A0A] rounded-lg overflow-hidden border border-[#D4AF37]/20 group-hover:border-[#D4AF37]/50 transition-colors">
                            <img src="{{ route('kyc.document', ['kyc' => $latestSubmission, 'type' => 'back']) }}" 
                                 alt="ID Back" 
                                 class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm text-[#A0A0A0] mt-2 text-center">ID Back</p>
                    </a>
                    <a href="{{ route('kyc.show', $latestSubmission) }}" class="block group">
                        <div class="aspect-[3/2] bg-[#0A0A0A] rounded-lg overflow-hidden border border-[#D4AF37]/20 group-hover:border-[#D4AF37]/50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                                <path d="m22 8-6 4-6-4V6l6 4 6-4Z"/><path d="M2 8v8"/><path d="M4 12V8a4 4 0 0 1 4-4h12"/><path d="M6 12v8"/><path d="m10 12 6 4 6-4"/>
                            </svg>
                        </div>
                        <p class="text-sm text-[#A0A0A0] mt-2 text-center">Selfie Video</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
