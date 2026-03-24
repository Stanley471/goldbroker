@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Crypto Wallets</h1>
            <p class="text-[#A0A0A0] mt-1">Manage cryptocurrency deposit addresses</p>
        </div>
        <a href="{{ route('admin.crypto-wallets.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
            Add Wallet
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-[#141414] border border-[#D4AF37]/20 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/20">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Currency</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Address</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Network</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Exchange Rate</th>
                    <th class="text-center py-4 px-6 text-[#A0A0A0] font-medium text-sm">Status</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wallets as $wallet)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#D4AF37]/20 rounded-lg flex items-center justify-center">
                                    <span class="text-[#D4AF37] text-lg font-bold">{{ $wallet->symbol ?: substr($wallet->code, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $wallet->name }}</p>
                                    <p class="text-xs text-[#666]">{{ $wallet->code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <code class="text-xs text-[#D4AF37] bg-[#0A0A0A] px-2 py-1 rounded">{{ substr($wallet->address, 0, 20) }}...</code>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-[#A0A0A0]">{{ $wallet->network ?: '-' }}</span>
                        </td>
                        <td class="text-right py-4 px-6">
                            <span class="text-white">${{ number_format($wallet->exchange_rate, 2) }}</span>
                        </td>
                        <td class="text-center py-4 px-6">
                            <form action="{{ route('admin.crypto-wallets.toggle', $wallet) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 text-xs rounded-full {{ $wallet->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $wallet->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-right py-4 px-6">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.crypto-wallets.edit', $wallet) }}" class="p-2 text-[#A0A0A0] hover:text-[#D4AF37] transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <form action="{{ route('admin.crypto-wallets.destroy', $wallet) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this wallet?');">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37]"><circle cx="12" cy="12" r="10"></circle><path d="M9.5 9.5c.5-1 1.5-1.5 2.5-1.5s2 .5 2.5 1.5"></path><path d="M9.5 14.5c.5 1 1.5 1.5 2.5 1.5s2-.5 2.5-1.5"></path><path d="M12 8v8"></path></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">No Crypto Wallets</h3>
                            <p class="text-[#A0A0A0] mb-4">Add cryptocurrency wallets for users to deposit funds.</p>
                            <a href="{{ route('admin.crypto-wallets.create') }}" class="btn-primary">Add First Wallet</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($wallets->count() > 0)
        <div class="mt-6 p-4 bg-[#141414] border border-[#D4AF37]/20 rounded-xl">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#D4AF37] mt-0.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
                <div>
                    <h4 class="text-white font-medium mb-1">Important Notes</h4>
                    <ul class="text-sm text-[#A0A0A0] space-y-1">
                        <li>• Only active wallets are shown to users on the deposit page</li>
                        <li>• Exchange rates are used to calculate crypto amounts from USD deposits</li>
                        <li>• Make sure to use the correct network for each wallet address</li>
                        <li>• Users must include the reference number when sending crypto</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
