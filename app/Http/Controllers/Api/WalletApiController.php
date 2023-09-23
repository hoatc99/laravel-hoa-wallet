<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Table\WalletResource;
use App\Models\Wallet;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletApiController extends Controller
{
    use ApiResponser;

    public function getDataHistory(Wallet $wallet): JsonResponse
    {
        $data = WalletResource::collection($wallet->savings->sortByDesc('date'));

        return $this->successResponse($data);
    }

    public function updateOrder(Request $request): JsonResponse
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

    private function getStatisticsByYear(Wallet $wallet, int $year): JsonResponse
    {
        $savingData = $wallet->savings;

        $balanceData = $wallet->balances;
        $balance = $balanceData->where('created_at', '<', Carbon::create($year, 1, 1))->last()->amount ?? 0;

        for ($month = 1; $month <= 12; $month++) {
            $day = Carbon::create($year, $month, 1);
            $saving = $savingData->where('date', '<', $day->copy()->lastOfMonth())->sum('amount');
            $balance = $balanceData->filter(function ($item) use ($day) {
                return Carbon::parse($item->created_at)->isSameMonth($day);
            })->last()->amount ?? $balance;

            $data['statistics']['days'][] = $day;
            $data['statistics']['savings'][] = $saving;
            $data['statistics']['balances'][] = $balance;
        }

        $firstDayOfYear = Carbon::create($year, 1, 1)->firstOfMonth();
        $lastDayOfYear = Carbon::create($year, 12, 1)->lastOfMonth();
        $data['histories'] = WalletResource::collection($wallet->savings()->whereBetween('date', [$firstDayOfYear, $lastDayOfYear])->get());

        return $this->successResponse($data);
    }

    private function getStatisticsByMonth(Wallet $wallet, int $year, int $month): JsonResponse
    {
        $savingData = $wallet->savings;

        $balanceData = $wallet->balances;
        $balance = $balanceData->where('created_at', '<', Carbon::create($year, $month, 1))->last()->amount ?? 0;

        $days = $this->getDaysInSpecifiedMonth($year, $month);

        foreach ($days as $day) {
            $saving = $savingData->where('date', '<', $day)->sum('amount');
            $balance = $balanceData->filter(function ($item) use ($day) {
                return Carbon::parse($item->created_at)->isSameDay($day);
            })->last()->amount ?? $balance;

            $data['statistics']['days'][] = $day;
            $data['statistics']['savings'][] = $saving;
            $data['statistics']['balances'][] = $balance;
        }

        $firstDayOfMonth = Carbon::create($year, $month, 1)->firstOfMonth();
        $lastDayOfMonth = Carbon::create($year, $month, 1)->lastOfMonth();
        $data['histories'] = WalletResource::collection($wallet->savings()->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])->get());

        return $this->successResponse($data);
    }

    public function getStatistics(Request $request, Wallet $wallet): JsonResponse
    {
        $year = $request->year ?? Carbon::today()->year;
        $month = $request->month;

        if (! empty($month)) {
            return $this->getStatisticsByMonth($wallet, $year, $month);
        }

        return $this->getStatisticsByYear($wallet, $year);
    }
}
