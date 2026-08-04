<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EventUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        Validator::make($filterData, [
            'keywords' => ['nullable', 'string', 'max:200'],
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
                ->where('e.status', 'published')
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

    public function getByID(int $id): array
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
                ->where('e.status', 'published')
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
                'id', 'material_id', 'title', 'category', 'starts_at', 'ends_at',
                'place', 'description', 'sort_order', 'is_active',
            ]);
            $merchandises = $this->getActiveRecords(DatabaseConst::MERCHANDISE(), $id, [
                'id', 'name', 'photo_path', 'description', 'cta_label', 'cta_url',
                'sort_order', 'is_active',
            ]);
            $tickets = $this->getActiveRecords(DatabaseConst::TICKET(), $id, [
                'id', 'name', 'slug', 'ticket_type', 'price', 'compare_price',
                'description_html', 'label', 'label_color', 'sales_starts_at', 'sales_ends_at',
                'cta_label', 'cta_url', 'sort_order', 'is_active',
            ]);
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

            $speakersById = $speakers->keyBy('id');
            $speakerLinksByMaterial = $materialSpeakers->groupBy('material_id');

            $agendaItems->each(function (object $agendaItem) use ($speakerLinksByMaterial, $speakersById): void {
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
