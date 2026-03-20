<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        <h1 class="text-2xl font-semibold mb-6">{{ ucfirst($iraAccount->account_type) }} IRA</h1>

        <div class="bg-white p-6 rounded shadow mb-6">
            <p><span class="text-gray-500">Tax Year:</span> {{ $iraAccount->tax_year }}</p>
            <p><span class="text-gray-500">Gold Balance:</span> {{ number_format($iraAccount->gold_balance_grams, 6) }}g</p>
            <p><span class="text-gray-500">Status:</span> {{ ucfirst($iraAccount->status) }}</p>
            <p><span class="text-gray-500">Opened:</span> {{ $iraAccount->opened_at->format('M d, Y') }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Transfer Gold</h2>
            <form method="POST" action="{{ route('ira.transfer', $iraAccount->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Grams</label>
                    <input type="number" name="grams" step="0.01" min="0.01" class="border p-2 rounded w-full" />
                    @error('grams') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Direction</label>
                    <select name="direction" class="border p-2 rounded w-full">
                        <option value="to_ira">Wallet → IRA</option>
                        <option value="from_ira">IRA → Wallet</option>
                    </select>
                </div>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Transfer</button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>