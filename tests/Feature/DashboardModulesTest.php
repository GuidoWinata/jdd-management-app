<?php

use App\Constants\UserConst;
use App\Models\User;
use App\Usecase\Admin\DashboardUsecase;
use App\Usecase\Admin\SidebarMenuUsecase;

test('dashboard renders total speaker and partner cards without modul aplikasi section', function () {
    $user = User::factory()->make(['id' => 1, 'access_type' => UserConst::SUPERADMIN]);

    $this->mock(SidebarMenuUsecase::class, function ($mock) {
        $mock->shouldReceive('getGroupKeys')
            ->andReturn(['utama']);

        $mock->shouldReceive('getMenusForSidebar')
            ->andReturn(['success' => true, 'data' => []]);
    });

    $this->mock(DashboardUsecase::class, function ($mock) {
        $mock->shouldReceive('getSummaryStats')
            ->andReturn([
                'success' => true,
                'data' => [
                    'total_speakers' => 12,
                    'total_partners' => 8,
                ],
            ]);
    });

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Total Speaker')
        ->assertSee('Total Partner & Sponsor', false)
        ->assertDontSee('Modul Aplikasi');
});
