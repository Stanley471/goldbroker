@extends('layouts.user')

@section('title', 'KYC Details - GoldBroker')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">KYC Submission Details</h1>
        <a href="{{ route('kyc.index') }}" class="text-[#A0A0A0] hover:text-white transition-colors">
            ← Back to KYC
        </a>
    </div>
</div>

{{-- Status Banner --}}
<div class="mb-8 p-4 rounded-xl border
    @if($kyc->isApproved()) bg-green-500/10 border-green-500/30
    @elseif($kyc->isPending()) bg-yellow-500/10 border-yellow-500/30
    @else bg-red-500/10 border-red-500/30
    @endif">
    <div class="flex items-center gap-3">
        @if($kyc->isApproved())
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
            <div>
                <p class="text-green-400 font-medium">Approved</p>
                <p class="text-sm text-[#A0A0A0]">Your KYC has been verified on {{ $kyc->reviewed_at->format('F j, Y') }}</p>
            </div>
        @elseif($kyc->isPending())
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
            <div>
                <p class="text-yellow-400 font-medium">Pending Review</p>
                <p class="text-sm text-[#A0A0A0]">Your submission is being reviewed by our team</p>
            </div>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
            <div>
                <p class="text-red-400 font-medium">Rejected</p>
                <p class="text-sm text-[#A0A0A0]">Your submission was rejected on {{ $kyc->reviewed_at->format('F j, Y') }}</p>
            </div>
        @endif
    </div>
</div>

@if($kyc->isRejected())
    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 mb-8">
        <h3 class="text-red-400 font-medium mb-2">Rejection Reason</h3>
        <p class="text-[#A0A0A0]">{{ $kyc->rejection_reason }}</p>
    </div>
@endif

{{-- Documents Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- ID Front --}}
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <div class="p-4 border-b border-[#D4AF37]/20">
            <h3 class="text-white font-medium">ID Front</h3>
        </div>
        <div class="p-4">
            <img src="{{ route('kyc.document', ['kyc' => $kyc, 'type' => 'front']) }}" 
                 alt="ID Front" 
                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                 onclick="openModal('{{ route('kyc.document', ['kyc' => $kyc, 'type' => 'front']) }}')">
        </div>
    </div>

    {{-- ID Back --}}
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <div class="p-4 border-b border-[#D4AF37]/20">
            <h3 class="text-white font-medium">ID Back</h3>
        </div>
        <div class="p-4">
            <img src="{{ route('kyc.document', ['kyc' => $kyc, 'type' => 'back']) }}" 
                 alt="ID Back" 
                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                 onclick="openModal('{{ route('kyc.document', ['kyc' => $kyc, 'type' => 'back']) }}')">
        </div>
    </div>

    {{-- Selfie Video --}}
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden md:col-span-2">
        <div class="p-4 border-b border-[#D4AF37]/20">
            <h3 class="text-white font-medium">Selfie Video</h3>
        </div>
        <div class="p-4">
            <video src="{{ route('kyc.document', ['kyc' => $kyc, 'type' => 'video']) }}" 
                   controls 
                   class="w-full max-h-96 rounded-lg">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

{{-- Submission Info --}}
<div class="mt-8 bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
    <h3 class="text-white font-medium mb-4">Submission Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm text-[#A0A0A0] mb-1">Submitted On</label>
            <p class="text-white">{{ $kyc->created_at->format('F j, Y g:i A') }}</p>
        </div>
        @if($kyc->reviewed_at)
            <div>
                <label class="block text-sm text-[#A0A0A0] mb-1">Reviewed On</label>
                <p class="text-white">{{ $kyc->reviewed_at->format('F j, Y g:i A') }}</p>
            </div>
        @endif
        @if($kyc->reviewer)
            <div>
                <label class="block text-sm text-[#A0A0A0] mb-1">Reviewed By</label>
                <p class="text-white">{{ $kyc->reviewer->first_name }} {{ $kyc->reviewer->last_name }}</p>
            </div>
        @endif
    </div>
</div>

{{-- Image Modal --}}
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-sm" onclick="closeModal()">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <img id="modalImage" src="" alt="Full size" class="max-w-full max-h-full rounded-lg">
        <button onclick="closeModal()" class="absolute top-4 right-4 w-10 h-10 bg-[#141414] text-white rounded-full flex items-center justify-center hover:bg-[#1a1a1a] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
@endsection
