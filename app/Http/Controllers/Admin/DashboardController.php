<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Usecase\Admin\DashboardUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardUsecase $dashboardUsecase,
    ) {}

    public function index(): View|Response
    {
        $stats = $this->dashboardUsecase->getSummaryStats()['data'] ?? [
            'total_speakers' => 0,
            'total_partners' => 0,
        ];

        return view('_admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}
