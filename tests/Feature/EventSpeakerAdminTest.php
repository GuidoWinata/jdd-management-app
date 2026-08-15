<?php

use App\Constants\UserConst;
use App\Models\User;
use App\Usecase\Admin\SidebarMenuUsecase;
use App\Usecase\EventContentUsecase;

test('admin speaker index displays speaker group column and filter', function () {
    $user = User::factory()->make(['id' => 1, 'access_type' => UserConst::SUPERADMIN]);

    $this->mock(SidebarMenuUsecase::class, function ($mock) {
        $mock->shouldReceive('getGroupKeys')->andReturn(['utama']);
        $mock->shouldReceive('getMenusForSidebar')->andReturn(['success' => true, 'data' => []]);
    });

    $speakers = [
        (object) [
            'id' => 1,
            'name' => 'John Keynote',
            'speaker_group' => 'keynote',
            'event_id' => 1,
            'event_name' => 'JDD 2026',
            'is_active' => 1,
        ],
        (object) [
            'id' => 2,
            'name' => 'Jane Workshop',
            'speaker_group' => 'workshop',
            'event_id' => 1,
            'event_name' => 'JDD 2026',
            'is_active' => 1,
        ],
    ];

    $this->mock(EventContentUsecase::class, function ($mock) use ($speakers) {
        $mock->shouldReceive('getAll')
            ->once()
            ->with('speakers', [
                'event_id' => null,
                'keywords' => null,
                'partner_type' => null,
                'sponsor_category' => null,
                'speaker_group' => 'keynote',
                'with_inactive' => true,
                'with_unpublished' => true,
            ])
            ->andReturn([
                'success' => true,
                'data' => ['list' => [$speakers[0]]],
            ]);

        $mock->shouldReceive('getEventOptions')
            ->once()
            ->andReturn([1 => 'JDD 2026']);
    });

    $this->actingAs($user)
        ->get(route('admin.event_speakers.index', ['speaker_group' => 'keynote']))
        ->assertSuccessful()
        ->assertSee('Group Speaker')
        ->assertSee('Semua Group Speaker')
        ->assertSee('John Keynote')
        ->assertSee('Keynote');
});
