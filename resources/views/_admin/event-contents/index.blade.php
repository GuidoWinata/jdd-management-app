@extends('_admin._layout.app')

@section('title', $meta['title'])

@section('content')
    <x-admin.page-header :title="'Data ' . $meta['title']" subtitle="Kelola konten event">
        <x-admin.button href="{{ route($page['route_prefix'] . '.add') }}">
            @include('_admin._layout.icons.add')
            Tambah
        </x-admin.button>
    </x-admin.page-header>

    <div class="mb-6">
        <form action="{{ route($page['route_prefix'] . '.index') }}" method="GET" navigate-form
            class="flex flex-wrap items-center gap-3">
            <div class="w-full sm:w-60">
                <x-admin.input :label="null" name="keywords" :value="$keywords ?? ''" placeholder="Cari data..." size="sm" />
            </div>
            <div class="w-full sm:w-56">
                <x-admin.select :label="null" name="event_id" :options="['' => 'Semua Event'] + $events" :value="$event_id ?? ''" size="sm" />
            </div>
            @if ($resource === 'speakers')
                <div class="w-full sm:w-52">
                    <x-admin.select :label="null" name="speaker_group" :options="$speaker_groups ?? []" :value="$speaker_group ?? ''" size="sm" />
                </div>
            @endif
            @if ($resource === 'partners')
                <div class="w-full sm:w-52">
                    <x-admin.select :label="null" name="partner_type" :options="$partner_types ?? []" :value="$partner_type ?? ''" size="sm" />
                </div>
                <div class="w-full sm:w-48">
                    <x-admin.select :label="null" name="sponsor_category" :options="$sponsor_categories ?? []" :value="$sponsor_category ?? ''" size="sm" />
                </div>
            @endif
            <div class="flex items-center gap-2">
                <x-admin.button type="submit" size="sm">
                    @include('_admin._layout.icons.search')
                    Cari
                </x-admin.button>
                @if (! empty($keywords) || ! empty($event_id) || ! empty($partner_type) || ! empty($sponsor_category) || ! empty($speaker_group))
                    <x-admin.button href="{{ route($page['route_prefix'] . '.index') }}" size="sm" color="outline-secondary">
                        @include('_admin._layout.icons.reset')
                        Reset
                    </x-admin.button>
                @endif
            </div>
        </form>
    </div>

    @if ($resource === 'partners')
        <div class="mb-6">
            <div class="p-4 rounded-2xl border border-gray-200/80 bg-white dark:bg-neutral-800 dark:border-neutral-700 shadow-xs max-w-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                            @if (!empty($sponsor_category))
                                Total Sponsor {{ ucfirst($sponsor_category) }}
                            @elseif (!empty($partner_type))
                                Total {{ $partner_types[$partner_type] ?? ucwords(str_replace('_', ' ', $partner_type)) }}
                            @else
                                Total Partner
                            @endif
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-neutral-100 mt-1">
                            {{ $total_count ?? (is_object($data) && method_exists($data, 'total') ? $data->total() : count($data)) }}
                            <span class="text-xs font-normal text-gray-500 dark:text-neutral-400">data</span>
                        </p>
                    </div>
                    <div class="size-11 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center shrink-0">
                        @include('_admin._layout.icons.sidebar.hand-shake')
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-admin.table.wrapper>
        <x-admin.table>
            <x-admin.table.thead>
                <tr>
                    <x-admin.table.th>{{ $meta['title'] }}</x-admin.table.th>
                    @if ($resource === 'speakers')
                        <x-admin.table.th>Group Speaker</x-admin.table.th>
                    @endif
                    @if ($resource === 'materials')
                        <x-admin.table.th>Pemateri</x-admin.table.th>
                    @endif
                    @if ($resource === 'partners')
                        <x-admin.table.th>Tipe Partner</x-admin.table.th>
                        <x-admin.table.th>Kategori Sponsor</x-admin.table.th>
                    @endif
                    <x-admin.table.th>Event</x-admin.table.th>
                    <x-admin.table.th>Status</x-admin.table.th>
                    <x-admin.table.th align="end"></x-admin.table.th>
                </tr>
            </x-admin.table.thead>
            <x-admin.table.tbody>
                @forelse($data as $d)
                    <x-admin.table.tr>
                        <x-admin.table.td>
                            <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                {{ $d->{$meta['primary']} ?? '-' }}
                            </span>
                        </x-admin.table.td>
                        @if ($resource === 'speakers')
                            <x-admin.table.td>
                                @php
                                    $speakerGroupStyles = [
                                        'keynote' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
                                        'lightning' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                                        'workshop' => 'bg-teal-50 text-teal-700 border-teal-200 dark:bg-teal-900/30 dark:text-teal-400 dark:border-teal-800',
                                    ];
                                    $groupStyle = $speakerGroupStyles[strtolower($d->speaker_group ?? '')] ?? 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-neutral-800 dark:text-neutral-300 dark:border-neutral-700';
                                @endphp
                                @if (!empty($d->speaker_group))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium border {{ $groupStyle }}">
                                        {{ ucfirst($d->speaker_group) }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-neutral-500 text-xs">-</span>
                                @endif
                            </x-admin.table.td>
                        @endif
                        @if ($resource === 'materials')
                            <x-admin.table.td>
                                <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">
                                    {{ $d->speaker_name ?? '-' }}
                                </span>
                            </x-admin.table.td>
                        @endif
                        @if ($resource === 'partners')
                            <x-admin.table.td>
                                @php
                                    $partnerTypeLabels = [
                                        'sponsor' => 'Sponsor',
                                        'media_partner' => 'Media Partner',
                                        'community_partner' => 'Community Partner',
                                        'supporting_partner' => 'Supporting Partner',
                                    ];
                                    $partnerTypeStyles = [
                                        'sponsor' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                                        'media_partner' => 'bg-purple-50 text-purple-700 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
                                        'community_partner' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                                        'supporting_partner' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-900/30 dark:text-sky-400 dark:border-sky-800',
                                    ];
                                    $typeStyle = $partnerTypeStyles[$d->partner_type ?? ''] ?? 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-neutral-800 dark:text-neutral-300 dark:border-neutral-700';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium border {{ $typeStyle }}">
                                    {{ $partnerTypeLabels[$d->partner_type ?? ''] ?? ($d->partner_type ?: '-') }}
                                </span>
                            </x-admin.table.td>
                            <x-admin.table.td>
                                @if (!empty($d->sponsor_category))
                                    @if (strtolower($d->sponsor_category) === 'gold')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-300 shadow-xs dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-700/60">
                                            <span class="size-1.5 rounded-full bg-amber-500 shadow-xs"></span>
                                            Gold
                                        </span>
                                    @elseif (strtolower($d->sponsor_category) === 'silver')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-300 shadow-xs dark:bg-slate-800 dark:text-slate-200 dark:border-slate-600">
                                            <span class="size-1.5 rounded-full bg-slate-400 shadow-xs"></span>
                                            Silver
                                        </span>
                                    @elseif (strtolower($d->sponsor_category) === 'bronze')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-50 text-orange-800 border border-orange-300 shadow-xs dark:bg-orange-950/40 dark:text-orange-300 dark:border-orange-800/60">
                                            <span class="size-1.5 rounded-full bg-orange-500 shadow-xs"></span>
                                            Bronze
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300">
                                            {{ ucfirst($d->sponsor_category) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 dark:text-neutral-500 text-xs">-</span>
                                @endif
                            </x-admin.table.td>
                        @endif
                        <x-admin.table.td>
                            <span class="text-sm text-gray-600 dark:text-neutral-400">{{ $d->event_name ?? $d->event_id }}</span>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            @if ($d->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Nonaktif</span>
                            @endif
                        </x-admin.table.td>
                        <x-admin.table.td innerClass="px-6 py-1.5 flex items-center justify-end gap-x-1">
                            <a navigate class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-100 hover:border-gray-300 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-white dark:hover:border-neutral-600 dark:focus:bg-neutral-700 transition-colors"
                                href="{{ route($page['route_prefix'] . '.detail', $d->id) }}" title="Detail">
                                @include('_admin._layout.icons.eye')
                            </a>
                            <a navigate class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:border-blue-300 focus:outline-none focus:bg-blue-100 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-800/80 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-800/50 dark:hover:border-blue-700 dark:hover:text-blue-300 dark:focus:bg-blue-800/50 transition-colors"
                                href="{{ route($page['route_prefix'] . '.update', $d->id) }}" title="Edit">
                                @include('_admin._layout.icons.pencil')
                            </a>
                            <button type="button" class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:bg-red-100 disabled:opacity-50 disabled:pointer-events-none dark:border-red-800/80 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50 dark:hover:border-red-700 dark:hover:text-red-300 dark:focus:bg-red-800/50 transition-colors cursor-pointer"
                                title="Hapus" data-hs-overlay="#delete-modal"
                                onclick="setDeleteData({{ $d->id }}, @js($d->{$meta['primary']} ?? $meta['title']))">
                                @include('_admin._layout.icons.trash')
                            </button>
                        </x-admin.table.td>
                    </x-admin.table.tr>
                @empty
                    @php
                        $totalCols = 4;
                        if ($resource === 'materials' || $resource === 'speakers') {
                            $totalCols += 1;
                        }
                        if ($resource === 'partners') {
                            $totalCols += 2;
                        }
                    @endphp
                    <tr>
                        <td colspan="{{ $totalCols }}" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                            <x-admin.empty-state />
                        </td>
                    </tr>
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table>
        @if (count($data) > 0 && is_object($data) && method_exists($data, 'hasPages') && $data->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex justify-end">{{ $data->links() }}</div>
            </div>
        @endif
    </x-admin.table.wrapper>

    <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-md sm:w-full m-3 sm:mx-auto">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-1">Hapus {{ $meta['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mb-6">Apakah Anda yakin ingin menghapus <strong id="delete-name"></strong>?</p>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-center gap-3">
                            <button type="button" data-hs-overlay="#delete-modal" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 cursor-pointer">Batal</button>
                            <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700 cursor-pointer">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setDeleteData(id, name) {
            document.getElementById('delete-name').textContent = name;
            const deleteUrl = @js(route($page['route_prefix'] . '.delete', '__ID__'));
            document.getElementById('delete-form').action = deleteUrl.replace('__ID__', id);
        }
    </script>
@endpush
