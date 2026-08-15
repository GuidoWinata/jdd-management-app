<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\EventContentUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class EventContentController extends Controller
{
    protected string $resource;

    public function __construct(
        protected EventContentUsecase $usecase
    ) {}

    public function index(Request $request): JsonResponse
    {
        $process = $this->usecase->getAll(resource: $this->resource, filterData: $this->filters($request));

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    public function show(int $id): JsonResponse
    {
        $process = $this->usecase->getByID(resource: $this->resource, id: $id);

        return response()->json($process, $process['code'] ?? ResponseConst::HTTP_SUCCESS);
    }

    private function filters(Request $request): array
    {
        return [
            'event_id' => $request->get('event_id'),
            'keywords' => $request->get('keywords'),
            'partner_type' => $request->get('partner_type'),
            'sponsor_category' => $request->get('sponsor_category'),
            'speaker_group' => $request->get('speaker_group'),
            'ticket_type' => $request->get('ticket_type'),
            'no_pagination' => $request->boolean('no_pagination', true),
        ];
    }
}
