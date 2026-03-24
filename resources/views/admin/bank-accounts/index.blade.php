@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Bank Accounts</h1>
            <p class="text-[#A0A0A0] mt-1">Manage bank accounts for wire transfers</p>
        </div>
        <a href="{{ route('admin.bank-accounts.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
            Add Bank Account
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Bank</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Account</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Account Number</th>
                    <th class="text-center py-4 px-6 text-[#A0A0A0] font-medium text-sm">Currency</th>
                    <th class="text-center py-4 px-6 text-[#A0A0A0] font-medium text-sm">Status</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $account)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $account->bank_name }}</p>
                                    <p class="text-xs text-[#666]">{{ $account->swift_code ?: 'No SWIFT' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-white text-sm">{{ $account->account_name }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <code class="text-xs text-[#D4AF37] bg-[#0A0A0A] px-2 py-1 rounded">{{ $account->masked_account_number }}</code>
                        </td>
                        <td class="text-center py-4 px-6">
                            <span class="px-2 py-1 bg-[#0A0A0A] rounded text-xs text-white">{{ $account->currency }}</span>
                        </td>
                        <td class="text-center py-4 px-6">
                            <form action="{{ route('admin.bank-accounts.toggle', $account) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 text-xs rounded-full {{ $account->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-right py-4 px-6">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="p-2 text-[#A0A0A0] hover:text-[#D4AF37] transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this bank account?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-[#A0A0A0] hover:text-red-400 transition-colors" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12">
                            <div class="w-16 h-16 bg-[#D4AF37]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">No Bank Accounts</h3>
                            <p class="text-[#A0A0A0] mb-4">Add bank accounts for users to make wire transfers.</p>
                            <a href="{{ route('admin.bank-accounts.create') }}" class="btn-primary">Add First Account</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($accounts->count() > 0)
        <div class="mt-6 p-4 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                <div>
                    <h4 class="text-white font-medium mb-1">Important Notes</h4>
                    <ul class="text-sm text-[#A0A0A0] space-y-1">
                        <li>• Only active bank accounts are shown to users on the deposit page</li>
                        <li>• Include routing number for domestic (ACH/Wire) transfers</li>
                        <li>• Include SWIFT/BIC for international wire transfers</li>
                        <li>• Include IBAN for SEPA transfers (Europe)</li>
                        <li>• Users must include the reference number when sending funds</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
