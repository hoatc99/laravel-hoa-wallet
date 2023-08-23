<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Auth::user()->wallets;
        foreach ($wallets as $wallet) {
            $savings = $wallet->savings;
            $total_saving = 0;
            foreach ($savings as $saving) {
                $total_saving = $total_saving + $saving->amount * ($saving->type ? -1 : 1);
            }
            $wallet->total_saving = $total_saving;
            $wallet->current_balance = $wallet->balances()->latest()->first()->amount ?? 0;
            $wallet->progress = $wallet->total_saving > 0 ? $wallet->current_balance / $wallet->total_saving * 100 : 0;
        }

        return view('pages.wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $wallet = Wallet::create($request->all());

            Auth::user()->wallets()->syncWithoutDetaching($wallet);

            return redirect()->route('wallets.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        return view('pages.wallets.edit', compact('wallet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        try {
            $wallet->update($request->all());

            return redirect()->route('wallets.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();

        return redirect()->route('wallets.index');
    }
}
