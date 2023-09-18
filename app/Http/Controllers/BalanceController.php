<?php

namespace App\Http\Controllers;

use App\Http\Requests\Balance\StoreBalanceRequest;
use App\Models\Balance;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Wallet $wallet)
    {
        return view('pages.balances.create', compact('wallet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBalanceRequest $request, Wallet $wallet)
    {
        try {
            $attributes = [
                ...$request->validated(),
                'user_id' => Auth::id(),
                'wallet_id' => $wallet->id,
            ];
            Balance::create($attributes);

            return redirect()->route('wallets.index')->with('success', 'Cập nhật số dư thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balance $balance)
    {
        //
    }
}
