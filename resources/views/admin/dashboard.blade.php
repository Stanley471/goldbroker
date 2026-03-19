@extends('layouts.admin')

@section('content')

    <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-500 text-sm">Total Users</p>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-500 text-sm">Total Orders</p>
            <p class="text-3xl font-bold">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-500 text-sm">Gold Sold (grams)</p>
            <p class="text-3xl font-bold">{{ number_format($totalGoldSold, 4) }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow text-center">
            <p class="text-gray-500 text-sm">Pending KYC</p>
            <p class="text-3xl font-bold">{{ $pendingKyc }}</p>
        </div>

    </div>

    {{-- Recent Orders --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Recent Orders</h2>
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
                @forelse($recentOrders as $order)
                    <tr class="border-b py-2">
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
    </div>

@endsection
