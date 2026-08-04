<?php

use App\Http\Presenter\Response;
use App\Usecase\EventContentUsecase;
use App\Usecase\EventUsecase;

test('event list is exposed as json', function () {
    $process = Response::buildSuccess(['list' => [['id' => 1, 'name' => 'Jatim Developer Day']]]);

    $this->mock(EventUsecase::class, function ($mock) use ($process) {
        $mock->shouldReceive('getAll')
            ->once()
            ->with(['keywords' => null, 'no_pagination' => false])
            ->andReturn($process);
    });

    $this->getJson('/api/events')
        ->assertSuccessful()
        ->assertExactJson($process);
});

test('event detail is exposed as json', function () {
    $process = Response::buildSuccess([
        'id' => 1,
        'name' => 'Jatim Developer Day',
        'sections' => [],
        'speakers' => [],
        'agenda_items' => [[
            'id' => 1,
            'material_id' => 1,
            'speakers' => [['id' => 1, 'name' => 'Pemateri']],
        ]],
    ]);

    $this->mock(EventUsecase::class, function ($mock) use ($process) {
        $mock->shouldReceive('getByID')
            ->once()
            ->with(1)
            ->andReturn($process);
    });

    $this->getJson('/api/events/1')
        ->assertSuccessful()
        ->assertExactJson($process);
});

test('agenda item exposes its speakers as json', function () {
    $process = Response::buildSuccess([
        'id' => 1,
        'material_id' => 1,
        'speakers' => [['id' => 1, 'name' => 'Pemateri']],
    ]);

    $this->mock(EventContentUsecase::class, function ($mock) use ($process) {
        $mock->shouldReceive('getByID')
            ->once()
            ->with('agenda_items', 1)
            ->andReturn($process);
    });

    $this->getJson('/api/agenda-items/1')
        ->assertSuccessful()
        ->assertExactJson($process);
});

test('missing event returns json not found response', function () {
    $process = Response::buildErrorNotFound();

    $this->mock(EventUsecase::class, function ($mock) use ($process) {
        $mock->shouldReceive('getByID')
            ->once()
            ->with(999)
            ->andReturn($process);
    });

    $this->getJson('/api/events/999')
        ->assertNotFound()
        ->assertExactJson($process);
});

test('event filters are validated', function () {
    $this->getJson('/api/events?keywords[]=invalid')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('keywords');
});

test('event mutation routes are unavailable', function () {
    $this->postJson('/api/events')->assertMethodNotAllowed();
});

test('event content list endpoints are exposed as json', function (string $uri, string $resource) {
    $process = Response::buildSuccess(['list' => [['id' => 1]]]);

    $this->mock(EventContentUsecase::class, function ($mock) use ($process, $resource) {
        $mock->shouldReceive('getAll')
            ->once()
            ->with($resource, [
                'event_id' => null,
                'keywords' => null,
                'no_pagination' => false,
            ])
            ->andReturn($process);
    });

    $this->getJson('/api/'.$uri)
        ->assertSuccessful()
        ->assertExactJson($process);
})->with('event content resources');

test('event content detail endpoints are exposed as json', function (string $uri, string $resource) {
    $process = Response::buildSuccess(['id' => 1]);

    $this->mock(EventContentUsecase::class, function ($mock) use ($process, $resource) {
        $mock->shouldReceive('getByID')
            ->once()
            ->with($resource, 1)
            ->andReturn($process);
    });

    $this->getJson('/api/'.$uri.'/1')
        ->assertSuccessful()
        ->assertExactJson($process);
})->with('event content resources');

test('event content filters are validated', function () {
    $this->getJson('/api/speakers?event_id=invalid')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('event_id');
});

test('event content mutation routes are unavailable', function (string $uri) {
    $this->postJson('/api/'.$uri)->assertMethodNotAllowed();
})->with([
    'event sections' => 'event-sections',
    'speakers' => 'speakers',
    'materials' => 'materials',
    'agenda items' => 'agenda-items',
    'merchandises' => 'merchandises',
    'tickets' => 'tickets',
    'partners' => 'partners',
]);

dataset('event content resources', [
    'event sections' => ['event-sections', 'sections'],
    'speakers' => ['speakers', 'speakers'],
    'materials' => ['materials', 'materials'],
    'agenda items' => ['agenda-items', 'agenda_items'],
    'merchandises' => ['merchandises', 'merchandises'],
    'tickets' => ['tickets', 'tickets'],
    'partners' => ['partners', 'partners'],
]);
