@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-semibold mb-6">User Detail</h1>

<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-lg font-semibold mb-4">Personal Info</h2>
    <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Referral Code:</strong> {{ $user->referral_code }}</p>
    <p><strong>KYC Status:</strong> {{ ucfirst($user->kyc_status) }}</p>
    <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
</div>

<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="text-lg font-semibold mb-4">Wallet</h2>
    <p><strong>USD Balance:</strong> ${{ number_format($user->wallet->usd_balance ?? 0, 2) }}</p>
    <p><strong>Gold Balance:</strong> {{ number_format($user->wallet->gold_balance_grams ?? 0, 6) }}g</p>
</div>

<div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Order History</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="pb-2">Reference</th>
                <th class="pb-2">Type</th>
                <th class="pb-2">Grams</th>
                <th class="pb-2">Total USD</th>
                <th class="pb-2">Status</th>
                <th class="pb-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user->orders as $order)
                <tr class="border-b">
                    <td class="py-2">{{ $order->reference_number }}</td>
                    <td>{{ ucfirst($order->order_type) }}</td>
                    <td>{{ $order->gold_grams }}</td>
                    <td>${{ number_format($order->total_usd, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-gray-500 py-4">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    <a href="{{ route('admin.users') }}" class="text-blue-500 hover:underline">← Back to Users</a>
</div>

@endsection