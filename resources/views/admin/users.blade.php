@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Users</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Manage all registered users</p>
</div>

<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Name</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Email</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">USD Balance</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden lg:table-cell">Gold Balance</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">KYC</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-[#D4AF37]/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-xs font-semibold">{{ strtoupper(substr($user->first_name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="text-[#666] text-xs md:hidden">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0] hidden md:table-cell">{{ $user->email }}</td>
                        <td class="py-4 px-6 text-sm text-right text-white hidden sm:table-cell">${{ number_format($user->wallet->usd_balance ?? 0, 2) }}</td>
                        <td class="py-4 px-6 text-sm text-right text-[#D4AF37] hidden lg:table-cell">{{ number_format($user->wallet->gold_balance_grams ?? 0, 4) }}g</td>
                        <td class="py-4 px-6 hidden sm:table-cell">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $user->kyc_status === 'approved' ? 'bg-green-500/20 text-green-400' :
                                   ($user->kyc_status === 'rejected' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                                {{ ucfirst($user->kyc_status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center gap-1 text-sm text-[#D4AF37] hover:text-[#B8860B] transition-colors">
                                View
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-10 text-[#666]">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-[#D4AF37]/10">
        {{ $users->links() }}
    </div>
</div>

@endsection