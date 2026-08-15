<?php

use App\Http\Controllers\Api\AgendaGroupController;
use App\Http\Controllers\Api\AgendaItemController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventSectionController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MerchandiseController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\SpeakerController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:60,1')->group(function (): void {
    Route::get('events/agenda', [EventController::class, 'agenda']);
    Route::get('events/{id}/agenda', [EventController::class, 'agenda']);
    Route::apiResource('events', EventController::class)->only(['index', 'show']);
    Route::apiResource('event-sections', EventSectionController::class)->only(['index', 'show']);
    Route::apiResource('speakers', SpeakerController::class)->only(['index', 'show']);
    Route::apiResource('materials', MaterialController::class)->only(['index', 'show']);
    Route::apiResource('agenda-groups', AgendaGroupController::class)->only(['index', 'show']);
    Route::apiResource('agenda-items', AgendaItemController::class)->only(['index', 'show']);
    Route::apiResource('merchandises', MerchandiseController::class)->only(['index', 'show']);
    Route::apiResource('tickets', TicketController::class)->only(['index', 'show']);
    Route::apiResource('partners', PartnerController::class)->only(['index', 'show']);
});
