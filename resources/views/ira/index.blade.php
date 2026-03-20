<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">My IRA Accounts</h1>
            <a href="{{ route('ira.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Open IRA Account</a>
        </div>

        @forelse($iraAccounts as $ira)
            <div class="bg-white p-6 rounded shadow mb-4">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">{{ ucfirst($ira->account_type) }} IRA</p>
                        <p class="text-gray-500 text-sm">Tax Year: {{ $ira->tax_year }}</p>
                        <p class="text-gray-500 text-sm">Gold Balance: {{ number_format($ira->gold_balance_grams, 6) }}g</p>
                        <p class="text-gray-500 text-sm">Status: {{ ucfirst($ira->status) }}</p>
                    </div>
                    <a href="{{ route('ira.show', $ira->id) }}" class="text-blue-500 hover:underline">Manage</a>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded shadow">
                <p class="text-gray-500">No IRA accounts yet. <a href="{{ route('ira.create') }}" class="text-blue-500">Open one now</a></p>
            </div>
        @endforelse

    </div>
</div>
</x-app-layout>