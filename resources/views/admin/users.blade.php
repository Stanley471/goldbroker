@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Users</h1>

<div class="bg-white p-6 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="pb-2">Name</th>
                <th class="pb-2">Email</th>
                <th class="pb-2">USD Balance</th>
                <th class="pb-2">Gold Balance</th>
                <th class="pb-2">KYC Status</th>
                <th class="pb-2">Joined</th>
                <th class="pb-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-b">
                    <td class="py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>${{ number_format($user->wallet->usd_balance ?? 0, 2) }}</td>
                    <td>{{ number_format($user->wallet->gold_balance_grams ?? 0, 4) }}g</td>
                    <td>{{ ucfirst($user->kyc_status) }}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td><a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:underline">View</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-gray-500 py-4">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

@endsection