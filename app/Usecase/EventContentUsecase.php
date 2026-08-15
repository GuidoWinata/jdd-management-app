<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RuntimeException;

class EventContentUsecase extends Usecase
{
    public function getAll(string $resource, array $filterData = []): array
    {
        Validator::make($filterData, [
            'event_id' => ['nullable', 'integer', 'min:1'],
            'keywords' => ['nullable', 'string', 'max:200'],
            'partner_type' => ['nullable', 'string', 'max:50'],
            'sponsor_category' => ['nullable', 'string', 'max:50'],
            'speaker_group' => ['nullable', 'string', 'max:50'],
            'ticket_type' => ['nullable', 'string', 'max:50'],
            'with_inactive' => ['boolean'],
            'with_unpublished' => ['boolean'],
            'no_pagination' => ['boolean'],
        ])->validate();

        try {
            $config = $this->resourceConfig($resource);
            $query = $this->resourceQuery(
                config: $config,
                withInactive: ! empty($filterData['with_inactive']),
                withUnpublished: ! empty($filterData['with_unpublished']),
            )
                ->when($filterData['event_id'] ?? null, function (Builder $query, int|string $eventId): void {
                    $query->where('r.event_id', $eventId);
                })
                ->when($filterData['partner_type'] ?? null, function (Builder $query, string $partnerType): void {
                    $query->where('r.partner_type', $partnerType);
                })
                ->when($filterData['sponsor_category'] ?? null, function (Builder $query, string $sponsorCategory): void {
                    $query->where('r.sponsor_category', $sponsorCategory);
                })
                ->when($filterData['speaker_group'] ?? null, function (Builder $query, string $speakerGroup): void {
                    $query->where('r.speaker_group', $speakerGroup);
                })
                ->when($filterData['ticket_type'] ?? null, function (Builder $query, string $ticketType): void {
                    $query->where('r.ticket_type', $ticketType);
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
            } elseif ($resource === 'speakers') {
                $this->attachSpeakerMaterials($records);
            } elseif ($resource === 'agenda_groups') {
                $this->attachAgendaGroupItems($records);
            } elseif ($resource === 'materials') {
                $this->attachMaterialSpeakers($records);
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

    public function getByID(string $resource, int $id, bool $onlyActive = true, bool $onlyPublished = true): array
    {
        try {
            $config = $this->resourceConfig($resource);
            $record = $this->resourceQuery(
                config: $config,
                withInactive: ! $onlyActive,
                withUnpublished: ! $onlyPublished,
            )
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

    public function getEventOptions(): array
    {
        try {
            $events = DB::table(DatabaseConst::EVENT())
                ->select(['id', 'name'])
                ->whereNull('deleted_at')
                ->orderByDesc('starts_at')
                ->orderBy('name')
                ->get();

            return Response::buildSuccess(data: $events);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getMaterialOptions(): array
    {
        try {
            $materials = DB::table(DatabaseConst::MATERIAL().' as m')
                ->join(DatabaseConst::EVENT().' as e', 'm.event_id', '=', 'e.id')
                ->select(['m.id', 'm.title', 'e.name as event_name'])
                ->whereNull('m.deleted_at')
                ->whereNull('e.deleted_at')
                ->orderByDesc('e.starts_at')
                ->orderBy('m.sort_order')
                ->get();

            return Response::buildSuccess(data: $materials);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getSpeakerOptions(): array
    {
        try {
            $speakers = DB::table(DatabaseConst::SPEAKER().' as s')
                ->join(DatabaseConst::EVENT().' as e', 's.event_id', '=', 'e.id')
                ->select(['s.id', 's.name', 's.job_title', 's.company', 'e.name as event_name'])
                ->whereNull('s.deleted_at')
                ->whereNull('e.deleted_at')
                ->where('s.is_active', true)
                ->orderByDesc('e.starts_at')
                ->orderBy('s.sort_order')
                ->get();

            return Response::buildSuccess(data: $speakers);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getMerchandiseOptions(): array
    {
        try {
            $merchandises = DB::table(DatabaseConst::MERCHANDISE().' as m')
                ->join(DatabaseConst::EVENT().' as e', 'm.event_id', '=', 'e.id')
                ->select(['m.id', 'm.name', 'e.name as event_name'])
                ->whereNull('m.deleted_at')
                ->whereNull('e.deleted_at')
                ->orderByDesc('e.starts_at')
                ->orderBy('m.sort_order')
                ->get();

            return Response::buildSuccess(data: $merchandises);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function getSpeakerGroupOptions(): array
    {
        try {
            $groups = DB::table(DatabaseConst::SPEAKER())
                ->whereNull('deleted_at')
                ->whereNotNull('speaker_group')
                ->where('speaker_group', '!=', '')
                ->distinct()
                ->orderBy('speaker_group')
                ->pluck('speaker_group');

            return Response::buildSuccess(data: $groups);
        } catch (Exception $exception) {
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__]);

            return Response::buildErrorService();
        }
    }

    public function create(string $resource, Request $data): array
    {
        $this->normalizeRequest($resource, $data);
        $validated = $this->validatePayload($resource, $data);

        DB::beginTransaction();
        try {
            $payload = [
                ...$this->payload($resource, $validated, $data),
                'created_by' => Auth::user()?->id,
                'created_at' => now(),
            ];
            $table = $this->resourceConfig($resource)['table'];

            if ($resource === 'tickets') {
                $ticketId = DB::table($table)->insertGetId($payload);
                $this->syncTicketMerchandises($ticketId, $validated['merchandise_addons'] ?? []);
            } elseif ($resource === 'materials') {
                $materialId = DB::table($table)->insertGetId($payload);
                $this->syncMaterialSpeaker($materialId, (int) $validated['speaker_id']);
            } elseif ($resource === 'agenda_groups') {
                $agendaGroupId = DB::table($table)->insertGetId($payload);
                $this->syncAgendaItems($agendaGroupId, (int) $validated['event_id'], $validated['title'], $validated['agenda_items']);
            } else {
                DB::table($table)->insert($payload);
            }

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__, 'resource' => $resource]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    public function update(string $resource, Request $data, int $id): array
    {
        $this->normalizeRequest($resource, $data);
        $validated = $this->validatePayload($resource, $data, $id);

        DB::beginTransaction();
        try {
            $query = DB::table($this->resourceConfig($resource)['table'])
                ->where('id', $id)
                ->whereNull('deleted_at');

            $record = $query->first();

            if (! $record) {
                DB::rollback();

                return Response::buildErrorNotFound();
            }

            $query->update([
                ...$this->payload($resource, $validated, $data, $record),
                'updated_by' => Auth::user()?->id,
                'updated_at' => now(),
            ]);

            if ($resource === 'tickets') {
                $this->syncTicketMerchandises($id, $validated['merchandise_addons'] ?? []);
            } elseif ($resource === 'materials') {
                $this->syncMaterialSpeaker($id, (int) $validated['speaker_id']);
            } elseif ($resource === 'agenda_groups') {
                $this->syncAgendaItems($id, (int) $validated['event_id'], $validated['title'], $validated['agenda_items']);
            }

            DB::commit();

            return Response::buildSuccess(message: ResponseConst::SUCCESS_MESSAGE_UPDATED);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__, 'resource' => $resource]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    public function delete(string $resource, int $id): array
    {
        DB::beginTransaction();
        try {
            $deleted = DB::table($this->resourceConfig($resource)['table'])
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

            if ($resource === 'agenda_groups') {
                DB::table(DatabaseConst::AGENDA_ITEM())
                    ->where('agenda_group_id', $id)
                    ->whereNull('deleted_at')
                    ->update([
                        'deleted_by' => Auth::user()?->id,
                        'deleted_at' => now(),
                    ]);
            }

            DB::commit();

            return Response::buildSuccess(message: ResponseConst::SUCCESS_MESSAGE_DELETED);
        } catch (Exception $exception) {
            DB::rollback();
            Log::error(message: $exception->getMessage(), context: ['method' => __METHOD__, 'resource' => $resource]);

            return Response::buildErrorService($exception->getMessage());
        }
    }

    /**
     * @param  array{table: string, columns: list<string>, search: list<string>, json: list<string>}  $config
     */
    private function resourceQuery(array $config, bool $withInactive = false, bool $withUnpublished = false): Builder
    {
        return DB::table($config['table'].' as r')
            ->join(DatabaseConst::EVENT().' as e', 'r.event_id', '=', 'e.id')
            ->select(array_map(fn (string $column): string => 'r.'.$column, $config['columns']))
            ->addSelect('e.name as event_name')
            ->whereNull('r.deleted_at')
            ->whereNull('e.deleted_at')
            ->when(! $withInactive, function (Builder $query): void {
                $query->where('r.is_active', true);
            })
            ->when(! $withUnpublished, function (Builder $query): void {
                $query->where('e.status', 'published');
            });
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
            'agenda_groups' => [
                'table' => DatabaseConst::AGENDA_GROUP(),
                'columns' => ['id', 'event_id', 'title', 'place', 'description', 'sort_order', 'is_active'],
                'search' => ['title', 'place', 'description'],
                'json' => [],
            ],
            'agenda_items' => [
                'table' => DatabaseConst::AGENDA_ITEM(),
                'columns' => ['id', 'event_id', 'agenda_group_id', 'material_id', 'title', 'category', 'starts_at', 'ends_at', 'place', 'description', 'sort_order', 'is_active'],
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
                'columns' => ['id', 'event_id', 'name', 'slug', 'ticket_type', 'price', 'compare_price', 'description_html', 'benefits_json', 'label', 'label_color', 'sales_starts_at', 'sales_ends_at', 'cta_label', 'cta_url', 'sort_order', 'is_active'],
                'search' => ['name', 'description_html', 'label'],
                'json' => ['benefits_json'],
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
     * @return array<string, mixed>
     */
    private function validatePayload(string $resource, Request $data, ?int $id = null): array
    {
        $commonRules = [
            'event_id' => ['required', 'integer', Rule::exists(DatabaseConst::VALIDATION_TABLE(DatabaseConst::EVENT()), 'id')->whereNull('deleted_at')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];

        $rules = match ($resource) {
            'sections' => [
                'section_key' => ['required', 'string', 'max:100', $this->uniqueForEvent(DatabaseConst::EVENT_SECTION(), 'section_key', $data, $id)],
                'section_type' => ['required', 'string', 'max:50'],
                'title' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'image_path' => $this->imageRules(),
                'settings_json' => ['nullable', 'json'],
            ],
            'speakers' => [
                'name' => ['required', 'string', 'max:200'],
                'photo_path' => $this->imageRules(),
                'job_title' => ['nullable', 'string', 'max:200'],
                'company' => ['nullable', 'string', 'max:200'],
                'speaker_group' => ['nullable', 'string', 'max:50'],
                'bio' => ['nullable', 'string'],
            ],
            'materials' => [
                'title' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'alpha_dash', 'max:255', $this->uniqueForEvent(DatabaseConst::MATERIAL(), 'slug', $data, $id)],
                'description' => ['nullable', 'string'],
                'label' => ['nullable', 'string', 'max:100'],
                'label_color' => ['nullable', 'string', 'max:20'],
                'speaker_id' => [
                    'required',
                    'integer',
                    Rule::exists(DatabaseConst::VALIDATION_TABLE(DatabaseConst::SPEAKER()), 'id')
                        ->where('event_id', $data->input('event_id'))
                        ->whereNull('deleted_at'),
                ],
            ],
            'agenda_groups' => [
                'title' => ['required', 'string', 'max:255'],
                'place' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'agenda_items' => ['required', 'array', 'min:1'],
                'agenda_items.*.id' => ['nullable', 'integer'],
                'agenda_items.*.material_id' => [
                    'required',
                    'integer',
                    Rule::exists(DatabaseConst::VALIDATION_TABLE(DatabaseConst::MATERIAL()), 'id')
                        ->where('event_id', $data->input('event_id'))
                        ->whereNull('deleted_at'),
                ],
                'agenda_items.*.starts_at' => ['required', 'date_format:H:i'],
                'agenda_items.*.ends_at' => ['nullable', 'date_format:H:i'],
            ],
            'agenda_items' => [
                'material_id' => [
                    'nullable',
                    'integer',
                    Rule::exists(DatabaseConst::VALIDATION_TABLE(DatabaseConst::MATERIAL()), 'id')
                        ->where('event_id', $data->input('event_id'))
                        ->whereNull('deleted_at'),
                ],
                'title' => ['nullable', 'string', 'max:255'],
                'category' => ['required', 'string', 'max:100'],
                'starts_at' => ['required', 'date'],
                'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
                'place' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
            ],
            'merchandises' => [
                'name' => ['required', 'string', 'max:200'],
                'photo_path' => $this->imageRules(),
                'description' => ['nullable', 'string'],
                'cta_label' => ['nullable', 'string', 'max:100'],
                'cta_url' => ['nullable', 'url', 'max:1000'],
            ],
            'tickets' => [
                'name' => ['required', 'string', 'max:200'],
                'slug' => ['required', 'alpha_dash', 'max:200', $this->uniqueForEvent(DatabaseConst::TICKET(), 'slug', $data, $id)],
                'ticket_type' => ['required', 'in:single,bundle'],
                'price' => ['required', 'numeric', 'min:0'],
                'compare_price' => ['nullable', 'numeric', 'min:0'],
                'description_html' => ['nullable', 'string'],
                'benefits' => ['nullable', 'array'],
                'benefits.*' => ['nullable', 'string', 'max:100'],
                'merchandise_addons' => ['nullable', 'array'],
                'merchandise_addons.*.merchandise_id' => [
                    'nullable',
                    'integer',
                    Rule::exists(DatabaseConst::VALIDATION_TABLE(DatabaseConst::MERCHANDISE()), 'id')
                        ->where('event_id', $data->input('event_id'))
                        ->whereNull('deleted_at'),
                ],
                'merchandise_addons.*.quantity' => ['nullable', 'integer', 'min:1'],
                'label' => ['nullable', 'string', 'max:100'],
                'label_color' => ['nullable', 'string', 'max:20'],
                'sales_starts_at' => ['nullable', 'date'],
                'sales_ends_at' => ['nullable', 'date', 'after_or_equal:sales_starts_at'],
                'cta_label' => ['nullable', 'string', 'max:100'],
                'cta_url' => ['required', 'url', 'max:1000'],
            ],
            'partners' => [
                'partner_type' => ['required', 'in:sponsor,media_partner,community_partner,supporting_partner'],
                'sponsor_category' => ['nullable', 'in:gold,silver,bronze'],
                'name' => ['required', 'string', 'max:200'],
                'logo_path' => $this->imageRules(),
                'website_url' => ['nullable', 'url', 'max:1000'],
            ],
        };

        $validator = Validator::make($data->all(), [...$commonRules, ...$rules]);

        if ($resource === 'agenda_groups') {
            $validator->after(function ($validator) use ($data): void {
                foreach ($data->input('agenda_items', []) as $index => $item) {
                    if (empty($item['starts_at']) || empty($item['ends_at'])) {
                        continue;
                    }

                    if ($item['ends_at'] < $item['starts_at']) {
                        $validator->errors()->add("agenda_items.{$index}.ends_at", 'Jam selesai harus setelah jam mulai.');
                    }
                }
            });
        }

        return $validator->validate();
    }

    private function uniqueForEvent(string $table, string $column, Request $data, ?int $id): mixed
    {
        return Rule::unique(DatabaseConst::VALIDATION_TABLE($table), $column)
            ->ignore($id)
            ->where(fn (Builder $query) => $query->where('event_id', $data->input('event_id')));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(string $resource, array $data, Request $request, ?object $current = null): array
    {
        $common = [
            'event_id' => (int) $data['event_id'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ];

        return [
            ...$common,
            ...match ($resource) {
                'sections' => [
                    'section_key' => $data['section_key'],
                    'section_type' => $data['section_type'],
                    'title' => $this->blankToNull($data['title'] ?? null),
                    'description' => $this->blankToNull($data['description'] ?? null),
                    'image_path' => $this->storedImagePath($request, 'image_path', $resource, $current?->image_path),
                    'settings_json' => $this->blankToNull($data['settings_json'] ?? null),
                ],
                'speakers' => [
                    'name' => $data['name'],
                    'photo_path' => $this->storedImagePath($request, 'photo_path', $resource, $current?->photo_path),
                    'job_title' => $this->blankToNull($data['job_title'] ?? null),
                    'company' => $this->blankToNull($data['company'] ?? null),
                    'speaker_group' => $this->blankToNull($data['speaker_group'] ?? null),
                    'bio' => $this->blankToNull($data['bio'] ?? null),
                ],
                'materials' => [
                    'title' => $data['title'],
                    'slug' => $data['slug'],
                    'description' => $this->blankToNull($data['description'] ?? null),
                    'label' => $this->blankToNull($data['label'] ?? null),
                    'label_color' => $this->blankToNull($data['label_color'] ?? null),
                ],
                'agenda_groups' => [
                    'title' => $data['title'],
                    'place' => $this->blankToNull($data['place'] ?? null),
                    'description' => $this->blankToNull($data['description'] ?? null),
                ],
                'agenda_items' => [
                    'material_id' => $this->blankToNull($data['material_id'] ?? null),
                    'title' => $this->blankToNull($data['title'] ?? null),
                    'category' => $data['category'],
                    'starts_at' => $this->dateTime($data['starts_at']),
                    'ends_at' => $this->dateTime($data['ends_at'] ?? null),
                    'place' => $this->blankToNull($data['place'] ?? null),
                    'description' => $this->blankToNull($data['description'] ?? null),
                ],
                'merchandises' => [
                    'name' => $data['name'],
                    'photo_path' => $this->storedImagePath($request, 'photo_path', $resource, $current?->photo_path),
                    'description' => $this->blankToNull($data['description'] ?? null),
                    'cta_label' => $this->blankToNull($data['cta_label'] ?? null),
                    'cta_url' => $this->blankToNull($data['cta_url'] ?? null),
                ],
                'tickets' => [
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'ticket_type' => $data['ticket_type'],
                    'price' => $data['price'],
                    'compare_price' => $this->blankToNull($data['compare_price'] ?? null),
                    'description_html' => $this->blankToNull($data['description_html'] ?? null),
                    'benefits_json' => $this->jsonList($data['benefits'] ?? []),
                    'label' => $this->blankToNull($data['label'] ?? null),
                    'label_color' => $this->blankToNull($data['label_color'] ?? null),
                    'sales_starts_at' => $this->dateTime($data['sales_starts_at'] ?? null),
                    'sales_ends_at' => $this->dateTime($data['sales_ends_at'] ?? null),
                    'cta_label' => $this->blankToNull($data['cta_label'] ?? null) ?? 'Beli Tiket',
                    'cta_url' => $data['cta_url'],
                ],
                'partners' => [
                    'partner_type' => $data['partner_type'],
                    'sponsor_category' => $this->blankToNull($data['sponsor_category'] ?? null),
                    'name' => $data['name'],
                    'logo_path' => $this->storedImagePath($request, 'logo_path', $resource, $current?->logo_path),
                    'website_url' => $this->blankToNull($data['website_url'] ?? null),
                ],
            },
        ];
    }

    /**
     * @return list<string>
     */
    private function imageRules(): array
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
    }

    private function storedImagePath(Request $request, string $field, string $resource, ?string $current = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $current;
        }

        $path = $request->file($field)->store("event-contents/{$resource}", 'public');

        if (! $path) {
            throw new RuntimeException('FAILED UPLOAD IMAGE');
        }

        return $path;
    }

    private function blankToNull(mixed $value): mixed
    {
        return $value === '' ? null : $value;
    }

    private function dateTime(?string $value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d H:i:s') : null;
    }

    private function time(?string $value): ?string
    {
        return $value ? Carbon::createFromFormat('H:i', $value)->format('H:i:s') : null;
    }

    private function normalizeRequest(string $resource, Request $data): void
    {
        if ($resource !== 'tickets') {
            return;
        }

        foreach (['price', 'compare_price'] as $field) {
            if ($data->filled($field)) {
                $data->merge([$field => preg_replace('/[^\d]/', '', (string) $data->input($field))]);
            }
        }
    }

    /**
     * @param  array<int, mixed>  $values
     */
    private function jsonList(array $values): string
    {
        $values = collect($values)
            ->map(fn (mixed $value): string => trim((string) $value))
            ->filter()
            ->values()
            ->all();

        return json_encode($values, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '[]';
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
            if ($column === 'benefits_json' && $record->{$column} === null) {
                $record->{$column} = [];
            }
        }

        return $record;
    }

    private function attachRelations(string $resource, object $record): object
    {
        if ($resource === 'materials') {
            $record->speaker = DB::table(DatabaseConst::SPEAKER().' as s')
                ->join(DatabaseConst::MATERIAL_SPEAKER().' as ms', 's.id', '=', 'ms.speaker_id')
                ->select(['s.id', 's.name', 's.photo_path', 's.job_title', 's.company', 's.speaker_group', 'ms.role', 'ms.sort_order'])
                ->where('ms.material_id', $record->id)
                ->whereNull('s.deleted_at')
                ->whereNull('ms.deleted_at')
                ->where('s.is_active', true)
                ->orderBy('ms.sort_order')
                ->first();
            $record->speaker_id = $record->speaker?->id;
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
        } elseif ($resource === 'agenda_groups') {
            $record->items = DB::table(DatabaseConst::AGENDA_ITEM().' as ai')
                ->leftJoin(DatabaseConst::MATERIAL().' as m', 'ai.material_id', '=', 'm.id')
                ->select([
                    'ai.id', 'ai.material_id', 'ai.title as item_title', 'm.title as material_title',
                    'm.slug as material_slug', 'm.label as material_label', 'm.label_color as material_label_color',
                    'ai.starts_at', 'ai.ends_at', 'ai.place', 'ai.description', 'ai.sort_order',
                ])
                ->where('ai.agenda_group_id', $record->id)
                ->whereNull('ai.deleted_at')
                ->where('ai.is_active', true)
                ->orderBy('ai.sort_order')
                ->orderBy('ai.id')
                ->get()
                ->map(function (object $row): object {
                    $material = $row->material_id ? (object) [
                        'id' => $row->material_id,
                        'title' => $row->material_title,
                        'slug' => $row->material_slug,
                        'label' => $row->material_label,
                        'label_color' => $row->material_label_color,
                    ] : null;

                    return (object) [
                        'id' => $row->id,
                        'title' => $row->item_title ?? $row->material_title,
                        'starts_at' => $row->starts_at,
                        'ends_at' => $row->ends_at,
                        'place' => $row->place,
                        'description' => $row->description,
                        'sort_order' => $row->sort_order,
                        'material' => $material,
                    ];
                });

            $this->attachAgendaSpeakers($record->items);
        } elseif ($resource === 'agenda_items') {
            if ($record->title === null && $record->material_id !== null) {
                $material = DB::table(DatabaseConst::MATERIAL())
                    ->select(['id', 'title', 'slug', 'label', 'label_color'])
                    ->where('id', $record->material_id)
                    ->whereNull('deleted_at')
                    ->first();
                $record->title = $material?->title;
                $record->material = $material;
            } else {
                $record->material = $record->material_id === null
                    ? null
                    : DB::table(DatabaseConst::MATERIAL())
                        ->select(['id', 'title', 'slug', 'label', 'label_color'])
                        ->where('id', $record->material_id)
                        ->whereNull('deleted_at')
                        ->where('is_active', true)
                        ->first();
            }

            $this->attachAgendaSpeakers(collect([$record]));
        }

        return $record;
    }

    /**
     * @param  array<int, array{merchandise_id?: int|string|null, quantity?: int|string|null}>  $addons
     */
    private function syncTicketMerchandises(int $ticketId, array $addons): void
    {
        $addons = collect($addons)
            ->filter(fn (array $addon): bool => ! empty($addon['merchandise_id']))
            ->mapWithKeys(fn (array $addon): array => [
                (int) $addon['merchandise_id'] => max(1, (int) ($addon['quantity'] ?? 1)),
            ]);
        $existing = DB::table(DatabaseConst::TICKET_MERCHANDISE())
            ->where('ticket_id', $ticketId)
            ->get()
            ->keyBy('merchandise_id');
        $now = now();
        $userId = Auth::user()?->id;

        DB::table(DatabaseConst::TICKET_MERCHANDISE())
            ->where('ticket_id', $ticketId)
            ->whereNotIn('merchandise_id', $addons->keys()->all())
            ->whereNull('deleted_at')
            ->update([
                'deleted_by' => $userId,
                'deleted_at' => $now,
            ]);

        $addons->each(function (int $quantity, int $merchandiseId) use ($existing, $now, $ticketId, $userId): void {
            if ($existing->has($merchandiseId)) {
                DB::table(DatabaseConst::TICKET_MERCHANDISE())
                    ->where('ticket_id', $ticketId)
                    ->where('merchandise_id', $merchandiseId)
                    ->update([
                        'quantity' => $quantity,
                        'updated_by' => $userId,
                        'updated_at' => $now,
                        'deleted_by' => null,
                        'deleted_at' => null,
                    ]);

                return;
            }

            DB::table(DatabaseConst::TICKET_MERCHANDISE())->insert([
                'ticket_id' => $ticketId,
                'merchandise_id' => $merchandiseId,
                'quantity' => $quantity,
                'created_by' => $userId,
                'created_at' => $now,
            ]);
        });
    }

    private function syncMaterialSpeaker(int $materialId, int $speakerId): void
    {
        $now = now();
        $userId = Auth::user()?->id;

        DB::table(DatabaseConst::MATERIAL_SPEAKER())
            ->where('material_id', $materialId)
            ->where('speaker_id', '!=', $speakerId)
            ->whereNull('deleted_at')
            ->update([
                'deleted_by' => $userId,
                'deleted_at' => $now,
            ]);

        $existing = DB::table(DatabaseConst::MATERIAL_SPEAKER())
            ->where('material_id', $materialId)
            ->where('speaker_id', $speakerId)
            ->exists();

        if ($existing) {
            DB::table(DatabaseConst::MATERIAL_SPEAKER())
                ->where('material_id', $materialId)
                ->where('speaker_id', $speakerId)
                ->update([
                    'role' => 'speaker',
                    'sort_order' => 0,
                    'updated_by' => $userId,
                    'updated_at' => $now,
                    'deleted_by' => null,
                    'deleted_at' => null,
                ]);

            return;
        }

        DB::table(DatabaseConst::MATERIAL_SPEAKER())->insert([
            'material_id' => $materialId,
            'speaker_id' => $speakerId,
            'role' => 'speaker',
            'sort_order' => 0,
            'created_by' => $userId,
            'created_at' => $now,
        ]);
    }

    /**
     * @param  list<array{id?: int|string|null, material_id: int|string, starts_at: string, ends_at?: string|null}>  $items
     */
    private function syncAgendaItems(int $agendaGroupId, int $eventId, string $groupTitle, array $items): void
    {
        $existing = DB::table(DatabaseConst::AGENDA_ITEM())
            ->where('agenda_group_id', $agendaGroupId)
            ->get()
            ->keyBy('id');
        $itemIds = collect($items)->pluck('id')->filter()->map(fn (mixed $id): int => (int) $id)->all();
        $now = now();
        $userId = Auth::user()?->id;

        DB::table(DatabaseConst::AGENDA_ITEM())
            ->where('agenda_group_id', $agendaGroupId)
            ->whereNotIn('id', $itemIds)
            ->whereNull('deleted_at')
            ->update(['deleted_by' => $userId, 'deleted_at' => $now]);

        foreach (array_values($items) as $index => $item) {
            $payload = [
                'event_id' => $eventId,
                'agenda_group_id' => $agendaGroupId,
                'material_id' => (int) $item['material_id'],
                'title' => null,
                'category' => $groupTitle,
                'starts_at' => $this->time($item['starts_at']),
                'ends_at' => $this->time($item['ends_at'] ?? null),
                'place' => null,
                'description' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
            ];

            if (! empty($item['id']) && $existing->has((int) $item['id'])) {
                DB::table(DatabaseConst::AGENDA_ITEM())
                    ->where('id', $item['id'])
                    ->update([...$payload, 'updated_by' => $userId, 'updated_at' => $now, 'deleted_by' => null, 'deleted_at' => null]);

                continue;
            }

            DB::table(DatabaseConst::AGENDA_ITEM())->insert([...$payload, 'created_by' => $userId, 'created_at' => $now]);
        }
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

    private function attachSpeakerMaterials(Collection|AbstractPaginator $records): void
    {
        $speakers = $records instanceof AbstractPaginator
            ? $records->getCollection()
            : $records;
        $speakerIds = $speakers->pluck('id')->filter()->unique()->values();

        if ($speakerIds->isEmpty()) {
            $speakers->each(function (object $speaker): void {
                $speaker->materials = collect();
            });

            return;
        }

        $materialsBySpeaker = DB::table(DatabaseConst::MATERIAL().' as m')
            ->join(DatabaseConst::MATERIAL_SPEAKER().' as ms', 'm.id', '=', 'ms.material_id')
            ->select(['ms.speaker_id', 'm.id', 'm.title', 'm.slug', 'm.label', 'm.label_color', 'ms.role', 'ms.sort_order'])
            ->whereIn('ms.speaker_id', $speakerIds)
            ->whereNull('m.deleted_at')
            ->whereNull('ms.deleted_at')
            ->where('m.is_active', true)
            ->orderBy('ms.sort_order')
            ->get()
            ->groupBy('speaker_id');

        $speakers->each(function (object $speaker) use ($materialsBySpeaker): void {
            $speaker->materials = $materialsBySpeaker
                ->get($speaker->id, collect())
                ->map(function (object $material): object {
                    unset($material->speaker_id);

                    return $material;
                })
                ->values();
        });
    }

    private function attachMaterialSpeakers(Collection|AbstractPaginator $records): void
    {
        $materials = $records instanceof AbstractPaginator
            ? $records->getCollection()
            : $records;
        $materialIds = $materials->pluck('id')->filter()->unique()->values();

        if ($materialIds->isEmpty()) {
            $materials->each(function (object $material): void {
                $material->speaker_name = null;
                $material->speaker = null;
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

        $materials->each(function (object $material) use ($speakersByMaterial): void {
            $firstSpeaker = $speakersByMaterial->get($material->id, collect())->first();
            $material->speaker_name = $firstSpeaker?->name;
            $material->speaker = $firstSpeaker;
        });
    }

    private function attachAgendaGroupItems(Collection|AbstractPaginator $records): void
    {
        $groups = $records instanceof AbstractPaginator
            ? $records->getCollection()
            : $records;
        $groupIds = $groups->pluck('id')->filter()->unique()->values();

        if ($groupIds->isEmpty()) {
            $groups->each(function (object $group): void {
                $group->items = collect();
            });

            return;
        }

        $items = DB::table(DatabaseConst::AGENDA_ITEM().' as ai')
            ->leftJoin(DatabaseConst::MATERIAL().' as m', 'ai.material_id', '=', 'm.id')
            ->select([
                'ai.id', 'ai.agenda_group_id', 'ai.material_id', 'ai.title as item_title',
                'm.title as material_title', 'm.slug as material_slug', 'm.label as material_label',
                'm.label_color as material_label_color', 'ai.starts_at', 'ai.ends_at',
                'ai.place', 'ai.description', 'ai.sort_order',
            ])
            ->whereIn('ai.agenda_group_id', $groupIds)
            ->whereNull('ai.deleted_at')
            ->where('ai.is_active', true)
            ->orderBy('ai.sort_order')
            ->orderBy('ai.id')
            ->get()
            ->map(function (object $row): object {
                $material = $row->material_id ? (object) [
                    'id' => $row->material_id,
                    'title' => $row->material_title,
                    'slug' => $row->material_slug,
                    'label' => $row->material_label,
                    'label_color' => $row->material_label_color,
                ] : null;

                return (object) [
                    'id' => $row->id,
                    'agenda_group_id' => $row->agenda_group_id,
                    'material_id' => $row->material_id,
                    'title' => $row->item_title ?? $row->material_title,
                    'starts_at' => $row->starts_at,
                    'ends_at' => $row->ends_at,
                    'place' => $row->place,
                    'description' => $row->description,
                    'sort_order' => $row->sort_order,
                    'material' => $material,
                ];
            });

        $this->attachAgendaSpeakers($items);

        $itemsByGroup = $items->groupBy('agenda_group_id');

        $groups->each(function (object $group) use ($itemsByGroup): void {
            $groupItems = $itemsByGroup
                ->get($group->agenda_group_id ?? $group->id, collect())
                ->map(function (object $item): object {
                    $cloned = clone $item;
                    unset($cloned->agenda_group_id);

                    return $cloned;
                })
                ->values();

            $group->items = $groupItems;
        });
    }
}
