@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Orders</h1>

<div class="bg-white p-6 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="pb-2">Reference</th>
                <th class="pb-2">User</th>
                <th class="pb-2">Type</th>
                <th class="pb-2">Grams</th>
                <th class="pb-2">Total USD</th>
                <th class="pb-2">Status</th>
                <th class="pb-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-b">
                    <td class="py-2">{{ $order->reference_number }}</td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ ucfirst($order->order_type) }}</td>
                    <td>{{ $order->gold_grams }}</td>
                    <td>${{ number_format($order->total_usd, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-gray-500 py-4">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>

@endsection