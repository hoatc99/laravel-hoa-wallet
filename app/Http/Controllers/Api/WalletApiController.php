<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WalletApiController extends Controller
{
    use ApiResponser;

    public function getDataForChart(Request $request, Wallet $wallet)
    {
        $year = $request->year ?? Carbon::today()->year;
        $month = $request->month ?? Carbon::today()->month;

        $savingData = $wallet->savings;

        $balanceData = $wallet->balances;
        $balance = $balanceData->where('created_at', '<', Carbon::create($year, $month, 1))->last()->amount ?? 0;

        $days = $this->getDaysInSpecifiedMonth($year, $month);

        foreach ($days as $day) {
            $saving = $savingData->where('created_at', '<', $day->endOfDay())->sum('amount');
            $balance = $balanceData->filter(function ($item) use ($day) {
                return Carbon::parse($item->created_at)->isSameDay($day);
            })->last()->amount ?? $balance;

            $data['days'][] = $day->toDAteString();
            $data['savings'][] = $saving;
            $data['balances'][] = $balance;
        }

        return $this->successResponse($data);
    }

    public function getDaysInSpecifiedMonth(int $year, int $month): array
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
}
