@extends('_admin._layout.app')

@section('title', 'Event')

@section('content')
    <x-admin.page-header :title="'Data ' . $page['title']" subtitle="Kelola event landing page">
        <x-admin.button href="{{ route('admin.events.add') }}">
            @include('_admin._layout.icons.add')
            Tambah Event
        </x-admin.button>
    </x-admin.page-header>

    <div class="mb-6">
        <form action="{{ route('admin.events.index') }}" method="GET" navigate-form class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-64">
                <x-admin.input :label="null" name="keywords" :value="$keywords ?? ''" placeholder="Cari event..." size="sm" />
            </div>
            <div class="w-full sm:w-48">
                <x-admin.select :label="null" name="status" :options="['' => 'Semua Status'] + $statuses" :value="$status ?? ''" size="sm" />
            </div>
            <div class="flex items-center gap-2">
                <x-admin.button type="submit" size="sm">
                    @include('_admin._layout.icons.search')
                    Cari
                </x-admin.button>
                @if (! empty($keywords) || ! empty($status))
                    <x-admin.button href="{{ route('admin.events.index') }}" size="sm" color="outline-secondary">
                        @include('_admin._layout.icons.reset')
                        Reset
                    </x-admin.button>
                @endif
            </div>
        </form>
    </div>

    <x-admin.table.wrapper>
        <x-admin.table>
            <x-admin.table.thead>
                <tr>
                    <x-admin.table.th>Nama</x-admin.table.th>
                    <x-admin.table.th>Slug</x-admin.table.th>
                    <x-admin.table.th>Tanggal</x-admin.table.th>
                    <x-admin.table.th>Status</x-admin.table.th>
                    <x-admin.table.th align="end"></x-admin.table.th>
                </tr>
            </x-admin.table.thead>
            <x-admin.table.tbody>
                @forelse($data as $d)
                    <x-admin.table.tr>
                        <x-admin.table.td>
                            <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $d->name }}</span>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            <span class="text-xs font-mono text-gray-500 dark:text-neutral-400">{{ $d->slug }}</span>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            <span class="text-sm text-gray-600 dark:text-neutral-400">{{ $d->starts_at ?? '-' }}</span>
                        </x-admin.table.td>
                        <x-admin.table.td>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-neutral-300">
                                {{ $statuses[$d->status] ?? $d->status }}
                            </span>
                        </x-admin.table.td>
                        <x-admin.table.td innerClass="px-6 py-1.5 flex items-center justify-end gap-x-1">
                            <a navigate class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-100 hover:border-gray-300 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:text-white dark:hover:border-neutral-600 dark:focus:bg-neutral-700 transition-colors"
                                href="{{ route('admin.events.detail', $d->id) }}" title="Detail">
                                @include('_admin._layout.icons.eye')
                            </a>
                            <a navigate class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:border-blue-300 focus:outline-none focus:bg-blue-100 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-800/80 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-800/50 dark:hover:border-blue-700 dark:hover:text-blue-300 dark:focus:bg-blue-800/50 transition-colors"
                                href="{{ route('admin.events.update', $d->id) }}" title="Edit">
                                @include('_admin._layout.icons.pencil')
                            </a>
                            <button type="button" class="inline-flex items-center justify-center size-8 text-sm font-semibold rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:bg-red-100 disabled:opacity-50 disabled:pointer-events-none dark:border-red-800/80 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50 dark:hover:border-red-700 dark:hover:text-red-300 dark:focus:bg-red-800/50 transition-colors cursor-pointer"
                                title="Hapus" data-hs-overlay="#delete-modal" onclick="setDeleteData({{ $d->id }}, @js($d->name))">
                                @include('_admin._layout.icons.trash')
                            </button>
                        </x-admin.table.td>
                    </x-admin.table.tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                            <x-admin.empty-state />
                        </td>
                    </tr>
                @endforelse
            </x-admin.table.tbody>
        </x-admin.table>
        @if (count($data) > 0 && $data->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex justify-end">{{ $data->links() }}</div>
            </div>
        @endif
    </x-admin.table.wrapper>

    <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-md sm:w-full m-3 sm:mx-auto">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-1">Hapus Event</h3>
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
            document.getElementById('delete-form').action = `/admin/events/delete/${id}`;
        }
    </script>
@endpush
