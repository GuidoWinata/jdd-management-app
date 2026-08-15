<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\EventContentUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventContentController extends Controller
{
    protected array $page = [
        'route' => 'event-contents',
        'title' => 'Konten Event',
    ];

    protected string $baseRedirect;

    private const RESOURCES = [
        'sections' => ['title' => 'Section Event', 'primary' => 'title'],
        'speakers' => ['title' => 'Speaker', 'primary' => 'name'],
        'materials' => ['title' => 'Materi', 'primary' => 'title'],
        'agenda_groups' => ['title' => 'Agenda', 'primary' => 'title'],
        'merchandises' => ['title' => 'Merchandise', 'primary' => 'name'],
        'tickets' => ['title' => 'Tiket', 'primary' => 'name'],
        'partners' => ['title' => 'Partner', 'primary' => 'name'],
    ];

    public function __construct(
        protected EventContentUsecase $usecase
    ) {
        $this->baseRedirect = 'admin/'.$this->page['route'];
    }

    public function index(string $resource, Request $request): View|RedirectResponse|Response
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $data = $this->usecase->getAll($resource, [
            'event_id' => $request->get('event_id'),
            'keywords' => $request->get('keywords'),
            'partner_type' => $request->get('partner_type'),
            'sponsor_category' => $request->get('sponsor_category'),
            'speaker_group' => $request->get('speaker_group'),
            'with_inactive' => true,
            'with_unpublished' => true,
        ]);
        $data = $data['data']['list'] ?? [];

        $partnerTypes = [
            '' => 'Semua Tipe Partner',
            'sponsor' => 'Sponsor',
            'media_partner' => 'Media Partner',
            'community_partner' => 'Community Partner',
            'supporting_partner' => 'Supporting Partner',
        ];

        $sponsorCategories = [
            '' => 'Semua Kategori',
            'gold' => 'Gold',
            'silver' => 'Silver',
            'bronze' => 'Bronze',
        ];

        $speakerGroups = [
            '' => 'Semua Group Speaker',
            'keynote' => 'Keynote',
            'lightning' => 'Lightning',
            'workshop' => 'Workshop',
        ];

        return view('_admin.event-contents.index', [
            'data' => $data,
            'page' => $this->resourcePage($resource),
            'resource' => $resource,
            'meta' => self::RESOURCES[$resource],
            'events' => $this->eventOptions(),
            'keywords' => $request->get('keywords'),
            'event_id' => $request->get('event_id'),
            'partner_type' => $request->get('partner_type'),
            'sponsor_category' => $request->get('sponsor_category'),
            'speaker_group' => $request->get('speaker_group'),
            'partner_types' => $partnerTypes,
            'sponsor_categories' => $sponsorCategories,
            'speaker_groups' => $speakerGroups,
            'total_count' => is_object($data) && method_exists($data, 'total') ? $data->total() : count($data),
        ]);
    }

    public function add(string $resource): View|RedirectResponse|Response
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        return view('_admin.event-contents.add', [
            'page' => $this->resourcePage($resource),
            'resource' => $resource,
            'meta' => self::RESOURCES[$resource],
            'fields' => $this->fields($resource),
        ]);
    }

    public function doCreate(string $resource, Request $request): RedirectResponse
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $process = $this->usecase->create(resource: $resource, data: $request);

        if ($process['success']) {
            return redirect()
                ->route($this->routeName($resource, 'index'))
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function detail(int $id, string $resource): View|RedirectResponse|Response
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $data = $this->usecase->getByID(resource: $resource, id: $id, onlyActive: false, onlyPublished: false);

        if (empty($data['data'])) {
            return redirect()
                ->route($this->routeName($resource, 'index'))
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_admin.event-contents.detail', [
            'data' => (object) $data['data'],
            'page' => $this->resourcePage($resource),
            'resource' => $resource,
            'meta' => self::RESOURCES[$resource],
            'fields' => $this->fields($resource),
        ]);
    }

    public function update(int $id, string $resource): View|RedirectResponse|Response
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $data = $this->usecase->getByID(resource: $resource, id: $id, onlyActive: false, onlyPublished: false);

        if (empty($data['data'])) {
            return redirect()
                ->route($this->routeName($resource, 'index'))
                ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_admin.event-contents.update', [
            'data' => (object) $data['data'],
            'page' => $this->resourcePage($resource),
            'resource' => $resource,
            'meta' => self::RESOURCES[$resource],
            'fields' => $this->fields($resource),
        ]);
    }

    public function doUpdate(int $id, Request $request, string $resource): RedirectResponse
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $process = $this->usecase->update(resource: $resource, data: $request, id: $id);

        if ($process['success']) {
            return redirect()
                ->route($this->routeName($resource, 'index'))
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id, string $resource): RedirectResponse
    {
        if (! $this->hasResource($resource)) {
            return $this->invalidResourceRedirect();
        }

        $process = $this->usecase->delete(resource: $resource, id: $id);

        if ($process['success']) {
            return redirect()
                ->route($this->routeName($resource, 'index'))
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    private function hasResource(string $resource): bool
    {
        return array_key_exists($resource, self::RESOURCES);
    }

    private function invalidResourceRedirect(): RedirectResponse
    {
        return redirect()
            ->route('admin.event_sections.index')
            ->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    private function resourcePage(string $resource): array
    {
        return [
            ...$this->page,
            'route_prefix' => $this->routeName($resource),
            'title' => self::RESOURCES[$resource]['title'],
        ];
    }

    private function routeName(string $resource, ?string $action = null): string
    {
        $prefix = match ($resource) {
            'sections' => 'admin.event_sections',
            'speakers' => 'admin.event_speakers',
            'materials' => 'admin.event_materials',
            'agenda_groups' => 'admin.event_agenda_groups',
            'merchandises' => 'admin.event_merchandises',
            'tickets' => 'admin.event_tickets',
            'partners' => 'admin.event_partners',
        };

        return $action ? $prefix.'.'.$action : $prefix;
    }

    private function eventOptions(): array
    {
        return collect($this->usecase->getEventOptions()['data'] ?? [])
            ->pluck('name', 'id')
            ->toArray();
    }

    private function materialOptions(): array
    {
        return collect($this->usecase->getMaterialOptions()['data'] ?? [])
            ->mapWithKeys(fn (object $material): array => [
                $material->id => $material->title.' - '.$material->event_name,
            ])
            ->toArray();
    }

    private function speakerOptions(): array
    {
        return collect($this->usecase->getSpeakerOptions()['data'] ?? [])
            ->mapWithKeys(fn (object $speaker): array => [
                $speaker->id => trim($speaker->name.' - '.($speaker->job_title ?? $speaker->company ?? $speaker->event_name)),
            ])
            ->toArray();
    }

    private function merchandiseOptions(): array
    {
        return collect($this->usecase->getMerchandiseOptions()['data'] ?? [])
            ->mapWithKeys(fn (object $merchandise): array => [
                $merchandise->id => $merchandise->name.' - '.$merchandise->event_name,
            ])
            ->toArray();
    }

    private function fields(string $resource): array
    {
        return match ($resource) {
            'sections' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'section_key', 'label' => 'Key', 'type' => 'text', 'required' => true],
                ['name' => 'section_type', 'label' => 'Tipe', 'type' => 'text', 'required' => true],
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text'],
                ['name' => 'image_path', 'label' => 'Gambar', 'type' => 'file'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'editor'],
            ],
            'speakers' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'photo_path', 'label' => 'Foto', 'type' => 'file'],
                ['name' => 'job_title', 'label' => 'Jabatan', 'type' => 'text'],
                ['name' => 'company', 'label' => 'Perusahaan', 'type' => 'text'],
                ['name' => 'speaker_group', 'label' => 'Group Speaker', 'type' => 'select', 'options' => [
                    '' => '-',
                    'keynote' => 'Keynote',
                    'lightning' => 'Lightning',
                    'workshop' => 'Workshop',
                ]],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'bio', 'label' => 'Bio', 'type' => 'textarea'],
            ],
            'materials' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'speaker_id', 'label' => 'Pemateri', 'type' => 'select', 'options' => ['' => '- Pilih pemateri -'] + $this->speakerOptions(), 'required' => true, 'select2' => true],
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'required' => true],
                ['name' => 'label', 'label' => 'Label', 'type' => 'text'],
                ['name' => 'label_color', 'label' => 'Warna Label', 'type' => 'text'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'agenda_groups' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'title', 'label' => 'Nama Section Agenda', 'type' => 'text', 'required' => true],
                ['name' => 'place', 'label' => 'Tempat', 'type' => 'text'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'agenda_items', 'label' => 'Daftar Materi', 'type' => 'agenda-items', 'options' => $this->materialOptions()],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'merchandises' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'photo_path', 'label' => 'Foto', 'type' => 'file'],
                ['name' => 'cta_label', 'label' => 'Label CTA', 'type' => 'text'],
                ['name' => 'cta_url', 'label' => 'URL CTA', 'type' => 'url'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ],
            'tickets' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'required' => true],
                ['name' => 'ticket_type', 'label' => 'Tipe', 'type' => 'select', 'options' => ['single' => 'Single', 'bundle' => 'Bundle'], 'required' => true],
                ['name' => 'price', 'label' => 'Harga', 'type' => 'money', 'required' => true],
                ['name' => 'compare_price', 'label' => 'Harga Coret', 'type' => 'money'],
                ['name' => 'label', 'label' => 'Label', 'type' => 'text'],
                ['name' => 'label_color', 'label' => 'Warna Label', 'type' => 'text'],
                ['name' => 'sales_starts_at', 'label' => 'Penjualan Mulai', 'type' => 'datetime-local'],
                ['name' => 'sales_ends_at', 'label' => 'Penjualan Selesai', 'type' => 'datetime-local'],
                ['name' => 'cta_label', 'label' => 'Label CTA', 'type' => 'text'],
                ['name' => 'cta_url', 'label' => 'URL CTA', 'type' => 'url', 'required' => true],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
                ['name' => 'benefits', 'label' => 'Benefit', 'type' => 'benefits'],
                ['name' => 'merchandise_addons', 'label' => 'Merchandise Addon', 'type' => 'merchandise-addons', 'options' => $this->merchandiseOptions()],
                ['name' => 'description_html', 'label' => 'Deskripsi', 'type' => 'editor'],
            ],
            'partners' => [
                ['name' => 'event_id', 'label' => 'Event', 'type' => 'select', 'options' => $this->eventOptions(), 'required' => true, 'select2' => true],
                ['name' => 'partner_type', 'label' => 'Tipe Partner', 'type' => 'select', 'options' => [
                    'sponsor' => 'Sponsor',
                    'media_partner' => 'Media Partner',
                    'community_partner' => 'Community Partner',
                    'supporting_partner' => 'Supporting Partner',
                ], 'required' => true],
                ['name' => 'sponsor_category', 'label' => 'Kategori Sponsor', 'type' => 'select', 'options' => ['' => '-', 'gold' => 'Gold', 'silver' => 'Silver', 'bronze' => 'Bronze']],
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text', 'required' => true],
                ['name' => 'logo_path', 'label' => 'Logo', 'type' => 'file'],
                ['name' => 'website_url', 'label' => 'Website', 'type' => 'url'],
                ['name' => 'sort_order', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Aktif', 'type' => 'checkbox'],
            ],
            default => [],
        };
    }
}
