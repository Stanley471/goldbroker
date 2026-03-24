<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoWallet;
use Illuminate\Http\Request;

class CryptoWalletController extends Controller
{
    public function index()
    {
        $wallets = CryptoWallet::ordered()->get();
        return view('admin.crypto-wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('admin.crypto-wallets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:crypto_wallets,code',
            'symbol' => 'nullable|string|max:10',
            'address' => 'required|string|max:255',
            'network' => 'nullable|string|max:50',
            'exchange_rate' => 'required|numeric|min:0.0000000001',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        CryptoWallet::create($validated);

        return redirect()->route('admin.crypto-wallets.index')
            ->with('success', 'Crypto wallet created successfully');
    }

    public function edit(CryptoWallet $cryptoWallet)
    {
        return view('admin.crypto-wallets.edit', compact('cryptoWallet'));
    }

    public function update(Request $request, CryptoWallet $cryptoWallet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:crypto_wallets,code,' . $cryptoWallet->id,
            'symbol' => 'nullable|string|max:10',
            'address' => 'required|string|max:255',
            'network' => 'nullable|string|max:50',
            'exchange_rate' => 'required|numeric|min:0.0000000001',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $cryptoWallet->update($validated);

        return redirect()->route('admin.crypto-wallets.index')
            ->with('success', 'Crypto wallet updated successfully');
    }

    public function destroy(CryptoWallet $cryptoWallet)
    {
        $cryptoWallet->delete();

        return redirect()->route('admin.crypto-wallets.index')
            ->with('success', 'Crypto wallet deleted successfully');
    }

    public function toggleActive(CryptoWallet $cryptoWallet)
    {
        $cryptoWallet->update(['is_active' => !$cryptoWallet->is_active]);

        return redirect()->route('admin.crypto-wallets.index')
            ->with('success', 'Crypto wallet status updated');
    }
}
