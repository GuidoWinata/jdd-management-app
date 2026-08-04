<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\EventContentUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function __construct(protected EventContentUsecase $usecase) {}

    public function index(Request $request): JsonResponse
    {
        $process = $this->usecase->getAll(resource: 'merchandises', filterData: $this->filters($request));

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    public function show(int $id): JsonResponse
    {
        $process = $this->usecase->getByID(resource: 'merchandises', id: $id);

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    private function filters(Request $request): array
    {
        return ['event_id' => $request->get('event_id'), 'keywords' => $request->get('keywords'), 'no_pagination' => $request->boolean('no_pagination')];
    }
}
