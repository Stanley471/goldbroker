<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Referrals</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Referral Link --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-2">Your Referral Link</h3>
                <p class="text-gray-500 text-sm mb-2">Share this link and earn 0.1g of gold for every person who signs up and makes their first purchase.</p>
                <div class="flex gap-2">
                    <input type="text" readonly value="{{ url('/register?ref=' . auth()->user()->referral_code) }}" class="border p-2 rounded w-full bg-gray-50" />
                    <button onclick="navigator.clipboard.writeText('{{ url('/register?ref=' . auth()->user()->referral_code) }}')" class="bg-yellow-500 text-white px-4 py-2 rounded">Copy</button>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded shadow text-center">
                    <p class="text-gray-500 text-sm">Total Referrals</p>
                    <p class="text-3xl font-bold">{{ $totalReferrals }}</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <p class="text-gray-500 text-sm">Gold Earned</p>
                    <p class="text-3xl font-bold">{{ number_format($totalGoldEarned, 4) }}g</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <p class="text-gray-500 text-sm">Pending</p>
                    <p class="text-3xl font-bold">{{ $pendingReferrals }}</p>
                </div>
            </div>

            {{-- Referral List --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Referral History</h3>
                @forelse($referrals as $referral)
                    <div class="border-b py-2 flex justify-between">
                        <span>{{ $referral->referred->first_name }} {{ $referral->referred->last_name }}</span>
                        <span class="text-yellow-600">+{{ $referral->bonus_gold_grams }}g</span>
                        <span class="text-gray-500 text-sm">{{ $referral->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">No referrals yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>