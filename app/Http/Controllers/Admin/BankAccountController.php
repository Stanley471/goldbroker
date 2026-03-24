<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::ordered()->get();
        return view('admin.bank-accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'bank_address' => 'nullable|string|max:500',
            'routing_number' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'currency' => 'required|string|max:3',
            'instructions' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        BankAccount::create($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account created successfully');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'bank_address' => 'nullable|string|max:500',
            'routing_number' => 'nullable|string|max:50',
            'swift_code' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'currency' => 'required|string|max:3',
            'instructions' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $bankAccount->update($validated);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account updated successfully');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account deleted successfully');
    }

    public function toggleActive(BankAccount $bankAccount)
    {
        $bankAccount->update(['is_active' => !$bankAccount->is_active]);

        return redirect()->route('admin.bank-accounts.index')
            ->with('success', 'Bank account status updated');
    }
}
