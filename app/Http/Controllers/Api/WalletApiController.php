<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Table\WalletResource;
use App\Models\Wallet;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletApiController extends Controller
{
    use ApiResponser;

    public function getDataChart(Request $request, Wallet $wallet)
    {
        $year = $request->year;
        $month = $request->month;

        $savingData = $wallet->savings;

        $balanceData = $wallet->balances;
        $balance = $balanceData->where('created_at', '<', Carbon::create($year, $month, 1))->last()->amount ?? 0;

        $days = $this->getDaysInSpecifiedMonth($year, $month);

        foreach ($days as $day) {
            $saving = $savingData->where('date', '<', $day)->sum('amount');
            $balance = $balanceData->filter(function ($item) use ($day) {
                return Carbon::parse($item->created_at)->isSameDay($day);
            })->last()->amount ?? $balance;

            $data['days'][] = $day;
            $data['savings'][] = $saving;
            $data['balances'][] = $balance;
        }

        return $this->successResponse($data);
    }

    public function getDataHistory(Request $request, Wallet $wallet)
    {
        $year = $request->year ?? Carbon::today()->year;
        $month = $request->month ?? Carbon::today()->month;
        $firstDayOfMonth = Carbon::create($year, $month, 1)->firstOfMonth();
        $lastDayOfMonth = Carbon::create($year, $month, 1)->lastOfMonth();

        $data = WalletResource::collection($wallet->savings()->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])->get());

        return $this->successResponse($data);
    }

    public function updateOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->ids;
            foreach ($ids as $key => $id) {
                Auth::user()->wallets()->where('wallet_id', $id)->update(['wallet_order' => $key + 1]);
            }
            DB::commit();
            return $this->successResponse(null);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(null, 'Update failed');
        }
    }

    private function getDaysInSpecifiedMonth(int $year, int $month): array
    {
        $firstDayOfMonth = Carbon::create($year, $month, 1)->firstOfMonth();
        $lastDayOfMonth = Carbon::create($year, $month, 1)->lastOfMonth();
        $daysInMonth = [];
        while ($firstDayOfMonth->lte($lastDayOfMonth)) {
            $daysInMonth[] = $firstDayOfMonth->copy();
            $firstDayOfMonth->addDay();
        }

        return $daysInMonth;
    }

    private function getMonthsInSpecifiedYear(int $year): array
    {
        $daysInMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth[] = Carbon::create($year, $month, 1);
        }

        return $daysInMonth;
    }

    public function getStatisticsByYear(Request $request, Wallet $wallet)
    {
        $year = $request->year ?? Carbon::today()->year;

        $savingData = $wallet->savings;

        $balanceData = $wallet->balances;
        $balance = $balanceData->where('created_at', '<', Carbon::create($year, 1, 1))->last()->amount ?? 0;

        $days = $this->getMonthsInSpecifiedYear($year);

        foreach ($days as $day) {
            $saving = $savingData->where('date', '<', $day->lastOfMonth())->sum('amount');
            $balance = $balanceData->filter(function ($item) use ($day) {
                return Carbon::parse($item->created_at)->isSameDay($day);
            })->last()->amount ?? $balance;

            $data['days'][] = $day;
            $data['savings'][] = $saving;
            $data['balances'][] = $balance;
        }

        return $this->successResponse($data);
    }
}
