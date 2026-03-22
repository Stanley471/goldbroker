@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Orders</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">All buy and sell orders on the platform</p>
</div>

<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Reference</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">User</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Type</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Grams</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Total USD</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Status</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden lg:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6 text-sm text-white font-mono">{{ $order->reference_number }}</td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0] hidden md:table-cell">{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs rounded-full {{ $order->order_type === 'buy' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-right text-[#A0A0A0] hidden sm:table-cell">{{ $order->gold_grams }}g</td>
                        <td class="py-4 px-6 text-sm text-right text-[#D4AF37] font-semibold">${{ number_format($order->total_usd, 2) }}</td>
                        <td class="py-4 px-6 text-right hidden sm:table-cell">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-500/20 text-green-400">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-right text-[#666] hidden lg:table-cell">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-10 text-[#666]">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-[#D4AF37]/10">
        {{ $orders->links() }}
    </div>
</div>

@endsection