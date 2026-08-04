<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EventContentUsecase extends Usecase
{
    public function getAll(string $resource, array $filterData = []): array
    {
        Validator::make($filterData, [
            'event_id' => ['nullable', 'integer', 'min:1'],
            'keywords' => ['nullable', 'string', 'max:200'],
            'no_pagination' => ['boolean'],
        ])->validate();

        try {
            $config = $this->resourceConfig($resource);
            $query = $this->resourceQuery($config)
                ->when($filterData['event_id'] ?? null, function (Builder $query, int|string $eventId): void {
                    $query->where('r.event_id', $eventId);
                })
                ->when($filterData['keywords'] ?? null, function (Builder $query, string $keywords) use ($config): void {
                    $query->where(function (Builder $query) use ($config, $keywords): void {
                        foreach ($config['search'] as $index => $column) {
                            $method = $index === 0 ? 'where' : 'orWhere';
                            $query->{$method}('r.'.$column, 'like', '%'.$keywords.'%');
                        }
                    });
                })
                ->orderBy('r.sort_order')
                ->orderBy('r.id');

            $records = empty($filterData['no_pagination'])
                ? $query->paginate(20)
                : $query->get();

            if (! empty($filterData) && method_exists($records, 'appends')) {
                $records->appends($filterData);
            }

            $records = $this->transformRecords($records, $config['json']);

            if ($resource === 'agenda_items') {
                $this->attachAgendaSpeakers($records);
            }

            return Response::buildSuccess(
                data: ['list' => $records],
                code: ResponseConst::HTTP_SUCCESS,
            );
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__, 'resource' => $resource]);

            return Response::buildErrorService();
        }
    }

    public function getByID(string $resource, int $id): array
    {
        try {
            $config = $this->resourceConfig($resource);
            $record = $this->resourceQuery($config)
                ->where('r.id', $id)
                ->first();

            if (! $record) {
                return Response::buildErrorNotFound();
            }

            $record = $this->transformRecord($record, $config['json']);

            return Response::buildSuccess(data: collect(
                $this->attachRelations($resource, $record)
            )->toArray());
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__, 'resource' => $resource]);

            return Response::buildErrorService();
        }
    }

    /**
     * @param  array{table: string, columns: list<string>, search: list<string>, json: list<string>}  $config
     */
    private function resourceQuery(array $config): Builder
    {
        return DB::table($config['table'].' as r')
            ->join(DatabaseConst::EVENT().' as e', 'r.event_id', '=', 'e.id')
            ->select(array_map(fn (string $column): string => 'r.'.$column, $config['columns']))
            ->whereNull('r.deleted_at')
            ->where('r.is_active', true)
            ->whereNull('e.deleted_at')
            ->where('e.status', 'published');
    }

    /**
     * @return array{table: string, columns: list<string>, search: list<string>, json: list<string>}
     */
    private function resourceConfig(string $resource): array
    {
        return match ($resource) {
            'sections' => [
                'table' => DatabaseConst::EVENT_SECTION(),
                'columns' => ['id', 'event_id', 'section_key', 'section_type', 'title', 'description', 'image_path', 'settings_json', 'sort_order', 'is_active'],
                'search' => ['title', 'description'],
                'json' => ['settings_json'],
            ],
            'speakers' => [
                'table' => DatabaseConst::SPEAKER(),
                'columns' => ['id', 'event_id', 'name', 'photo_path', 'job_title', 'company', 'bio', 'speaker_group', 'sort_order', 'is_active'],
                'search' => ['name', 'job_title', 'company'],
                'json' => [],
            ],
            'materials' => [
                'table' => DatabaseConst::MATERIAL(),
                'columns' => ['id', 'event_id', 'title', 'slug', 'description', 'label', 'label_color', 'sort_order', 'is_active'],
                'search' => ['title', 'description', 'label'],
                'json' => [],
            ],
            'agenda_items' => [
                'table' => DatabaseConst::AGENDA_ITEM(),
                'columns' => ['id', 'event_id', 'material_id', 'title', 'category', 'starts_at', 'ends_at', 'place', 'description', 'sort_order', 'is_active'],
                'search' => ['title', 'category', 'description'],
                'json' => [],
            ],
            'merchandises' => [
                'table' => DatabaseConst::MERCHANDISE(),
                'columns' => ['id', 'event_id', 'name', 'photo_path', 'description', 'cta_label', 'cta_url', 'sort_order', 'is_active'],
                'search' => ['name', 'description'],
                'json' => [],
            ],
            'tickets' => [
                'table' => DatabaseConst::TICKET(),
                'columns' => ['id', 'event_id', 'name', 'slug', 'ticket_type', 'price', 'compare_price', 'description_html', 'label', 'label_color', 'sales_starts_at', 'sales_ends_at', 'cta_label', 'cta_url', 'sort_order', 'is_active'],
                'search' => ['name', 'description_html', 'label'],
                'json' => [],
            ],
            'partners' => [
                'table' => DatabaseConst::PARTNER(),
                'columns' => ['id', 'event_id', 'partner_type', 'sponsor_category', 'name', 'logo_path', 'website_url', 'sort_order', 'is_active'],
                'search' => ['name', 'partner_type', 'sponsor_category'],
                'json' => [],
            ],
        };
    }

    /**
     * @param  list<string>  $jsonColumns
     */
    private function transformRecords(Collection|AbstractPaginator $records, array $jsonColumns): Collection|AbstractPaginator
    {
        if (empty($jsonColumns)) {
            return $records;
        }

        $collection = $records instanceof AbstractPaginator
            ? $records->getCollection()
            : $records;
        $collection->transform(fn (object $record): object => $this->transformRecord($record, $jsonColumns));

        if ($records instanceof AbstractPaginator) {
            return $records->setCollection($collection);
        }

        return $collection;
    }

    /**
     * @param  list<string>  $jsonColumns
     */
    private function transformRecord(object $record, array $jsonColumns): object
    {
        foreach ($jsonColumns as $column) {
            $record->{$column} = json_decode($record->{$column} ?? 'null', flags: JSON_THROW_ON_ERROR);
        }

        return $record;
    }

    private function attachRelations(string $resource, object $record): object
    {
        if ($resource === 'materials') {
            $record->speakers = DB::table(DatabaseConst::SPEAKER().' as s')
                ->join(DatabaseConst::MATERIAL_SPEAKER().' as ms', 's.id', '=', 'ms.speaker_id')
                ->select(['s.id', 's.name', 's.photo_path', 's.job_title', 's.company', 's.speaker_group', 'ms.role', 'ms.sort_order'])
                ->where('ms.material_id', $record->id)
                ->whereNull('s.deleted_at')
                ->whereNull('ms.deleted_at')
                ->where('s.is_active', true)
                ->orderBy('ms.sort_order')
                ->get();
        } elseif ($resource === 'speakers') {
            $record->materials = DB::table(DatabaseConst::MATERIAL().' as m')
                ->join(DatabaseConst::MATERIAL_SPEAKER().' as ms', 'm.id', '=', 'ms.material_id')
                ->select(['m.id', 'm.title', 'm.slug', 'm.label', 'm.label_color', 'ms.role', 'ms.sort_order'])
                ->where('ms.speaker_id', $record->id)
                ->whereNull('m.deleted_at')
                ->whereNull('ms.deleted_at')
                ->where('m.is_active', true)
                ->orderBy('ms.sort_order')
                ->get();
        } elseif ($resource === 'tickets') {
            $record->merchandises = DB::table(DatabaseConst::MERCHANDISE().' as m')
                ->join(DatabaseConst::TICKET_MERCHANDISE().' as tm', 'm.id', '=', 'tm.merchandise_id')
                ->select(['m.id', 'm.name', 'm.photo_path', 'm.description', 'tm.quantity'])
                ->where('tm.ticket_id', $record->id)
                ->whereNull('m.deleted_at')
                ->whereNull('tm.deleted_at')
                ->where('m.is_active', true)
                ->get();
        } elseif ($resource === 'merchandises') {
            $record->tickets = DB::table(DatabaseConst::TICKET().' as t')
                ->join(DatabaseConst::TICKET_MERCHANDISE().' as tm', 't.id', '=', 'tm.ticket_id')
                ->select(['t.id', 't.name', 't.slug', 't.ticket_type', 't.price', 'tm.quantity'])
                ->where('tm.merchandise_id', $record->id)
                ->whereNull('t.deleted_at')
                ->whereNull('tm.deleted_at')
                ->where('t.is_active', true)
                ->orderBy('t.sort_order')
                ->get();
        } elseif ($resource === 'agenda_items') {
            $record->material = $record->material_id === null
                ? null
                : DB::table(DatabaseConst::MATERIAL())
                    ->select(['id', 'title', 'slug', 'label', 'label_color'])
                    ->where('id', $record->material_id)
                    ->whereNull('deleted_at')
                    ->where('is_active', true)
                    ->first();

            $this->attachAgendaSpeakers(collect([$record]));
        }

        return $record;
    }

    private function attachAgendaSpeakers(Collection|AbstractPaginator $records): void
    {
        $agendaItems = $records instanceof AbstractPaginator
            ? $records->getCollection()
            : $records;
        $materialIds = $agendaItems->pluck('material_id')->filter()->unique()->values();

        if ($materialIds->isEmpty()) {
            $agendaItems->each(function (object $agendaItem): void {
                $agendaItem->speakers = collect();
            });

            return;
        }

        $speakersByMaterial = DB::table(DatabaseConst::SPEAKER().' as s')
            ->join(DatabaseConst::MATERIAL_SPEAKER().' as ms', 's.id', '=', 'ms.speaker_id')
            ->select(['ms.material_id', 's.id', 's.name', 's.photo_path', 's.job_title', 's.company', 's.speaker_group', 'ms.role', 'ms.sort_order'])
            ->whereIn('ms.material_id', $materialIds)
            ->whereNull('s.deleted_at')
            ->whereNull('ms.deleted_at')
            ->where('s.is_active', true)
            ->orderBy('ms.sort_order')
            ->get()
            ->groupBy('material_id');

        $agendaItems->each(function (object $agendaItem) use ($speakersByMaterial): void {
            $agendaItem->speakers = $speakersByMaterial
                ->get($agendaItem->material_id, collect())
                ->map(function (object $speaker): object {
                    unset($speaker->material_id);

                    return $speaker;
                })
                ->values();
        });
    }
}
