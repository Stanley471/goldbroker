<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Wallet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            {{-- Balances --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Balances</h3>
                <p>USD Balance: ${{ number_format($wallet->usd_balance, 2) }}</p>
                <p>Gold Balance: {{ number_format($wallet->gold_balance_grams, 6) }} grams</p>
            </div>

            {{-- Deposit Form --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Simulate Deposit</h3>
                <form method="POST" action="{{ route('wallet.deposit') }}">
                    @csrf
                    <input type="number" name="amount" placeholder="Amount in USD" class="border p-2 rounded w-full mb-4" min="1" />
                    @error('amount') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Deposit</button>
                </form>
            </div>

            {{-- Transaction History --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Transaction History</h3>
                @forelse($transactions as $transaction)
                    <div class="border-b py-2">
                        <span>{{ $transaction->type }}</span>
                        <span class="float-right">{{ $transaction->currency }} {{ $transaction->amount }}</span>
                        <p class="text-sm text-gray-500">{{ $transaction->description }} · {{ $transaction->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No transactions yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
    