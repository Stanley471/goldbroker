<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h1 class="text-2xl font-semibold mb-6">Open IRA Account</h1>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500 text-sm mb-4">Please consult a financial advisor before opening an IRA account.</p>

            <form method="POST" action="{{ route('ira.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Account Type</label>
                    <select name="account_type" class="border p-2 rounded w-full">
                        <option value="traditional">Traditional IRA</option>
                        <option value="roth">Roth IRA</option>
                        <option value="sep">SEP IRA</option>
                    </select>
                    @error('account_type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Custodian Name (optional)</label>
                    <input type="text" name="custodian_name" class="border p-2 rounded w-full" value="{{ old('custodian_name') }}" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Account Number (optional)</label>
                    <input type="text" name="account_number" class="border p-2 rounded w-full" value="{{ old('account_number') }}" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Tax Year</label>
                    <input type="number" name="tax_year" class="border p-2 rounded w-full" value="{{ old('tax_year', date('Y')) }}" />
                </div>

                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Open Account</button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>
