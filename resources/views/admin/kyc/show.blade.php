@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.kyc.index') }}" class="text-[#A0A0A0] hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white" style="font-family: 'Playfair Display';">Review KYC Submission</h1>
                <p class="text-[#A0A0A0] text-sm mt-1">Review and verify user identity documents</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-sm font-medium
                @if($kyc->isPending()) bg-yellow-500/20 text-yellow-400
                @elseif($kyc->isApproved()) bg-green-500/20 text-green-400
                @else bg-red-500/20 text-red-400
                @endif">
                {{ ucfirst($kyc->status) }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Left Column: User Info --}}
    <div class="lg:col-span-1">
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">User Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                        <span class="text-2xl text-[#D4AF37] font-medium">{{ substr($kyc->user->first_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-white font-medium text-lg">{{ $kyc->user->first_name }} {{ $kyc->user->last_name }}</p>
                        <p class="text-sm text-[#A0A0A0]">{{ $kyc->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-1">User ID</label>
                        <p class="text-white font-mono text-sm">#{{ $kyc->user->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-1">Registered</label>
                        <p class="text-white">{{ $kyc->user->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm text-[#A0A0A0] mb-1">KYC Status</label>
                        <p class="text-white">{{ ucfirst($kyc->user->kyc_status ?? 'not_submitted') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submission Info --}}
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">Submission Details</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
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
                    @if($kyc->isRejected())
                        <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                            <label class="block text-sm text-red-400 mb-1">Rejection Reason</label>
                            <p class="text-white text-sm">{{ $kyc->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Documents --}}
    <div class="lg:col-span-2">
        <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-[#D4AF37]/20">
                <h3 class="text-lg font-semibold text-white">Submitted Documents</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- ID Front --}}
                    <div>
                        <label class="block text-sm font-medium text-white mb-3">ID Front</label>
                        <div class="relative group">
                            <img src="{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'front']) }}" 
                                 alt="ID Front"
                                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                 onclick="openModal('{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'front']) }}')">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                                <span class="text-white text-sm">Click to enlarge</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'front']) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-1 mt-2 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                            Open in new tab
                        </a>
                    </div>

                    {{-- ID Back --}}
                    <div>
                        <label class="block text-sm font-medium text-white mb-3">ID Back</label>
                        <div class="relative group">
                            <img src="{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'back']) }}" 
                                 alt="ID Back"
                                 class="w-full rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                 onclick="openModal('{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'back']) }}')">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                                <span class="text-white text-sm">Click to enlarge</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'back']) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-1 mt-2 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                            Open in new tab
                        </a>
                    </div>
                </div>

                {{-- Selfie Video --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white mb-3">Selfie Video</label>
                    <video src="{{ route('admin.kyc.document', ['kyc' => $kyc, 'type' => 'video']) }}" 
                           controls 
                           class="w-full max-h-96 rounded-lg bg-[#0A0A0A]">
                        Your browser does not support the video tag.
                    </video>
                </div>

                {{-- Action Buttons --}}
                @if($kyc->isPending())
                    <div class="border-t border-[#D4AF37]/20 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Approve Form --}}
                            <form action="{{ route('admin.kyc.approve', $kyc) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to approve this KYC submission?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    Approve KYC
                                </button>
                            </form>

                            {{-- Reject Form --}}
                            <div x-data="{ showRejectForm: false }">
                                <button type="button" 
                                        @click="showRejectForm = true"
                                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                    Reject KYC
                                </button>

                                {{-- Rejection Modal --}}
                                <div x-show="showRejectForm" 
                                     x-cloak
                                     class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl max-w-md w-full p-6"
                                         @click.away="showRejectForm = false"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100">
                                        <h3 class="text-xl font-semibold text-white mb-4">Reject KYC Submission</h3>
                                        <form action="{{ route('admin.kyc.reject', $kyc) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="mb-4">
                                                <label class="block text-sm text-[#A0A0A0] mb-2">Rejection Reason</label>
                                                <textarea name="rejection_reason" 
                                                          rows="4"
                                                          class="w-full bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-lg px-4 py-3 text-white placeholder-[#666] focus:border-[#D4AF37] focus:outline-none resize-none"
                                                          placeholder="Please provide a detailed reason for rejection..."
                                                          required></textarea>
                                                @error('rejection_reason')
                                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="flex items-center justify-end gap-3">
                                                <button type="button" 
                                                        @click="showRejectForm = false"
                                                        class="px-4 py-2 text-[#A0A0A0] hover:text-white transition-colors">
                                                    Cancel
                                                </button>
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                                    Confirm Rejection
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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
