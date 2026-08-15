<?php

namespace App\Usecase\Admin;

use App\Constants\DatabaseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardUsecase extends Usecase
{
    public function getSummaryStats(): array
    {
        try {
            $totalSpeakers = DB::table(DatabaseConst::SPEAKER())
                ->whereNull('deleted_at')
                ->count();

            $totalPartners = DB::table(DatabaseConst::PARTNER())
                ->whereNull('deleted_at')
                ->count();

            return Response::buildSuccess(data: [
                'total_speakers' => $totalSpeakers,
                'total_partners' => $totalPartners,
            ]);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildSuccess(data: [
                'total_speakers' => 0,
                'total_partners' => 0,
            ]);
        }
    }
}
