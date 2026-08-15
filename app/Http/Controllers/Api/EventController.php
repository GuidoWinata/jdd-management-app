<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\EventUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        protected EventUsecase $usecase
    ) {}

    public function index(Request $request): JsonResponse
    {
        $process = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'no_pagination' => true,
        ]);

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    public function show(int $id): JsonResponse
    {
        $process = $this->usecase->getByID($id);

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    public function agenda(?int $id = null): JsonResponse
    {
        $process = $this->usecase->getAgenda($id);

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }
}
