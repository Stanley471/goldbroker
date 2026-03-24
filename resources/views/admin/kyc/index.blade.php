@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">KYC Management</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Review and manage user identity verification submissions</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['pending'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Pending</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['approved'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Approved</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['rejected'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Rejected</p>
            </div>
        </div>
    </div>
    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                <p class="text-sm text-[#A0A0A0]">Total</p>
            </div>
        </div>
    </div>
</div>

{{-- Pending Submissions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-8">
    <div class="p-6 border-b border-[#D4AF37]/20">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
            Pending Review
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Submitted</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingKycs as $kyc)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-full flex items-center justify-center">
                                    <span class="text-[#D4AF37] font-medium">{{ substr($kyc->user->first_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $kyc->user->first_name }} {{ $kyc->user->last_name }}</p>
                                    <p class="text-sm text-[#A0A0A0]">{{ $kyc->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white">{{ $kyc->created_at->diffForHumans() }}</p>
                            <p class="text-sm text-[#A0A0A0]">{{ $kyc->created_at->format('M j, Y g:i A') }}</p>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-[#D4AF37] text-[#0A0A0A] text-sm font-medium rounded-lg hover:bg-[#B8860B] transition-colors">
                                Review
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-8 px-6 text-center text-[#A0A0A0]">
                            No pending KYC submissions
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pendingKycs->hasPages())
        <div class="p-4 border-t border-[#D4AF37]/20">
            {{ $pendingKycs->links() }}
        </div>
    @endif
</div>

{{-- Approved Submissions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden mb-8">
    <div class="p-6 border-b border-[#D4AF37]/20">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            Approved
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Submitted</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reviewed By</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvedKycs as $kyc)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-green-500 font-medium">{{ substr($kyc->user->first_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $kyc->user->first_name }} {{ $kyc->user->last_name }}</p>
                                    <p class="text-sm text-[#A0A0A0]">{{ $kyc->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white">{{ $kyc->created_at->format('M j, Y') }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($kyc->reviewer)
                                <p class="text-white">{{ $kyc->reviewer->first_name }} {{ $kyc->reviewer->last_name }}</p>
                                <p class="text-sm text-[#A0A0A0]">{{ $kyc->reviewed_at->format('M j, Y') }}</p>
                            @else
                                <span class="text-[#A0A0A0]">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-[#A0A0A0]">
                            No approved KYC submissions
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($approvedKycs->hasPages())
        <div class="p-4 border-t border-[#D4AF37]/20">
            {{ $approvedKycs->links() }}
        </div>
    @endif
</div>

{{-- Rejected Submissions --}}
<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
    <div class="p-6 border-b border-[#D4AF37]/20">
        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
            Rejected
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Submitted</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reviewed By</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rejectedKycs as $kyc)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-red-500 font-medium">{{ substr($kyc->user->first_name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $kyc->user->first_name }} {{ $kyc->user->last_name }}</p>
                                    <p class="text-sm text-[#A0A0A0]">{{ $kyc->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white">{{ $kyc->created_at->format('M j, Y') }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($kyc->reviewer)
                                <p class="text-white">{{ $kyc->reviewer->first_name }} {{ $kyc->reviewer->last_name }}</p>
                                <p class="text-sm text-[#A0A0A0]">{{ $kyc->reviewed_at->format('M j, Y') }}</p>
                            @else
                                <span class="text-[#A0A0A0]">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.kyc.show', $kyc) }}" class="text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-[#A0A0A0]">
                            No rejected KYC submissions
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rejectedKycs->hasPages())
        <div class="p-4 border-t border-[#D4AF37]/20">
            {{ $rejectedKycs->links() }}
        </div>
    @endif
</div>
@endsection
