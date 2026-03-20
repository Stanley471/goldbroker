<?php

namespace App\Http\Controllers;

use App\Models\IraAccount;
use App\Services\IraService;
use Illuminate\Http\Request;


class IraController extends Controller
{
    public function __construct(private IraService $iraService) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $iraAccounts = $user->iraAccounts()->get();
        return view('ira.index', compact('iraAccounts'));
    }

    public function create()
    {
        return view('ira.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_type' => ['required', 'in:traditional,roth,sep'],
            'custodian_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'tax_year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->iraService->openAccount($user, $request->all());

        return redirect()->route('ira.index')->with('success', 'IRA account opened successfully');
    }

    public function show(IraAccount $iraAccount)
    {
        return view('ira.show', compact('iraAccount'));
    }

    public function transfer(Request $request, IraAccount $iraAccount)
    {
        $request->validate([
            'grams' => ['required', 'numeric', 'min:0.01'],
            'direction' => ['required', 'in:to_ira,from_ira'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        try {
            if ($request->direction === 'to_ira') {
                $this->iraService->transferToIra($user, $iraAccount, $request->grams);
            } else {
                $this->iraService->transferFromIra($user, $iraAccount, $request->grams);
            }
            return back()->with('success', 'Transfer successful');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}