<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 text-red-600">{{ session('error') }}</div>
            @endif

            {{-- Gold Price --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-2">Current Gold Price</h3>
                @if($goldPrice)
                    <p class="text-2xl">${{ number_format($goldPrice->price_per_gram_usd, 2) }} / gram</p>
                    <p class="text-sm text-gray-500">Last updated: {{ $goldPrice->fetched_at->diffForHumans() }}</p>
                @else
                    <p class="text-gray-500">Price not available</p>
                @endif
            </div>

            {{-- Wallet Balances --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-2">My Wallet</h3>
                <p>USD Balance: ${{ number_format($wallet->usd_balance, 2) }}</p>
                <p>Gold Balance: {{ number_format($wallet->gold_balance_grams, 6) }} grams</p>
            </div>

            {{-- Buy Gold --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Buy Gold</h3>
                <form method="POST" action="{{ route('orders.buy') }}">
                    @csrf
                    <input type="number" name="grams" step="0.01" placeholder="Grams to buy" class="border p-2 rounded w-full mb-4" min="0.1" />
                    @error('grams') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Buy Gold</button>
                </form>
            </div>

            {{-- Sell Gold --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Sell Gold</h3>
                <form method="POST" action="{{ route('orders.sell') }}">
                    @csrf
                    <input type="number" name="grams" step="0.01" placeholder="Grams to sell" class="border p-2 rounded w-full mb-4" min="0.1" />
                    @error('grams') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Sell Gold</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>