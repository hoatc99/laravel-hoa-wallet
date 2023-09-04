<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\StoreWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Auth::user()->wallets()->orderBy('wallet_order')->get();
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
        $icons = config('icons');

        return view('pages.wallets.create', compact('icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        DB::beginTransaction();
        try {
            $wallets = Auth::user()->wallets();
            $wallets->increment('wallet_order');

            $wallet = Wallet::create($request->validated());
            $wallets->syncWithoutDetaching([$wallet->id => ['wallet_order' => 1]]);
            DB::commit();

            return redirect()->route('wallets.index');
        } catch (\Exception $e) {
            DB::rollBack();

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
        $icons = config('icons');

        return view('pages.wallets.edit', compact('wallet', 'icons'));
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

    public function statistics(Wallet $wallet)
    {
        return view('pages.wallets.statistics', compact('wallet'));
    }

    public function histories(Wallet $wallet)
    {
        return view('pages.wallets.histories', compact('wallet'));
    }

    public function order()
    {
        $wallets = Auth::user()->wallets()->orderBy('wallet_order')->get();
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

        return view('pages.wallets.order', compact('wallets'));
    }
}
