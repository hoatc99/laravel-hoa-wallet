<?php

namespace App\Http\Controllers;

use App\Http\Requests\Saving\StoreSavingRequest;
use App\Models\Saving;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Wallet $wallet)
    {
        return view('pages.savings.create', compact('wallet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSavingRequest $request, Wallet $wallet)
    {
        try {
            $attributes = [
                ...$request->validated(),
                'user_id' => Auth::id(),
                'wallet_id' => $wallet->id,
            ];
            Saving::create($attributes);

            return redirect()->route('wallets.index')->with('success', 'Thêm tiết kiệm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saving $saving)
    {
        return view('pages.savings.edit', compact('saving'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        try {
            $saving->update($request->validated());

            return redirect()->route('wallets.savings.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        try {
            $saving->delete();

            return redirect()->route('wallets.savings.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}
