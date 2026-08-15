<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        Validator::make($filterData, [
            'keywords' => ['nullable', 'string', 'max:200'],
            'status' => ['nullable', 'in:draft,published,archived'],
            'with_unpublished' => ['boolean'],
            'no_pagination' => ['boolean'],
        ])->validate();

        try {
            $query = DB::table(DatabaseConst::EVENT().' as e')
                ->select([
                    'e.id',
                    'e.name',
                    'e.slug',
                    'e.description',
                    'e.starts_at',
                    'e.ends_at',
                    'e.location',
                    'e.status',
                ])
                ->whereNull('e.deleted_at')
                ->when(empty($filterData['with_unpublished']), function ($query): void {
                    $query->where('e.status', 'published');
                })
                ->when($filterData['status'] ?? null, function ($query, string $status): void {
                    $query->where('e.status', $status);
                })
                ->when($filterData['keywords'] ?? null, function ($query, string $keywords) {
                    $query->where(function ($query) use ($keywords): void {
                        $query->where('e.name', 'like', '%'.$keywords.'%')
                            ->orWhere('e.description', 'like', '%'.$keywords.'%');
                    });
                })
                ->orderByDesc('e.starts_at');

            $events = empty($filterData['no_pagination'])
                ? $query->paginate(20)
                : $query->get();

            if (! empty($filterData) && method_exists($events, 'appends')) {
                $events->appends($filterData);
            }

            return Response::buildSuccess(
                data: ['list' => $events],
                code: ResponseConst::HTTP_SUCCESS,
            );
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getByID(int $id, bool $onlyPublished = true): array
    {
        try {
            $event = DB::table(DatabaseConst::EVENT().' as e')
                ->select([
                    'e.id',
                    'e.name',
                    'e.slug',
                    'e.description',
                    'e.starts_at',
                    'e.ends_at',
                    'e.location',
                    'e.status',
                ])
                ->whereNull('e.deleted_at')
                ->when($onlyPublished, function ($query): void {
                    $query->where('e.status', 'published');
                })
                ->where('e.id', $id)
                ->first();

            if (! $event) {
                return Response::buildErrorNotFound();
            }

            $sections = $this->getActiveRecords(DatabaseConst::EVENT_SECTION(), $id, [
                'id', 'section_key', 'section_type', 'title', 'description', 'image_path',
                'settings_json', 'sort_order', 'is_active',
            ])->map(function (object $section): object {
                $section->settings_json = json_decode(
                    $section->settings_json ?? 'null',
                    flags: JSON_THROW_ON_ERROR,
                );

                return $section;
            });

            $speakers = $this->getActiveRecords(DatabaseConst::SPEAKER(), $id, [
                'id', 'name', 'photo_path', 'job_title', 'company', 'bio',
                'speaker_group', 'sort_order', 'is_active',
            ]);
            $materials = $this->getActiveRecords(DatabaseConst::MATERIAL(), $id, [
                'id', 'title', 'slug', 'description', 'label', 'label_color',
                'sort_order', 'is_active',
            ]);
            $agendaItems = $this->getActiveRecords(DatabaseConst::AGENDA_ITEM(), $id, [
                'id', 'agenda_group_id', 'material_id', 'title', 'category', 'starts_at', 'ends_at',
                'place', 'description', 'sort_order', 'is_active',
            ]);
            $agendaGroups = $this->getActiveRecords(DatabaseConst::AGENDA_GROUP(), $id, [
                'id', 'title', 'place', 'description', 'sort_order', 'is_active',
            ]);
            $merchandises = $this->getActiveRecords(DatabaseConst::MERCHANDISE(), $id, [
                'id', 'name', 'photo_path', 'description', 'cta_label', 'cta_url',
                'sort_order', 'is_active',
            ]);
            $tickets = $this->getActiveRecords(DatabaseConst::TICKET(), $id, [
                'id', 'name', 'slug', 'ticket_type', 'price', 'compare_price',
                'description_html', 'benefits_json', 'label', 'label_color', 'sales_starts_at',
                'sales_ends_at', 'cta_label', 'cta_url', 'sort_order', 'is_active',
            ])->map(function (object $ticket): object {
                $ticket->benefits_json = json_decode(
                    $ticket->benefits_json ?? '[]',
                    flags: JSON_THROW_ON_ERROR,
                );

                return $ticket;
            });
            $partners = $this->getActiveRecords(DatabaseConst::PARTNER(), $id, [
                'id', 'partner_type', 'sponsor_category', 'name', 'logo_path',
                'website_url', 'sort_order', 'is_active',
            ]);

            $materialSpeakers = DB::table(DatabaseConst::MATERIAL_SPEAKER().' as ms')
                ->join(DatabaseConst::MATERIAL().' as m', 'ms.material_id', '=', 'm.id')
                ->select(['ms.material_id', 'ms.speaker_id', 'ms.role', 'ms.sort_order'])
                ->where('m.event_id', $id)
                ->whereNull('m.deleted_at')
                ->whereNull('ms.deleted_at')
                ->orderBy('ms.sort_order')
                ->get();

            $materialsById = $materials->keyBy('id');
            $speakersById = $speakers->keyBy('id');
            $speakerLinksByMaterial = $materialSpeakers->groupBy('material_id');

            $agendaItems->each(function (object $agendaItem) use ($speakerLinksByMaterial, $speakersById, $materialsById): void {
                $material = $agendaItem->material_id ? $materialsById->get($agendaItem->material_id) : null;
                $agendaItem->title = $agendaItem->title ?? $material?->title;
                $agendaItem->material = $material ? (object) [
                    'id' => $material->id,
                    'title' => $material->title,
                    'slug' => $material->slug,
                    'label' => $material->label,
                    'label_color' => $material->label_color,
                ] : null;

                $agendaItem->speakers = $speakerLinksByMaterial
                    ->get($agendaItem->material_id, collect())
                    ->map(function (object $speakerLink) use ($speakersById): ?object {
                        $speaker = $speakersById->get($speakerLink->speaker_id);

                        if (! $speaker) {
                            return null;
                        }

                        return (object) [
                            'id' => $speaker->id,
                            'name' => $speaker->name,
                            'photo_path' => $speaker->photo_path,
                            'job_title' => $speaker->job_title,
                            'company' => $speaker->company,
                            'speaker_group' => $speaker->speaker_group,
                            'role' => $speakerLink->role,
                            'sort_order' => $speakerLink->sort_order,
                        ];
                    })
                    ->filter()
                    ->values();
            });

            $materialLinksBySpeaker = $materialSpeakers->groupBy('speaker_id');

            $speakers->each(function (object $speaker) use ($materialLinksBySpeaker, $materialsById): void {
                $speaker->materials = $materialLinksBySpeaker
                    ->get($speaker->id, collect())
                    ->map(function (object $materialLink) use ($materialsById): ?object {
                        $material = $materialsById->get($materialLink->material_id);

                        if (! $material) {
                            return null;
                        }

                        return (object) [
                            'id' => $material->id,
                            'title' => $material->title,
                            'slug' => $material->slug,
                            'label' => $material->label,
                            'label_color' => $material->label_color,
                            'role' => $materialLink->role,
                            'sort_order' => $materialLink->sort_order,
                        ];
                    })
                    ->filter()
                    ->values();
            });

            $agendaItemsByGroup = $agendaItems->groupBy('agenda_group_id');

            $agendaGroups->each(function (object $group) use ($agendaItemsByGroup): void {
                $items = $agendaItemsByGroup
                    ->get($group->id, collect())
                    ->map(function (object $item): object {
                        return (object) [
                            'id' => $item->id,
                            'title' => $item->title,
                            'starts_at' => $item->starts_at,
                            'ends_at' => $item->ends_at,
                            'place' => $item->place,
                            'description' => $item->description,
                            'sort_order' => $item->sort_order,
                            'material' => $item->material,
                            'speakers' => $item->speakers,
                        ];
                    })
                    ->values();

                $group->items = $items;
                $group->agenda_items = $items;
            });

            $ticketMerchandises = DB::table(DatabaseConst::TICKET_MERCHANDISE().' as tm')
                ->join(DatabaseConst::TICKET().' as t', 'tm.ticket_id', '=', 't.id')
                ->select(['tm.ticket_id', 'tm.merchandise_id', 'tm.quantity'])
                ->where('t.event_id', $id)
                ->whereNull('t.deleted_at')
                ->whereNull('tm.deleted_at')
                ->get();

            return Response::buildSuccess(data: [
                ...collect($event)->toArray(),
                'sections' => $sections,
                'speakers' => $speakers,
                'materials' => $materials,
                'material_speakers' => $materialSpeakers,
                'agenda_groups' => $agendaGroups,
                'agenda_items' => $agendaItems,
                'merchandises' => $merchandises,
                'tickets' => $tickets,
                'ticket_merchandises' => $ticketMerchandises,
                'partners' => $partners,
            ]);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getAgenda(?int $eventId = null): array
    {
        try {
            $eventQuery = DB::table(DatabaseConst::EVENT())
                ->whereNull('deleted_at')
                ->where('status', 'published');

            if ($eventId !== null) {
                $eventQuery->where('id', $eventId);
            } else {
                $eventQuery->orderByDesc('id');
            }

            $event = $eventQuery->first();

            if (! $event) {
                return Response::buildErrorNotFound();
            }

            $id = $event->id;

            $agendaGroups = $this->getActiveRecords(DatabaseConst::AGENDA_GROUP(), $id, [
                'id', 'title', 'place', 'description', 'sort_order', 'is_active',
            ]);

            $agendaItems = $this->getActiveRecords(DatabaseConst::AGENDA_ITEM(), $id, [
                'id', 'agenda_group_id', 'material_id', 'title', 'category', 'starts_at', 'ends_at',
                'place', 'description', 'sort_order', 'is_active',
            ]);

            $materials = $this->getActiveRecords(DatabaseConst::MATERIAL(), $id, [
                'id', 'title', 'slug', 'description', 'label', 'label_color', 'sort_order', 'is_active',
            ]);

            $speakers = $this->getActiveRecords(DatabaseConst::SPEAKER(), $id, [
                'id', 'name', 'photo_path', 'job_title', 'company', 'bio',
                'speaker_group', 'sort_order', 'is_active',
            ]);

            $materialSpeakers = DB::table(DatabaseConst::MATERIAL_SPEAKER().' as ms')
                ->join(DatabaseConst::MATERIAL().' as m', 'ms.material_id', '=', 'm.id')
                ->select(['ms.material_id', 'ms.speaker_id', 'ms.role', 'ms.sort_order'])
                ->where('m.event_id', $id)
                ->whereNull('m.deleted_at')
                ->whereNull('ms.deleted_at')
                ->orderBy('ms.sort_order')
                ->get();

            $speakersById = $speakers->keyBy('id');
            $materialsById = $materials->keyBy('id');
            $speakerLinksByMaterial = $materialSpeakers->groupBy('material_id');

            $agendaItems->each(function (object $agendaItem) use ($speakerLinksByMaterial, $speakersById, $materialsById): void {
                $material = $agendaItem->material_id ? $materialsById->get($agendaItem->material_id) : null;
                $agendaItem->title = $agendaItem->title ?? $material?->title;
                $agendaItem->material = $material ? (object) [
                    'id' => $material->id,
                    'title' => $material->title,
                    'slug' => $material->slug,
                    'label' => $material->label,
                    'label_color' => $material->label_color,
                ] : null;

                $agendaItem->speakers = $speakerLinksByMaterial
                    ->get($agendaItem->material_id, collect())
                    ->map(function (object $speakerLink) use ($speakersById): ?object {
                        $speaker = $speakersById->get($speakerLink->speaker_id);

                        if (! $speaker) {
                            return null;
                        }

                        return (object) [
                            'id' => $speaker->id,
                            'name' => $speaker->name,
                            'photo_path' => $speaker->photo_path,
                            'job_title' => $speaker->job_title,
                            'company' => $speaker->company,
                            'speaker_group' => $speaker->speaker_group,
                            'role' => $speakerLink->role,
                            'sort_order' => $speakerLink->sort_order,
                        ];
                    })
                    ->filter()
                    ->values();
            });

            $agendaItemsByGroup = $agendaItems->groupBy('agenda_group_id');

            $formattedAgendaGroups = $agendaGroups->map(function (object $group) use ($agendaItemsByGroup): object {
                $items = $agendaItemsByGroup
                    ->get($group->id, collect())
                    ->map(function (object $item): object {
                        return (object) [
                            'id' => $item->id,
                            'title' => $item->title,
                            'starts_at' => $item->starts_at,
                            'ends_at' => $item->ends_at,
                            'place' => $item->place,
                            'description' => $item->description,
                            'sort_order' => $item->sort_order,
                            'material' => $item->material,
                            'speakers' => $item->speakers,
                        ];
                    })
                    ->values();

                return (object) [
                    'id' => $group->id,
                    'title' => $group->title,
                    'place' => $group->place,
                    'description' => $group->description,
                    'sort_order' => $group->sort_order,
                    'items' => $items,
                ];
            })->values();

            return Response::buildSuccess(data: [
                'event' => [
                    'id' => $event->id,
                    'name' => $event->name,
                ],
                'agenda_groups' => $formattedAgendaGroups,
            ]);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function create(Request $data): array
    {
        $validated = $this->validatePayload($data);

        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::EVENT())->insert([
                ...$this->payload($validated),
                'created_by' => Auth::user()?->id,
                'created_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validated = $this->validatePayload($data, $id);

        DB::beginTransaction();
        try {
            $query = DB::table(DatabaseConst::EVENT())
                ->where('id', $id)
                ->whereNull('deleted_at');

            if (! $query->exists()) {
                DB::rollback();

                return Response::buildErrorNotFound();
            }

            $query->update([
                ...$this->payload($validated),
                'updated_by' => Auth::user()?->id,
                'updated_at' => now(),
            ]);

            DB::commit();

            return Response::buildSuccess(message: ResponseConst::SUCCESS_MESSAGE_UPDATED);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $deleted = DB::table(DatabaseConst::EVENT())
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->update([
                    'deleted_by' => Auth::user()?->id,
                    'deleted_at' => now(),
                ]);

            if (! $deleted) {
                DB::rollback();

                return Response::buildErrorNotFound();
            }

            DB::commit();

            return Response::buildSuccess(message: ResponseConst::SUCCESS_MESSAGE_DELETED);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    /**
     * @return array{name: string, slug: string, description: ?string, starts_at: ?string, ends_at: ?string, location: ?string, status: string}
     */
    private function validatePayload(Request $data, ?int $id = null): array
    {
        return Validator::make($data->all(), [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'alpha_dash', 'max:200', Rule::unique(DatabaseConst::VALIDATION_TABLE(DatabaseConst::EVENT()), 'slug')->ignore($id)],
            'description' => ['nullable', 'string'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published,archived'],
        ])->validate();
    }

    /**
     * @param  array{name: string, slug: string, description: ?string, starts_at: ?string, ends_at: ?string, location: ?string, status: string}  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        return [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'starts_at' => $this->dateTime($data['starts_at'] ?? null),
            'ends_at' => $this->dateTime($data['ends_at'] ?? null),
            'location' => $data['location'] ?? null,
            'status' => $data['status'],
        ];
    }

    private function dateTime(?string $value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * @param  list<string>  $columns
     * @return Collection<int, object>
     */
    private function getActiveRecords(string $table, int $eventId, array $columns): Collection
    {
        return DB::table($table)
            ->select($columns)
            ->where('event_id', $eventId)
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
