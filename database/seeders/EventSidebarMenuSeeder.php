<?php

namespace Database\Seeders;

use App\Constants\DatabaseConst;
use App\Constants\UserConst;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSidebarMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $roles = array_keys(UserConst::getAccessTypes());

        DB::table(DatabaseConst::SIDEBAR_MENU())
            ->where('route_name', 'admin.event_agenda_items.index')
            ->update(['route_name' => 'admin.event_agenda_groups.index', 'updated_at' => $now]);

        DB::table(DatabaseConst::SIDEBAR_MENU_GROUP())->updateOrInsert(
            ['key' => 'utama'],
            ['label' => 'Utama', 'color' => 'blue', 'sort_order' => 10, 'updated_at' => $now],
        );

        $parentId = $this->upsertMenu([
            'label' => 'Konten Event',
            'route_name' => null,
            'icon' => '_admin._layout.icons.sidebar.data_master',
            'group' => 'utama',
            'sort_order' => 60,
            'is_active' => 1,
        ], $now);

        $this->syncAccess($parentId, $roles, $now);

        foreach ($this->menus($parentId) as $menu) {
            $menuId = $this->upsertMenu($menu, $now);
            $this->syncAccess($menuId, $roles, $now);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function menus(int $parentId): array
    {
        return [
            ['parent_id' => $parentId, 'label' => 'Event', 'route_name' => 'admin.events.index', 'sort_order' => 61],
            ['parent_id' => $parentId, 'label' => 'Section Event', 'route_name' => 'admin.event_sections.index', 'sort_order' => 62],
            ['parent_id' => $parentId, 'label' => 'Speaker', 'route_name' => 'admin.event_speakers.index', 'sort_order' => 63],
            ['parent_id' => $parentId, 'label' => 'Materi', 'route_name' => 'admin.event_materials.index', 'sort_order' => 64],
            ['parent_id' => $parentId, 'label' => 'Agenda', 'route_name' => 'admin.event_agenda_groups.index', 'sort_order' => 65],
            ['parent_id' => $parentId, 'label' => 'Merchandise', 'route_name' => 'admin.event_merchandises.index', 'sort_order' => 66],
            ['parent_id' => $parentId, 'label' => 'Tiket', 'route_name' => 'admin.event_tickets.index', 'sort_order' => 67],
            ['parent_id' => $parentId, 'label' => 'Partner', 'route_name' => 'admin.event_partners.index', 'sort_order' => 68],
        ];
    }

    /**
     * @param  array<string, mixed>  $menu
     */
    private function upsertMenu(array $menu, mixed $now): int
    {
        $existing = empty($menu['route_name'])
            ? DB::table(DatabaseConst::SIDEBAR_MENU())->where('label', $menu['label'])->whereNull('route_name')->first()
            : DB::table(DatabaseConst::SIDEBAR_MENU())->where('route_name', $menu['route_name'])->first();

        $payload = [
            'parent_id' => $menu['parent_id'] ?? null,
            'label' => $menu['label'],
            'route_name' => $menu['route_name'],
            'icon' => $menu['icon'] ?? null,
            'group' => $menu['group'] ?? 'utama',
            'sort_order' => $menu['sort_order'],
            'is_active' => $menu['is_active'] ?? 1,
            'updated_at' => $now,
            'deleted_at' => null,
        ];

        if ($existing) {
            DB::table(DatabaseConst::SIDEBAR_MENU())
                ->where('id', $existing->id)
                ->update($payload);

            return (int) $existing->id;
        }

        return (int) DB::table(DatabaseConst::SIDEBAR_MENU())->insertGetId([
            ...$payload,
            'created_at' => $now,
        ]);
    }

    /**
     * @param  array<int>  $roles
     */
    private function syncAccess(int $menuId, array $roles, mixed $now): void
    {
        $existingRoles = DB::table(DatabaseConst::SIDEBAR_MENU_ACCESS())
            ->where('sidebar_menu_id', $menuId)
            ->pluck('access_type')
            ->map(fn (mixed $role): int => (int) $role)
            ->all();

        $missingRoles = array_values(array_diff($roles, $existingRoles));

        if (empty($missingRoles)) {
            return;
        }

        DB::table(DatabaseConst::SIDEBAR_MENU_ACCESS())->insert(array_map(fn (int $role): array => [
            'sidebar_menu_id' => $menuId,
            'access_type' => $role,
            'created_at' => $now,
        ], $missingRoles));
    }
}
